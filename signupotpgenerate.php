<?php
if (!isset($_SERVER['HTTP_REFERER'])) { 
?>
<script>
alert('No cheating, dude!');
document.location = "signup.html";
</script>
<?php 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three Level Password Authentication</title>
    <link rel="icon" href="images/fav1.jpg" type="image/gif" sizes="16x16">
    <style>
        body {
            background: url("images/bgm6.jpg") no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: rgba(51, 51, 51, 0.8);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.4);
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        li a:hover {
            background-color: #FF0000;
        }

        h1 {
            font-size: 36px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);
        }

        form {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            margin: auto;
            margin-top: 50px;
            text-align: center;
        }

        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            font-size: 18px;
            color: #000; /* Text color for better visibility */
        }

        input[type="submit"] {
            background-color: #f44336; /* Red */
            color: white;
            border: none;
            padding: 14px 28px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #da190b;
        }
    </style>
</head>

<body>
    <br><br>
    <center>
        <h1>THREE LEVEL PASSWORD AUTHENTICATION SYSTEM</h1>
    </center>
    <br><br>
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="signup.html">Sign up</a></li>
        <li><a href="login.html">Login</a></li>
        <li><a href="contact.html">Contact</a></li>
    </ul>
    <center>
        <br><br><br><br>
        <form action="process.php" method="post">
            <h1>Enter phone number:</h1>
            <input type="number" name="phone" value='' required>
            <br><br>
            <input type="submit" name="btn-save" value="Generate OTP">
            <br><br>
        </form>
    </center>
</body>

</html>
