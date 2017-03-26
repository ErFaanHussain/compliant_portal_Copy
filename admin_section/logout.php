<!-- Logout Page -->
<?php
include("includes/core.inc.php");
include("includes/DBConnection.inc.php");
$name=$_SESSION["admin_uname"];
$con->close();
session_destroy();
// $_SESSION=array();
if(empty($_SESSION["admin_uname"]))
{
	header("Location:index.php");
}
else
{
	header("Location:index.php");
}
?>
