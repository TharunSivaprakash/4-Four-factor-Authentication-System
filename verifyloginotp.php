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
if($_SERVER["REQUEST_METHOD"] == "POST") {
			// username and password sent from form 
			$entered_otp = $_POST['otpverify'];
			$generated_otp = $_SESSION['otp'];
			if($entered_otp == $generated_otp)
			{
				?>
				<script>
				alert("OTP verificatin success");
				document.location = "thankyou.php"
				</script>
				<?php
			}
			else{
			?>
			<script>
			alert('OTP verificatin failed');
			document.location="login.html"
			</script>
		<?php 
			}
}
session_destroy();
		?>
