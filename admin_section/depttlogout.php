<!-- Dept Admin Logout Page -->
<?php
include("includes/admin.core.inc.php");
include("includes/DBConnection.inc.php");
session_destroy();
$con->close();
if(empty($_SESSION["dept_admin_uname"]))
{
	header("Location:depttLogin.php");
}
else{
	header("Location:depttLogin.php");
}
?>
