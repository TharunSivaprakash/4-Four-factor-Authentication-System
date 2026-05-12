
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
			$username = $_POST['user'];
			$password =$_POST['pass'];
			//datebase connection
			$conn=new mysqli("localhost","root","","authentication")or die("mysqli_error()");
			//$c=mysqli_select_db($conn,"login")or die("mysqli_error()");//anything happens it just die
			//fethcing the data from database through quering
			$sql = "SELECT * FROM register WHERE email = '$username' and password ='$password'";
			$result = mysqli_query($conn,$sql);//to prevent sql injection
			$rowcount = mysqli_num_rows($result);
			if($rowcount){
					$rows = mysqli_fetch_array($result, MYSQLI_ASSOC);
					
						if($rows['email'] == $username && $rows['password'] == $password) {
							$_SESSION['login_user'] = $username;
							if($rows['checkotp'] == 1){
							header("location:loginpattern.php");
						}
						else{
							?>
							<script>
								alert('plz do verify otp');
								document.location = "signupotpgenerate.php"
							</script>
							<?php
						}
						}
						else
						{
							?>
							<script>
								alert('invalid username or password');
								document.location = "login.html"
							</script>
							<?php
						}
					}
					else
						{
							?>
							<script>
								alert('invalid username or password');
								document.location = "login.html"
								</script>
						<?php 
	}
   }
?>
