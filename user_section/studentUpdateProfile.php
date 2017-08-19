<?php
include("includes/core.inc.php");
if(!logged_in()){
  echo 'Not Logged In';
}
if(isset($_POST["uname"]) && isset($_POST["studentId"]) && isset($_POST["Flag"]) && isset($_POST["Password"]) && isset($_POST["Email"]))
	{
	include("includes/DBConnection.inc.php");
      if($_POST["Flag"] == 0){
        $updateQuery="UPDATE `tbl_students` SET `studentEmail`='".$_POST["Email"]."',`username`='".$_POST["uname"]."' WHERE `studentID`=".$_POST["studentId"];
      }elseif($_POST["Flag"] == 1){
        $updateQuery="UPDATE `tbl_students` SET `username`='".$_POST["uname"]."',`studentEmail`='".$_POST["Email"]."',`password`='".$_POST["Password"]."' WHERE `studentID`=".$_POST["studentId"];
      }
				$res = $con->query($updateQuery);
					if($res){
						header('Content-Type: application/json');
                		echo json_encode(array('status' => 'success'));
					}
					else
					{
						echo 'failure database';
					}
		}
		else
		{
      		echo 'failure empty';
    	}
    	$con->close();
?>
