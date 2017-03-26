<!--SuperAdmin Publish Compliant -->
<?php
include("includes/core.inc.php");
	if(logged_in()){
	
	if(isset($_GET["ComptID"]))
	{
		$comptID=htmlspecialchars($_GET["ComptID"]);
			if(!empty($comptID))
			{
				include("includes/DBConnection.inc.php");
				$publishQuery="UPDATE tbl_compliant SET `publish_flag`='Y' WHERE ComptID='$comptID'";
				$queryResult=$con->query($publishQuery);
					if($con->affected_rows)
					{
						echo '<script>alert("Published");</script>';
						header('Location:admin_dashboard.php');
					}
					else{
						echo "<script>alert('Something went wrong');</script>";
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

