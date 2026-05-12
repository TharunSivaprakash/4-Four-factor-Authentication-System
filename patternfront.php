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
			// username and pattern sent fromsession and  form 
			$username = $_SESSION['login_user'];
			$pattern =$_POST['input1'];
			//datebase connection
			$conn=new mysqli("localhost","root","","authentication")or die("mysqli_error()");
			$sql = "SELECT * from pattern where username = '$username'";
			$result = mysqli_query($conn,$sql);//to prevent sql injection
			$rowcount = mysqli_num_rows($result);
			if($rowcount){
				$rows = mysqli_fetch_array($result, MYSQLI_ASSOC);
				if($rows['username'] == $username && $rows['pattern'] == $pattern) {
					header("location:otpgenerate.php");
				}
					else
					{
				?>
				<script>
				alert('invalid pattern try again bruh');
				document.location = "login.html"
				</script>
				<?php 
					}
				}
					else
						?>
					
						<script>
				alert('invalid pattern try again bruh');
				document.location = "login.html"
				</script>
				<?php
				}
			
			
?>