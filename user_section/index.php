<!-- Landing page for user -->
<?php
	include("includes/core.inc.php");
	if(logged_in())
	{
		header('Location:homeDashboard.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Student Login - IUST Feedback Portal</title>
	<?php
			include("includes/logOut.header.php"); ?>
			<script src="js/customJSstudentLS.js"></script>
			<?php
			include("includes/DBConnection.inc.php");
		 	include("login.php");
	$con->close();
	?>
	 <footer class="container-fluid py-2" style="background-color: #dadada;">
	<div class="text-center">
		<div class="my-0"><i class="fa fa-code" aria-hidden="true"></i> with <i class="fa fa-heart" aria-hidden="true"></i> by 
		<a style="text-decoration: none;" href="https://facebook.com/erfaanhussain6"><strong style="color:#292b2c;">ErFaan</strong></a> &amp; <a style="text-decoration: none;" href="https://facebook.com/superstudomi"><strong style="color:#292b2c;">Umar</strong></a> 
		</div>
		<small class="my-0">Copyright &copy; DOCS - IUST 2017 </small>
	</div>
</footer>
</body>
</html>
