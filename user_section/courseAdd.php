<?php
include("includes/core.inc.php");
// if(!logged_in()){
//   echo 'Not Logged In';
// }
if(isset($_POST["DeptID"]))
	{
	include("includes/DBConnection.inc.php");
        $getQuery="SELECT `courseID`,`courseName` FROM `tbl_courses` WHERE `courseDeptt`=".$_POST["DeptID"];
				$result = $con->query($getQuery);
				if($result->num_rows){
					$data = array(0 => 'success');
					while($ret = $result->fetch_assoc()){
						$data[] = array(
							'courseID' => $ret["courseID"], 'courseName' => $ret["courseName"],
							);
					}
				}
				else{
					$data = array(0 => 'no course');
				}
				header('Content-Type: application/json');
				echo json_encode($data);
		}
		else
		{
      		echo 'failure empty';
    	}
    	$con->close();
    	exit();
?>
