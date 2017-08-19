<?php
include("../includes/core.inc.php");
	if(!logged_in()){
			echo 'not logged in';
		}
if(isset($_POST["ComptID"]))
	{
		$comptID=htmlspecialchars($_POST["ComptID"]);
			if(!empty($comptID))
			{
				include("../includes/DBConnection.inc.php");
				$publishQuery="UPDATE `tbl_compliant` SET `publish_flag`='Y' WHERE ComptID='$comptID'";
				$queryResult=$con->query($publishQuery);
					if($con->affected_rows)
					{
						echo 'success';
						$con->close();
					}
					else{
						echo 'failure';
						$con->close();
					}

			}else
				{
					echo 'failure';
					$con->close();
				}
	}
?>
