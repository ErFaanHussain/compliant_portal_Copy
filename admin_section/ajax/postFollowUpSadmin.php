<?php
include("../includes/core.inc.php");
if(!logged_in()){
	echo 'not logged in';
}
 	if(isset($_POST["comptID"]) && !empty($_POST["comptID"]) && isset($_POST["followUpCont"]) && !empty($_POST["followUpCont"]))
	{
    $compID = $_POST["comptID"];
    $followUpCont = htmlspecialchars($_POST["followUpCont"]);
    $adminID =  $_SESSION["adminID"];
		include("../includes/DBConnection.inc.php");
				date_default_timezone_set("Asia/Kolkata");
  				$timeStamp=date("d-m-Y h:i:s A");
				$updateQuery="UPDATE `tbl_compliant` SET `followUpFlag`= 'Y' WHERE `ComptID`=".$compID;
				$insertQuery = "INSERT INTO `tbl_followups`(`ComptID`,`fUpContent`,`fUpBy`,`AdminID`,`fUptimeStamp`) VALUES ('$compID','$followUpCont','superAdmin','$adminID','$timeStamp')";
				$res = $con->query($updateQuery);
				if($res){
					$res2=$con->query($insertQuery);
					if($con->affected_rows){
						header('Content-Type: application/json');
               			echo json_encode(array('status' => 'success', 'timeStamp' => $timeStamp));
					}
          			else{
            			header('Content-Type: application/json');
                		echo json_encode(array('status' => 'DB insert failed'));
          			}
				}
				else{
    			  header('Content-Type: application/json');
                  echo json_encode(array('status' => 'DB update failed'));
    			}
				

				
	}else{
		header('Content-Type: application/json');
        echo json_encode(array('status' => 'fields empty'));
	}
    
?>
