<?php
if (!isset($_SERVER['HTTP_REFERER'])){ 
?>
<script>
alert('no cheating dude');
document.location = "login.html"
</script>
<?php 
}
session_start();
//Your authentication key
$authKey = "202216A5QenzYQYP5aa6171d";
//Multiple mobiles numbers separated by comma
$mobileNumber = $_POST["phone"];
//datebase connection
			$conn=new mysqli("localhost","root","","authentication")or die("mysqli_error()");
			//$c=mysqli_select_db($conn,"login")or die("mysqli_error()");//anything happens it just die
			//fethcing the data from database through quering
			$username = $_SESSION['login_user'];
			$sql = "SELECT * FROM register WHERE email = '$username'";
			$result = mysqli_query($conn,$sql);//to prevent sql injection
			$rowcount = mysqli_num_rows($result);
			if($rowcount){
			$rows = mysqli_fetch_array($result, MYSQLI_ASSOC);
			if($rows['phone'] == $mobileNumber){
//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "MSGIND";
//Your message to send, Add URL encoding here.
$rndno=rand(10000, 99999);
$message = urlencode("otp number.".$rndno);
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
echo 'error:' . curl_error($ch);
}
curl_close($ch);
if(isset($_POST['btn-save']))
{
$_SESSION['phone']=$_POST['phone'];
$_SESSION['otp']=$rndno;
header( "Location: verifylogin.php" ); }
			}
	}
else{
?>
<script>
alert('invalid mobile number')
document.location = "login.html"
</script>
<?php
}	?>
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
