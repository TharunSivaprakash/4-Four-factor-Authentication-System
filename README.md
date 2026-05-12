# 3-Factor Authentication System (Microservices Architecture)

## 📌 Project Overview
A highly scalable, modern **3-Factor Authentication System** completely refactored from a monolithic legacy PHP application into a robust, cloud-ready **Microservices Architecture**. This project was specifically designed to demonstrate proficiency in modern full-stack development, distributed caching, containerization, and RESTful API design.

The system enforces three layers of security for user access:
1. **Level 1:** Standard Password Authentication
2. **Level 2:** Time-based One Time Password (OTP) verification
3. **Level 3:** Secret Pattern Code verification

---

## 🚀 Tech Stack (Aligning with Industry Requirements)
This project is built using the exact modern stack required for enterprise-grade SaaS and eCommerce platforms:

* **Backend Services:** **Go Lang** (Golang) for building high-throughput, low-latency RESTful APIs.
* **Frontend Framework:** **Next.js** & **ReactJS** for a highly responsive, server-side rendered (SSR) user interface.
* **Database:** **MySQL** (Relational SQL Database) for secure, persistent user storage.
* **Caching Layer:** **Redis** for managing ephemeral session data and OTP expirations.
* **Containerization:** **Docker** & **Docker Compose** for seamless orchestration and CI/CD readiness.
* **Architecture:** Microservices, Agile methodologies, RESTful APIs.

---

## 🏗️ Architecture & Implementation Details

### 1. Robust Backend (Go Lang)
* Replaced legacy PHP scripts with a highly optimized Go backend.
* Handles concurrent HTTP requests efficiently using Gorilla Mux.
* Ensures secure user credentials by implementing `bcrypt` hashing for both passwords and pattern codes.

### 2. Modern Frontend (ReactJS & NextJS)
* Rebuilt the entire user interface using Next.js App Router for dynamic client-side rendering.
* Eliminated page reloads and state loss using React Hooks (`useState`, `useEffect`) to create a smooth, single-page application (SPA) feel.
* Maintained clean UI/UX with responsive, custom CSS styling, removing legacy HTML table structures.

### 3. Distributed Caching (Redis)
* Integrated Redis to handle high-speed caching operations.
* OTPs (One Time Passwords) and intermediate session tokens are stored securely in Redis with a 5-minute Time-To-Live (TTL) expiration, significantly improving security over traditional cookie/session storage.

### 4. Relational Database (SQL)
* Re-engineered the database schema to handle secure user identities.
* Executed raw SQL queries within Go to demonstrate strong proficiency in SQL database management.

### 5. Dockerization & Deployment
* **Containerized** both the Next.js frontend and Go backend using optimized Dockerfiles.
* Created a `docker-compose.yml` to orchestrate the entire stack (Go backend, Next.js frontend, Redis, MySQL), simulating a Kubernetes-style multi-container deployment.
* Cloud-ready: Designed to be easily deployed on Azure, AWS, or GCP.

---

## 💻 How to Run Locally

### Prerequisites
* **Docker Desktop** installed on your machine.

### Installation Steps
1. Clone or navigate to the project directory.
2. Open a terminal and run the following command to build and launch all microservices:
   ```bash
   docker-compose up --build
   ```
3. Docker will automatically pull the necessary Go, Node.js, Redis, and MySQL images, compile the code, and map the ports.

### Accessing the Application
* **Frontend (Next.js/React):** [http://localhost:3000](http://localhost:3000)
* **Backend API (Go Lang):** [http://localhost:8080/api](http://localhost:8080/api)

### Stopping the Services
To shut down the application, press `Ctrl + C` in the terminal, or run:
```bash
docker-compose down
```
