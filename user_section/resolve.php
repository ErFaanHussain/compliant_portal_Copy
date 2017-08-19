<?php
include("includes/core.inc.php");
	if(!logged_in()){
			echo 'not logged in';
		}
if(isset($_POST["ComptID"]))
	{
		$comptID=htmlspecialchars($_POST["ComptID"]);
			if(!empty($comptID))
			{
				include("includes/DBConnection.inc.php");
				$publishQuery="UPDATE `tbl_compliant` SET `resolvedFlag`='Y' WHERE ComptID='$comptID'";
				$queryResult=$con->query($publishQuery);
					if($con->affected_rows)
					{
						header('Content-Type: application/json');
                		echo json_encode(array('status' => 'success'));
					}
					else{
						header('Content-Type: application/json');
                		echo json_encode(array('status' => 'failure'));
					}

			}else
				{
					header('Content-Type: application/json');
                	echo json_encode(array('status' => 'failure empty'));
				}
	$con->close();			
	}
?>
