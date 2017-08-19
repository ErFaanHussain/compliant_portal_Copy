<!-- Dept Admin Logout Page -->
<?php
include("includes/admin.core.inc.php");
if(logged_in())
	{
		include("includes/DBConnection.inc.php");
		$con->close();
		session_destroy();
		header("Location:depttLogin.php");
	}
	else
	{
		header("Location:depttLogin.php");
	}
?>
