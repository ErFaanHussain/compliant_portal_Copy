<?php
	include("../includes/admin.core.inc.php");
	if (!logged_in()) {
		echo 'not logged in';
	}
?>
<?php
	if(isset($_POST["comptID"]) && !empty($_POST["comptID"]) && isset($_POST["reply"]) && !empty($_POST["reply"]) && isset($_POST["sid"]) && !empty($_POST["sid"]))
			{
					$replyF=htmlentities($_POST["reply"]);
          $com2=$_POST["comptID"];
          $studentId=$_POST["sid"];
          date_default_timezone_set("Asia/Kolkata");
      		$timeStamp=date("d-m-Y h:i:s A");
						include("../includes/DBConnection.inc.php");
						$updateQuery="UPDATE `tbl_compliant` SET `status`='1',`reply`='$replyF',`replyDate`='$timeStamp',`repliedBy`='admin',`AdminID`=".$_SESSION["adminID"]." WHERE `ComptID`=".$com2;
						$replyResult=$con->query($updateQuery);
						if($con->affected_rows)
							{
                header('Content-Type: application/json');
                $j=json_encode(array('status' => 'success', 'timeStamp' => $timeStamp));
                echo $j;
								$getEmail="SELECT `studentName`,`studentEmail` FROM `tbl_students` WHERE `studentID`=".$studentId;
								$resEmail=$con->query($getEmail);
								$stdDet=$resEmail->fetch_assoc();
                  $sql3="SELECT `comptRef` FROM `tbl_compliant` WHERE `ComptID`=".$com2;
                  $resSql3=$con->query($sql3);
                  $resRef=$resSql3->fetch_assoc();
							$subject="RE:REPLY COMPLAINT REFERENCE ".$resRef["comptRef"]." -IUST FEEDBACK";
							$message="Dear ".$stdDet["studentName"]." Your Complaint with Reference ID ".$resRef["comptRef"]." has been replied, Kindly check your reply on IUST Feedback Portal\n\nRegards\nIUST Feedback Portal";
							$headers = "From: IUSTFeedbackPortal"."\r\n" ."CC: darirfan27@yahoo.in";
							mail($stdDet["studentEmail"],$subject,$message,$headers);
							}
						else{
                header('Content-Type: application/json');
                echo json_encode(array('status' => 'failure'));
							}
			}
?>
