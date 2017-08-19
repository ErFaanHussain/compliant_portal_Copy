<!-- Logout for Super Admin -->
<?php
include("includes/core.inc.php");
if(logged_in())
	{
		include("includes/DBConnection.inc.php");
		$con->close();
		session_destroy();
		header("Location:./");
	}
	else
	{
		header("Location:./");
	}
?>
