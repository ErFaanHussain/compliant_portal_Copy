<?php
 	if(isset($_POST["comptID"]) && !empty($_POST["comptID"]) && isset($_POST["deptID"]) && !empty($_POST["deptID"]))
	{
    $compID = $_POST["comptID"];
    $deptID = $_POST["deptID"];
		include("../includes/DBConnection.inc.php");
				$updateQuery="UPDATE `tbl_compliant` SET `DeptID`=".$deptID." WHERE `ComptID`=".$compID;
				$r=$con->query($updateQuery);
					if($con->affected_rows){
						echo 'success';
					}
          else{
            echo 'not matched or already';
          }
		}
    else{
      echo 'failure empty';
    }
?>
