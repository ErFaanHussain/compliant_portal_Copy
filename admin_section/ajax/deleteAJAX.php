<?php
include("../includes/core.inc.php");
if(!logged_in()){
  echo 'not logged in';
}
 	if(isset($_POST["ComptID"]) && !empty($_POST["ComptID"]))
	{
		include("../includes/DBConnection.inc.php");
				$deleteQuery="DELETE FROM `tbl_compliant` WHERE `ComptID`=".$_POST["ComptID"];
				$con->query($deleteQuery);
					if(mysqli_affected_rows($con) > 0){
						echo 'success';
					}
					else{
						echo 'failure';
					}
		}else{
      echo 'failure';
    }
?>
