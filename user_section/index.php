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
	<title>Login - IUST Feedback Portal</title>
	<?php 
			include("includes/logOut.header.php");
			include("includes/DBConnection.inc.php");	
		 	include("login.php");
	?>
</body>
</html>
