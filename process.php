<?php
if (!isset($_SERVER['HTTP_REFERER'])){ 
?>
<script>
alert('no cheating dude');
document.location = "signup.html"
</script>
<?php 
}
session_start();
//Your authentication key
$authKey = "202216A5QenzYQYP5aa6171d";
//Multiple mobiles numbers separated by comma
$mobileNumber = $_POST["phone"];
//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "MSGIND";
//Your message to send, Add URL encoding here.
$rndno=rand(10000, 99999);
$message = urlencode("The OTP you requested for ".$rndno."ThankYou");
//Define route 
$route = "route=4";
//Prepare you post parameters
$postData = array(
'authkey' => $authKey,
'mobiles' => $mobileNumber,
'message' => $message,
'sender' => $senderId,
'route' => $route
);
//API URL
$url="https://control.msg91.com/api/sendhttp.php";
// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
CURLOPT_URL => $url,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_POST => true,
CURLOPT_POSTFIELDS => $postData
//,CURLOPT_FOLLOWLOCATION => true
));
//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//get response
$output = curl_exec($ch);
//Print error if any
if(curl_errno($ch))
{
?>
<script>
alert('error in sending otp plz check onece agian');
document.location = "signupotpgenerate.php"
</script>
<?php
}
curl_close($ch);
if(isset($_POST['btn-save']))
{
$_SESSION['phone']=$_POST['phone'];
$_SESSION['otp']=$rndno;
header( "Location: verify.php" ); }
?>
<!--
<!DOCTYPE html>
<html>
<title>Form</title>
<body>
<form action="verify.php" method="post">
<input type="text" value = "" name="otpverify"/>
<input type="submit" value="submit" />
</form>
</body>
</html>
-->
