<!-- Department Dashboard-View Compliant -->
<?php
	include("includes/admin.core.inc.php");
	if(logged_in()){
		include("includes/dept.adminheader.inc.php");
	}
	else
	{
		header('Location:depttLogin.php');
	}
	include("includes/DBConnection.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Compliant</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="mainScr">
<table class="dashboard">
	<tr>
		<th class="headSmall">ID</th>
		<th>Name</th>
		<th>Contact</th>
		<th>Email</th>
		<th>Subject</th>
		<th>Compliant</th>
		<th class="headSmall">Action</th>
	</tr>
	<?php
	if(isset($_GET["ComptID"]))
	{
		$comptID=$_GET["ComptID"];
		if(!empty($comptID))
		{
		$deptID=$_SESSION["deptID"];
		$search_query="SELECT ComptID,name,mobile,email,subject,compliant FROM tbl_compliant 
						WHERE ComptID='$comptID' AND DeptID='$deptID'";
		$query_result=$con->query($search_query);
		if($query_result->num_rows)
		 {
			while($returned=$query_result->fetch_assoc())
			{
				echo "<tr><td>".$returned["ComptID"]."</td>";
				echo "<td>".$returned["name"]."</td>";
				echo "<td>".$returned["mobile"]."</td>";
				echo "<td>".$returned["email"]."</td>";
				echo "<td>".$returned["subject"]."</td>";
				echo "<td>".$returned["compliant"]."</td>";
			}
			echo '<td><form method="POST" action="'.$_SERVER["PHP_SELF"].'?ComID='.$comptID.'">
							<input class="button" type="submit" name="repl" value="Reply" />
						</form>
						</td></tr>';
	   	 }else{
	   	 	echo "<script>alert('Compliant not addressed to your Department')</script>";
	   	 	header('Location:depttDashboard.php');
	   	 }
		}
		else{
			header('Location:depttDashboard.php');
		}
	}
?>
</table>
</div>
<?php	
 	if(isset($_POST["repl"]) && !empty($_POST["repl"]))
	{
		$com=$_GET["ComID"];
		echo '<div class="replyDiv">
				<form method="POST" action="'.$_SERVER["PHP_SELF"].'?CID='.$com.'">
					<textarea class="textArea" name="replyField" value=""></textarea><br/>
					<input class="button" type="submit" name="Reply" Value="Reply"/>
					<input class="button" type="reset" name="Cancel" Value="Cancel"/>
				</form>
			</div>';
	}	
?>
<?php
	if(isset($_POST["Reply"]) && !empty($_POST["Reply"]))
			{
				if(isset($_POST["replyField"]))
				{
					$replyF=$_POST["replyField"];
					if(!empty($replyF)){
						include("includes/DBConnection.inc.php");
						$com2=$_GET["CID"];	
						 $updateQuery="UPDATE tbl_compliant SET status='1',reply='$replyF' WHERE ComptID='$com2'";
						$replyResult=$con->query($updateQuery);
						if($con->affected_rows)
							{
								$getEmail="SELECT `name`,`email` FROM tbl_compliant WHERE `ComptID`='$com2'";
								$resEmail=$con->query($getEmail);
								$emailAd=$resEmail->fetch_assoc();
							$subject="RE:REPLY COMPLIANT ID ".$com2." -IUST FEEDBACK";
							$message="Dear ".$emailAd["name"]." Your Compliant has been replied, Kindly check your reply on IUST Feedback Portal \n \n Regards \n  IUST Feedback Portal";
							$headers = "From: IUSTFeedbackPortal"."\r\n" ."CC: darirfan27@yahoo.in";
								mail($emailAd["email"],$subject,$message,$headers);
								echo "<script>alert('Reply Sent, Sender informed through email')</script>";
							}
						else{
								echo "<script>alert('Something went wrong')</script>";
							}
					}
					else{
							echo '<p class="userErrorLabel">Nothing in Reply field</p>';
						}
				}
			}
?>
</body>
</html>