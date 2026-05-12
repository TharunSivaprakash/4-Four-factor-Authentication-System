<?php
if (!isset($_SERVER['HTTP_REFERER'])) { 
?>
<script>
alert('No cheating, dude!');
document.location = "login.html";
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
            font-size: 48px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);
        }

        form {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.5);
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
            text-align: center;
        }

        input[type="text"], input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            font-size: 18px;
        }

        .btn {
            border: none;
            color: white;
            padding: 14px 28px;
            font-size: 16px;
            cursor: pointer;
            margin: 5px;
            transition: background-color 0.3s ease;
        }

        .Green { background-color: #4CAF50; }
        .Green:hover { background-color: #46a049; }

        .Orange { background-color: #ff9800; }
        .Orange:hover { background: #e68a00; }

        .Pink { background-color: #FF1493; }
        .Pink:hover { background: #0b7dda; }

        .Red { background-color: #f44336; }
        .Red:hover { background: #da190b; }

        .Purple { background-color: #800080; }
        .Purple:hover { background: #0b7dda; }

    </style>
</head>

<body>
    <br><br>
    <?php
    $value1 = 'green';
    $value2 = 'orange';
    $value3 = 'pink';
    $value4 = 'red';
    $value5 = 'purple';
    ?>
    <center>
        <h1>THREE LEVEL PASSWORD AUTHENTICATION SYSTEM</h1>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="signup.html">Sign up</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>

        <br><br>
        <h1>Pattern</h1>
        <br><br>
        <form action="patternfront.php" method="POST">
            <input type="hidden" id="value1" value="<?php echo $value1; ?>" name="value1">
            <input type="hidden" id="value2" value="<?php echo $value2; ?>" name="value2">
            <input type="hidden" id="value3" value="<?php echo $value3; ?>" name="value3">
            <input type="hidden" id="value4" value="<?php echo $value4; ?>" name="value4">
            <input type="hidden" id="value5" value="<?php echo $value5; ?>" name="value5">
            Enter your pattern: <input type="text" id="input1" name="input1" required><br><br>
            <input class="btn Green" type="button" value="Green" name="button" onclick="populateTextareaone()">
            <input class="btn Orange" type="button" value="Orange" name="button" onclick="populateTextareatwo()">
            <input class="btn Pink" type="button" value="Pink" name="button" onclick="populateTextareathree()">
            <input class="btn Red" type="button" value="Red" name="button" onclick="populateTextareafour()">
            <input class="btn Purple" type="button" value="Purple" name="button" onclick="populateTextareafive()">
            <br><br>
            <input class="btn Purple" type="button" value="Clear" name="button" onclick="clearit()">
            <input class="btn Purple" type="submit" value="Submit" name="button">
        </form>
    </center>

    <script type="text/javascript">
        let txt = '';

        function clearit() {
            document.getElementById("input1").value = '';
            txt = '';
        }

        function populateTextareaone() {
            txt = txt.concat(document.getElementById('value1').value);
            document.getElementById('input1').value = txt;
        }

        function populateTextareatwo() {
            txt = txt.concat(document.getElementById('value2').value);
            document.getElementById('input1').value = txt;
        }

        function populateTextareathree() {
            txt = txt.concat(document.getElementById('value3').value);
            document.getElementById('input1').value = txt;
        }

        function populateTextareafour() {
            txt = txt.concat(document.getElementById('value4').value);
            document.getElementById('input1').value = txt;
        }

        function populateTextareafive() {
            txt = txt.concat(document.getElementById('value5').value);
            document.getElementById('input1').value = txt;
        }
    </script>
</body>
</html>
