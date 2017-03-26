<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php
include("includes/core.inc.php");
include("includes/DBConnection.inc.php");
include("adminLogin.php");

if(logged_in())
{
	header('Location:depttCreation.php');
    
}
else
{
	echo '<p class="login_error">Please Login first</p>';
}

?>
</body>
</html>
