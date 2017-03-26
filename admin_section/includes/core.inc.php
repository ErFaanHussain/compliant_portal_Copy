<?php
session_start();
$current_page = $_SERVER["SCRIPT_NAME"];


function logged_in()
{
	if(isset($_SESSION["admin_uname"]) && !empty($_SESSION["admin_uname"]))
	{
		return true;
	}
	else 
	{
		return false;
	}
}
?>