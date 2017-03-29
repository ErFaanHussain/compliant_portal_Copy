<?php
include("includes/user_header.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Post Compliant:Compliant Portal</title>
</head>
<body>
<div class="mainScreen">
	<form class="userForm" method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">
		<p class="userLabel">Please fill up the compliant form</p>
		<p class="userLabel">Name:</p> 
			<input type="text" class="textbox" name="name" value="" placeholder="Your Name?" /><br/>
		<p class="userLabel">Contact Number:</p> 
		 	<input type="number" class="textbox" name="contact" value="" placeholder="Your Mobile Number?" min="7000000000" max="9999999999"/><br/>
		<p class="userLabel">Email:</p> 
			 <input type="email" class="textbox" name="email" value="" placeholder="Your Email?" /><br/>
		<p class="userLabel">Subject:</p> 
			<input type="text" class="textbox" name="subject" value="" placeholder="Compliant Subject?" /><br/>
		<p class="userLabel">Department:</p>
		<select class="selector" name="deptt">
			<?php
				include("includes/DBConnection.inc.php");
				$search_query="SELECT DeptID, DeptName FROM tbl_departments";
				$search_result=$con->query($search_query);
				$count=$search_result->num_rows;
				if($count){	
						while($returned=$search_result->fetch_assoc())
						{
							echo '<option value="'.$returned["DeptID"].'">'.$returned["DeptName"].'</option>';
						}
				}
				else
				{
					echo "<script>alert('No Departments created yet, Contact Administrator!')</script>";
				}	
			?>
		</select><br/>
		<p class="userLabel">Compliant:</p> 
			<textarea class="textarea" name="compliant" placeholder="Describe your Compliant" value=""></textarea>
			<br/>
		<input type="submit" class="button" name="submit" value="Post"/>
		<input type="reset" class="button" name="reset" value="Cancel"/>
			
	</form>
</div>
<?php
	if(isset($_POST["submit"]))
	{
			if(isset($_POST["name"]) && isset($_POST["contact"]) && isset($_POST["email"]) && isset($_POST["subject"]) && isset($_POST["compliant"]))
			{	$name=$_POST["name"];
				$contact=$_POST["contact"];
				$email=$_POST["email"];
				$subject=$_POST["subject"];
				$deptID=$_POST["deptt"];
				$compliant=$_POST["compliant"];

				if(!empty($name) && !empty($contact) && !empty($email) && !empty($subject) && !empty($deptID) && 
					!empty($compliant))
					{
						$insert_query="INSERT INTO tbl_compliant(name,mobile,email,subject,compliant,DeptID,status,publish_flag) VALUES('$name','$contact','$email','$subject','$compliant','$deptID','0','N')";
						$insert_result=$con->query($insert_query);
						if($con->affected_rows)
						{	
							$com_id=$con->insert_id;
							echo "<script>alert('Compliant Successfully Registered, Compliant ID is ".$com_id."')</script>";
							// Email to User as well as Department Admin Code Goes here
								$subject="COMPLIANT REGISTERED-IUST FEEDBACK";
								$message="Dear ".$name." Your Compliant has been successfully registered with ID ".$com_id.", We will send you an email when your compliant will be replied. Kindly keep the ID for future reference and to check reply on Feedback Portal. \n \n Regards \n  IUST Feedback Portal";
								$headers = "From: IUSTFeedbackPortal"."\r\n" ."CC: darirfan27@yahoo.in";
								mail($email,$subject,$message,$headers);

								// code to Email Deptt. Admin goes here
									$getAdEmail="SELECT `name`,`email` FROM tbl_deptadmins WHERE `DeptID`='$deptID'";
									$res=$con->query($getAdEmail);
									$adminEmail=$res->fetch_assoc();
									$subject="COMPLIANT REGISTERED-IUST FEEDBACK";
								$message="Dear ".$adminEmail["name"]." A Compliant has been registered with ID ".$com_id." directed to your department on IUST Feedback Portal, Kindly log on to Feedback Portal to check the complaint\n \n Regards \n  IUST Feedback Portal";
								$headers = "From: IUSTFeedbackPortal"."\r\n" ."CC: darirfan27@yahoo.in";
								mail($adminEmail["email"],$subject,$message,$headers);
						}
						else{
							echo "<script>alert('Something went wrong, Contact Administrator')</script>";
						}	
					}
				else
					{
						echo "<script> alert('Some Details Missing, Please fill the form Completely')</script>";
					}
			}
	}
?>
</body>
</html>