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
if($_SERVER["REQUEST_METHOD"] == "POST") {
			// username and password sent from form 
			$conn=new mysqli("localhost","root","","authentication")or die("mysqli_error()");
			$email = $_SESSION['login_user'];
			$entered_otp = $_POST['otpverify'];
			$generated_otp = $_SESSION['otp'];
			if($entered_otp == $generated_otp)
			{
				$sqlupdt = "update register set checkotp = 1 where email = '$email'";
				mysqli_query($conn,$sqlupdt);
				?>
				<script>
				alert("OTP verificatin success");
				document.location = "login.html"
				</script>
				<?php
			}
			else{
				$conn=new mysqli("localhost","root","","authentication")or die("mysqli_error()");
				$email = $_SESSION['login_user'];
				$sql="delete from register where email = '$email'";
				mysqli_query($conn,$sql);
				$sqlquepat = "delete from pattern where username = '$email'";
				mysqli_query($conn,$sqlquepat);
			?>
			<script>
			alert('OTP verificatin failed');
			document.location="signup.html"
			</script>
		<?php 
			}
}
session_destroy();
		?>