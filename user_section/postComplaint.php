<?php
include("includes/core.inc.php");
	if (!logged_in()) {
		header('Location:index.php');
		exit;
	}
	else{
		include("includes/DBConnection.inc.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Post Complaint-IUST Feedback Portal</title>
<?php
include("includes/header.inc.php");
?>
<script>
  		$(document).ready(function(){
  			$("#postLink").addClass("active");
  		});
  	</script>
<div class="container-fluid px-0">
	<div class="col-md-9" style="float:left; !important" id="postComplaintForm">
	<h6>Logged In As:<strong> <?php echo $_SESSION["studentName"]; ?></strong></h6>
	<div class="col-md-6 px-0" id="formContainer" style="float:left; !important">
				<div role="alert" id="errorAlert">
				</div>
		<form id="postComplaintForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
			<div class="form-group">
							<label class="col-form-label" for="comptSubject">Subject</label>
							<input type="text" class="form-control" id="comptSubject" name="subject" value="" placeholder="Subject">
							<small id="subjectHelp" class="form-text text-muted">Brief about your Complaint, upto 100 characters</small>
			</div>
			<div class="form-group">
    						<label for="depttSelect">Select Department</label>
    						<select class="form-control" id="depttSelect" name="depttID">
    						<option selected value="null">--Select Department--</option>
						<?php 
							$fetch_query="SELECT DeptID,DeptName FROM tbl_departments";
							$query_result=$con->query($fetch_query);
							$cnt = $query_result->num_rows;
							if($cnt)
								{
									while($returned=$query_result->fetch_assoc()){
										echo '<option value="'.$returned["DeptID"].'">'.$returned["DeptName"].'</option>';	
										}	
								}
						?>
							</select>
							<small id="selectHelp" class="form-text text-muted">Department you are sending Complaint to</small>
  			</div>
			<div class="form-group">
							<label class="col-form-label" for="complaint">Complaint</label>
							<textarea class="form-control" id="complaint" name="complaint" rows="3" value="" placeholder="Describe your Complaint"></textarea>
							<small id="selectHelp" class="form-text text-muted">Full Description of your Complaint, not more than 500 characters</small>
			</div>
			<div class="form-group">
						<div class="offset-md-3 col-md-9">
							<input type="submit" class="btn btn-primary" id="postSubmit" name="postSubmit" value="Post">
							<button type="reset" class="btn btn-danger ml-md-5">Cancel</button>
						</div>
			</div>
		</form>
	</div>
		<div class="col-md-5 mt-md-4 ml-md-3" style="float:left; !important">
			<div class="alert alert-info alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Info!</strong> Your infomation will be attached to the Complaint you are posting
			</div>
			<div class="alert alert-info alert-dismissible fade show" id="testAlert" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Info!</strong> Please make sure you are posting the Complaint to right department for quick reply
			</div>
		</div>	
	</div>
	<div class="col-md-3" style="float:left; !important">
				<!-- List-Group Panel -->
			<div class="card card-outline-info" style="margin-top:25px;">
		          <div class="card-header pb-0">
		            <h5 class="card-title"><i class="fa fa-tachometer" aria-hidden="true"></i> Portal at Glance</h5>
		          </div>
		          <div class="card-block py-0">
		            <p class="card-text ">
		            <?php 
		            include("includes/stats.inc.php");
		            ?>
		              <p class="text-primary">Complaints Registered: <?php echo getStats('total');?> </p>
		              <p class="text-success">Replied: <?php echo getStats('replied');?></p>
		              <p class="text-warning">Pending: <?php echo getStats('pending');?></p>
		            </p>
		          </div>
        	</div>
	
				<!-- List-Group Panel -->
				<div class="card card-outline-danger " style="margin-top:10px;">
					<div class="card-header pb-0">
						<h5 class="card-title"><i class="fa fa-random" aria-hidden="true"></i> Quick Links
						</h5>
					</div>
					<div class="list-group list-group-flush">
						
						<a href="http://iustlive.com" class="list-group-item list-group-item-action bg-primary text-white">IUST Home</a>
						<a href="./" class="list-group-item list-group-item-action bg-primary text-white">Portal Home</a>
						<a href="studentDashboard.php" class="list-group-item list-group-item-action bg-primary text-white">Dashboard</a>
						<a href="postCompliant.php" class="list-group-item list-group-item-action bg-primary text-white">Post Compliant</a>
						<a href="http://studentservice.iustlive.com/Default.aspx" class="list-group-item list-group-item-action bg-primary text-white">Student Services</a>
						<a href="http://www.iustlive.com/Index/Examination/OnlineExamResults.aspx" class="list-group-item list-group-item-action bg-primary text-white">Results</a>
						
					</div>
				</div>
	</div>
</div>

<?php
	if(isset($_POST["postSubmit"]))
	{
			if(isset($_POST["subject"]) && isset($_POST["depttID"]) && isset($_POST["complaint"]))
			{	
				$subject=$_POST["subject"];
				$deptID=$_POST["depttID"];
				$complaint=$_POST["complaint"];

				if(!empty($subject) && !empty($deptID) && !empty($complaint))
					{
						// Get deptShortCode to create Complaint Reference
						$sql2="SELECT `deptShortCode` FROM `tbl_departments` WHERE `DeptID`=".$deptID;
								$qResult=$con->query($sql2);
								$fResult=$qResult->fetch_assoc();
								$shortCode = $fResult["deptShortCode"];
								
						//Get ID of Last Complaint registered
						$sql4="SELECT COUNT(*) FROM `tbl_compliant` WHERE `DeptID`=".$deptID;
								$qidResult=$con->query($sql4);
								$fidResult=$qidResult->fetch_assoc();
								$lastComptId = $fidResult["COUNT(*)"];

							$ref = $shortCode.'/'.date("M").'/'.date("y").'/'.++$lastComptId;
							date_default_timezone_set("Asia/Kolkata");
							$date = date("Y-m-d"); 
							$studentID=$_SESSION["studentID"];
						$insert_query="INSERT INTO `tbl_compliant`(`subject`,`compliant`,`DeptID`,`status`,`publish_flag`,`comptRef`,`date`,`studentID`) VALUES('$subject','$complaint','$deptID','0','N','$ref','$date','$studentID')";
						$insert_result=$con->query($insert_query);
						if($con->affected_rows)
						{	
							?>
							<script> 
								$(document).ready(function(){
									$("#errorAlert").addClass("alert alert-success fade show").html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> Complaint Successfully Registered with Reference ID: <?php echo $ref;?>')});
    						</script>
							<?php
							// Email to User as well as Department Admin Code Goes here
								// Get Email of the student for email intimation
								$sql3="SELECT `studentEmail` FROM `tbl_students` WHERE `studentID`='".$_SESSION["studentID"]."'";
								$eqResult=$con->query($sql3);
								$emResult=$eqResult->fetch_assoc();
								$stdEmail = $emResult["studentEmail"];
								$subject="COMPLAINT REGISTERED-IUST FEEDBACK";
								$message="Dear ".$_SESSION["studentName"]." Your Complaint has been successfully registered with Reference ID ".$ref.", We will send you an email when your complaint will be replied. Kindly keep the ID for future reference and to check reply on Feedback Portal. \n \nRegards\nIUST Feedback Portal";
								$headers = "From: IUSTFeedbackPortal"."\r\n" ."CC: darirfan27@yahoo.in";
								mail($stdEmail,$subject,$message,$headers);

								// code to Email Deptt. Admin goes here
									$getAdEmail="SELECT `name`,`email` FROM tbl_deptadmins WHERE `DeptID`='$deptID'";
									$res=$con->query($getAdEmail);
									$adminEmail=$res->fetch_assoc();
									$subject="COMPLAINT REGISTERED-IUST FEEDBACK";
								$message="Dear ".$adminEmail["name"]." A Complaint has been registered with Reference  ID ".$ref." directed to your department on IUST Feedback Portal, Kindly log on to Feedback Portal to check the complaint and reply\n\nRegards\nIUST Feedback Portal";
								$headers = "From: IUSTFeedbackPortal"."\r\n" ."CC: darirfan27@yahoo.in";
								mail($adminEmail["email"],$subject,$message,$headers);
						}
						else{
							?>
							<script> 
								$(document).ready(function(){
									$("#errorAlert").addClass("alert alert-danger fade show").html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong> Something went wrong, Please Contact Administrator Error: Database Insertion Failed')});
    						</script>
							<?php
						}	
					}
				else
					{
						?>
						<script> 
							$(document).ready(function(){
								$("#errorAlert").addClass("alert alert-danger fade show").html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong>  Please fill all the details')});
    					</script>
						<?php
					}
			}
	}
	
?>
</body>
</html>
