<?php	
include("includes/core.inc.php");
if(logged_in()){
 	if(isset($_GET["deleteId"]) && !empty($_GET["deleteId"]))
	{
		include("includes/DBConnection.inc.php");
				$deleteQuery="DELETE FROM tbl_compliant WHERE ComptID='".$_GET["deleteId"]."'";
				$con->query($deleteQuery);
					if(mysqli_affected_rows($con) > 0){
						echo 1;
					}
					else{
						echo 0;
					}
		}
}
else
	{
		header('Location:index.php');
	}	
?>


