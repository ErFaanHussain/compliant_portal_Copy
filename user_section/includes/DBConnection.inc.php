<!-- Main Connection to the Database -->
<?php 
$server="127.0.0.1";
$uname="erfaan";
$pass="erfaan8875";
$db="dbcompliant";
$con=new mysqli($server,$uname,$pass,$db);
if($con->connect_error)
{
	exit;
}
?>