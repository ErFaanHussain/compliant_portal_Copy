<?php
	include("includes/core.inc.php");
	if(logged_in())
	{
		header('Location:aDashboard.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Super Admin Login - IUST Feedback Portal</title>
	<?php
			include("includes/logOut.header.php");
			?> <script src="js/customJSsAdminLogin.js"></script>
			<?php 
			include("includes/DBConnection.inc.php");
		 	include("adminLogin.php");
	?>
</body>
</html>
