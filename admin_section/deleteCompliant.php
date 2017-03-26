<!--SuperAdmin Delete Compliant -->
<?php
include("includes/core.inc.php");
if(logged_in()){

	if(isset($_GET["ComptID"]))
	{
		$comptID=$_GET["ComptID"];
			if(!empty($comptID))
			{
				include("includes/DBConnection.inc.php");
				$deleteQuery="DELETE FROM tbl_compliant WHERE ComptID='$comptID'";
				$queryResult=$con->query($deleteQuery);
					if($con->affected_rows){
						echo "<script>alert('Compliant Deleted')</script>";
						header('Location:admin_dashboard.php');
					}
					else{
						echo "<script>alert('Something went wrong')</script>";
						header('Location:admin_dashboard.php');
					}

			}else
				{
					header('Location:admin_dashboard.php');
				}	
	}
}
else
	{
		header('Location:index.php');
	}
?>

