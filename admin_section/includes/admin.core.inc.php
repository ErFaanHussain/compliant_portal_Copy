<?php
session_start();
$current_page = $_SERVER["SCRIPT_NAME"];

function logged_in()
{
	if(isset($_SESSION["dept_admin_uname"]) && !empty($_SESSION["dept_admin_uname"]))
	{
		return true;
	}
	else 
	{
		return false;
	}
}
// $deptID=$_SESSION["deptID"];
?>