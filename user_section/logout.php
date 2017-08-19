<!-- Logout Page -->
<?php
include("includes/core.inc.php");
if(logged_in())
	{
		include("includes/DBConnection.inc.php");
		$con->close();
		session_destroy();
		header("Location:index.php");
	}
	else
	{
		header("Location:index.php");
	}
?>
