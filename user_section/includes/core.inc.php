
<?php
session_start();
function logged_in()
{
	if(isset($_SESSION["studentUname"]) && !empty($_SESSION["studentUname"]))
	{
		return true;
	}
	else 
	{
		return false;
	}
}
?>