<?php
session_start();
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
?>
