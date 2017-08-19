<?php
include("../includes/core.inc.php");
if(!logged_in()){
  echo 'not logged in';
}
 	if(isset($_POST["uName"]) && isset($_POST["Name"]) && isset($_POST["iD"]) && isset($_POST["Flag"]) && isset($_POST["Password"]) && isset($_POST["Email"]))
	{
		include("../includes/DBConnection.inc.php");
      if($_POST["Flag"] == 0){
        $updateQuery="UPDATE `tbl_superadmin` SET `name`='".$_POST["Name"]."',`UserName`='".$_POST["uName"]."',`email`='".$_POST["Email"]."' WHERE `ID`=".$_POST["iD"];
      }elseif($_POST["Flag"] == 1){
        $updateQuery="UPDATE `tbl_superadmin` SET `name`='".$_POST["Name"]."',`UserName`='".$_POST["uName"]."',`email`='".$_POST["Email"]."',`Password`='".$_POST["Password"]."' WHERE `ID`=".$_POST["iD"];
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
