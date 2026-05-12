package main

import (
	"context"
	"database/sql"
	"encoding/json"
	"fmt"
	"log"
	"math/rand"
	"net/http"
	"os"
	"time"

	"github.com/go-redis/redis/v8"
	_ "github.com/go-sql-driver/mysql"
	"github.com/gorilla/mux"
	"github.com/rs/cors"
	"golang.org/x/crypto/bcrypt"
)

var (
	db  *sql.DB
	rdb *redis.Client
	ctx = context.Background()
)

type User struct {
	Username string `json:"username"`
	Password string `json:"password"`
	Phone    string `json:"phone"`
	Pattern  string `json:"pattern"`
}

func initDB() {
	var err error
	dsn := fmt.Sprintf("%s:%s@tcp(%s:3306)/%s",
		os.Getenv("DB_USER"),
		os.Getenv("DB_PASSWORD"),
		os.Getenv("DB_HOST"),
		os.Getenv("DB_NAME"),
	)
	
	for i := 0; i < 10; i++ {
		db, err = sql.Open("mysql", dsn)
		if err == nil {
			err = db.Ping()
			if err == nil {
				log.Println("Connected to MySQL database")
				return
			}
		}
		log.Println("Waiting for database...")
		time.Sleep(3 * time.Second)
	}
	log.Fatalf("Could not connect to database: %v", err)
}

func initRedis() {
	rdb = redis.NewClient(&redis.Options{
		Addr: os.Getenv("REDIS_HOST"),
	})
	if err := rdb.Ping(ctx).Err(); err != nil {
		log.Fatalf("Could not connect to Redis: %v", err)
	}
	log.Println("Connected to Redis")
}

func main() {
	initDB()
	initRedis()
	defer db.Close()

	r := mux.NewRouter()

	api := r.PathPrefix("/api").Subrouter()
	api.HandleFunc("/signup", signupHandler).Methods("POST")
	api.HandleFunc("/login/step1", loginStep1Handler).Methods("POST")
	api.HandleFunc("/login/step2", loginStep2Handler).Methods("POST")
	api.HandleFunc("/login/step3", loginStep3Handler).Methods("POST")

	c := cors.New(cors.Options{
		AllowedOrigins: []string{"*"},
		AllowedMethods: []string{"GET", "POST", "OPTIONS"},
		AllowedHeaders: []string{"Content-Type"},
	})

	handler := c.Handler(r)
	
	log.Println("Backend server starting on port 8080...")
	log.Fatal(http.ListenAndServe(":8080", handler))
}

func signupHandler(w http.ResponseWriter, r *http.Request) {
	var user User
	if err := json.NewDecoder(r.Body).Decode(&user); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	hashedPassword, _ := bcrypt.GenerateFromPassword([]byte(user.Password), bcrypt.DefaultCost)
	hashedPattern, _ := bcrypt.GenerateFromPassword([]byte(user.Pattern), bcrypt.DefaultCost)

	_, err := db.Exec("INSERT INTO users (username, password_hash, phone, pattern_hash) VALUES (?, ?, ?, ?)",
		user.Username, hashedPassword, user.Phone, hashedPattern)
	
	if err != nil {
		http.Error(w, "Username already exists or database error", http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusCreated)
	json.NewEncoder(w).Encode(map[string]string{"message": "User created successfully"})
}

func loginStep1Handler(w http.ResponseWriter, r *http.Request) {
	var req struct {
		Username string `json:"username"`
		Password string `json:"password"`
	}
	if err := json.NewDecoder(r.Body).Decode(&req); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	var hash, phone string
	err := db.QueryRow("SELECT password_hash, phone FROM users WHERE username = ?", req.Username).Scan(&hash, &phone)
	if err != nil || bcrypt.CompareHashAndPassword([]byte(hash), []byte(req.Password)) != nil {
		http.Error(w, "Invalid username or password", http.StatusUnauthorized)
		return
	}

	// Generate OTP
	rand.Seed(time.Now().UnixNano())
	otp := fmt.Sprintf("%05d", rand.Intn(100000))
	
	// Store OTP in Redis with 5 minutes expiration
	rdb.Set(ctx, "otp:"+req.Username, otp, 5*time.Minute)

	// Simulate sending OTP
	log.Printf("Sending OTP %s to phone %s", otp, phone)

	json.NewEncoder(w).Encode(map[string]string{"message": "Step 1 successful, OTP sent", "username": req.Username, "phone": phone})
}

func loginStep2Handler(w http.ResponseWriter, r *http.Request) {
	var req struct {
		Username string `json:"username"`
		OTP      string `json:"otp"`
	}
	if err := json.NewDecoder(r.Body).Decode(&req); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	storedOTP, err := rdb.Get(ctx, "otp:"+req.Username).Result()
	if err != nil || storedOTP != req.OTP {
		http.Error(w, "Invalid or expired OTP", http.StatusUnauthorized)
		return
	}

	// Clear OTP
	rdb.Del(ctx, "otp:"+req.Username)
	
	// Create a temporary token for step 3
	step3Token := fmt.Sprintf("%016x", rand.Int63())
	rdb.Set(ctx, "step3:"+req.Username, step3Token, 5*time.Minute)

	json.NewEncoder(w).Encode(map[string]string{"message": "OTP verified", "step3Token": step3Token})
}

func loginStep3Handler(w http.ResponseWriter, r *http.Request) {
	var req struct {
		Username   string `json:"username"`
		Step3Token string `json:"step3Token"`
		Pattern    string `json:"pattern"`
	}
	if err := json.NewDecoder(r.Body).Decode(&req); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	token, err := rdb.Get(ctx, "step3:"+req.Username).Result()
	if err != nil || token != req.Step3Token {
		http.Error(w, "Invalid session or token expired", http.StatusUnauthorized)
		return
	}

	var patternHash string
	err = db.QueryRow("SELECT pattern_hash FROM users WHERE username = ?", req.Username).Scan(&patternHash)
	if err != nil || bcrypt.CompareHashAndPassword([]byte(patternHash), []byte(req.Pattern)) != nil {
		http.Error(w, "Invalid pattern", http.StatusUnauthorized)
		return
	}

	// Authentication fully complete
	rdb.Del(ctx, "step3:"+req.Username)
	
	json.NewEncoder(w).Encode(map[string]string{"message": "Authentication successful. Welcome!"})
}
