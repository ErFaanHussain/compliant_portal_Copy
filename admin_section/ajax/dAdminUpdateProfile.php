<?php
include("../includes/admin.core.inc.php");
if(!logged_in()){
  echo 'Not Logged In';
}
 	if(isset($_POST["uName"]) && isset($_POST["Name"]) && isset($_POST["iD"]) && isset($_POST["Flag"]) && isset($_POST["Password"]) && isset($_POST["Email"]))
	{
		include("../includes/DBConnection.inc.php");
      if($_POST["Flag"] == 0){
        $updateQuery="UPDATE `tbl_deptadmins` SET `name`='".$_POST["Name"]."',`email`='".$_POST["Email"]."',`UserName`='".$_POST["uName"]."' WHERE `AdminID`=".$_POST["iD"];
      }elseif($_POST["Flag"] == 1){
        $updateQuery="UPDATE `tbl_deptadmins` SET `name`='".$_POST["Name"]."',`UserName`='".$_POST["uName"]."',`email`='".$_POST["Email"]."',`Password`='".$_POST["Password"]."' WHERE `AdminID`=".$_POST["iD"];
      }
				$res=$con->query($updateQuery);
					if($res){
						echo 'success';
					}
					else{
						echo 'failure database';
					}
		}else{
      echo 'failure empty';
    }
?>
