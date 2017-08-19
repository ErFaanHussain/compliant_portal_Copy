<?php
	include("includes/core.inc.php");
	if (!logged_in()) {
		header('Location:index.php');
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Home - IUST Feedback Portal</title>
<?php
	include("includes/DBConnection.inc.php");
	include("includes/header.inc.php");
?>
<script type="text/javascript">
  		$(document).ready(function(){
  			$("#homeLink").addClass("active");
  		});
  	</script>
<!-- Container for main Dashboard -->
<div class="container-fluid pb-4">
<div class="row">
	<div class="col-md-9" id="MainDashboard1">
	<h6>Logged In As:<strong> <?php echo $_SESSION["studentName"]; ?></strong></h6>
	<div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <strong>Info!&nbsp;</strong>This Dashboard contains publicly posted Complaints of all the students. 
      </div>
	<?php
	$search_query="SELECT `ComptID`,`comptRef`,`studentID`,`date`,`subject`,`compliant`,`reply`,`repliedBy`,`AdminID`,`DeptID`,`replyDate`,`status`,`resolvedFlag` FROM `tbl_compliant` WHERE `publish_flag`='Y'";

	$query_result=$con->query($search_query);
	if($query_result->num_rows)
	{
		while($returned=$query_result->fetch_assoc())
		{
			$deptSearch="SELECT `DeptName` FROM `tbl_departments` WHERE `DeptID`=".$returned["DeptID"];
				$searchResult=$con->query($deptSearch);
				$deptName=$searchResult->fetch_assoc();
			//Get Student Details from tbl_students
			$sql1="SELECT `studentName` FROM `tbl_students` WHERE `studentID`=".$returned["studentID"];
				$searchRes2=$con->query($sql1);
				$stdDetails=$searchRes2->fetch_assoc();
				if ($returned["status"] == 0 AND $returned["resolvedFlag"] == 'N') {
		              ?>
		              <script>
		                $(document).ready(function(){
		                  $("#Card<?php echo $returned["ComptID"]; ?>").addClass("bs-callout bs-callout-danger");
		                });
		              </script>
		              <?php
		            }
	            elseif($returned["status"] == 1 && $returned["resolvedFlag"] == 'N'){
		              ?>
		              <script>
		                $(document).ready(function(){
		                  $("#Card<?php echo $returned["ComptID"]; ?>").addClass("bs-callout bs-callout-success");
		                });
		              </script>
		              <?php
	          	}elseif($returned["status"] == 1 && $returned["resolvedFlag"] == 'Y'){
		              ?>
		                <script>
		                $(document).ready(function(){
		                  $("#Card<?php echo $returned["ComptID"]; ?>").addClass("bs-callout bs-callout-primary");
		                });
		              </script>
		          <?php }
      ?>	
				<div class="card" id="Card<?php echo $returned["ComptID"];?>" style="margin-top:10px;">
					<h6 class="card-header pb-0 px-2 px-md-3" style="background:#dbe3ea;">
						<label class="form-control-label">Posted By: </label><?php echo " ".$stdDetails["studentName"];?>
						<label class="form-control-label float-right">Status: <?php if($returned["status"] == 0){echo '<span class="text-danger">Not Replied</span>';}else{echo '<span class="text-success">Replied</span>';}?>
							<?php if($returned["resolvedFlag"] == 'Y'){
                    				?>  <span id="statusP<?php echo $returned["ComptID"];?>" class="text-primary">| Resolved</span>
                    		<?php }else{
                       				 ?>  <span id="statusP<?php echo $returned["ComptID"];?>" class="text-danger">| Not Resolved</span>
                      		<?php }?>
						</label>
					</h6>
					<div class="card-block px-2 px-md-3">
						<h6 class="card-title"><strong>Subject:</strong> <?php echo $returned["subject"];?></h6>
						<h6 class="card-subtitle mb-2 text-muted"><strong>To: </strong><?php echo $deptName["DeptName"];?></h6>
						<p class="card-text"><strong>Complaint: </strong><?php echo $returned["compliant"]; ?></p>
												<!-- Button trigger modal -->
							
						</div>
					<div class="card-footer text-muted py-1">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#<?php echo $returned["ComptID"]; ?>"><i class="fa fa-list-alt" aria-hidden="true"></i> View Details
              			</button>
					</div>
				</div>
				<!-- Info Modal Start -->
			<div class="modal fade" id="<?php echo $returned["ComptID"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					 <div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
					      <div class="modal-header pb-1">
					        <h6 class="modal-title" id="exampleModalLabel">Posted By: <?php echo $stdDetails["studentName"];?></h6>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body py-0">
					      <small><strong>Reference: <?php echo $returned["comptRef"]?></strong></small>
					        <h6 class="mb-0"> <label class="form-control-label"><strong>Date: </strong></label><?php echo " ".$returned["date"]; ?> </h6>
					        <h6 class="text-muted mb-0"> <label class="form-control-label mb-1"><strong >To: </strong></label><?php echo $deptName["DeptName"];?> </h6>
					        <h6 class="mb-0" style="max-width: 100%; word-wrap: break-word;"><label class="form-control-label mb-1"><strong>Subject: </strong></label><?php echo $returned["subject"];?> </h6>
					        <p class="mb-0" style="max-width: 100%; word-wrap: break-word;"><label class="form-control-label mb-0"><strong>Complaint Posted:</strong></label><?php echo $returned["compliant"];?> </p>
									<?php if($returned["status"] == 1){
					                		?> <p class="mb-0"><label class="form-control-label mb-0"><strong>Reply: </strong></label><?php echo $returned["reply"]; ?></p>
												      <!-- START --><?php
							                 		if($returned["repliedBy"] == 'admin')
														{
															$sql9 = "SELECT `name`,`DeptID` FROM `tbl_deptadmins` WHERE `AdminID`=".$returned["AdminID"];
															$res3 = $con->query($sql9);
															if($res3->num_rows){
																$adminDet1 = $res3->fetch_assoc();
																?>
																<strong>Replied By: </strong><?php echo $adminDet1["name"];?>
																<?php
															}
														}
														else{
															?>
																<p class="mb-0"><strong>Replied By: </strong>Super Admin</p>
															<?php
															}
														?>
							                 	<!-- END -->
					                		<p class="mb-0"><strong>Replied on: </strong><?php echo $returned["replyDate"];?></p>
					          	<?php }else{
					            			?>  <span class="text-danger"><strong>Not Replied Yet</strong></span>
					            <?php } ?>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove" aria-hidden="true"></i>  Close</button>
					      </div>
					    </div>
					 </div>
			</div>
			
			<?php		
		}
	}
	$con->close(); ?>
	</div>
	<div class="col-md-3 mt-3 mt-md-4">
				<!-- List-Group Panel -->
			<div class="card card-outline-info">
				<div class="card-header pb-0">
        	    	<h5 class="card-title pb-0"><i class="fa fa-bar-chart" aria-hidden="true"></i> Portal at Glance	</h5>
          		</div>
          		<div class="card-block py-0">
            		<p class="card-text ">
            		<?php 
            			include("includes/stats.inc.php");
            		?>
              			<p class="text-primary"><i class="fa fa-list-alt" aria-hidden="true"></i> Complaints Registered: <?php echo getStats('total');?> </p>
						<p class="text-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Replied: <?php echo getStats('replied');?></p>
						<p class="text-warning"><i class="fa fa-pause-circle-o" aria-hidden="true"></i> Not Replied: <?php echo getStats('pending');?></p>
              			<p class="text-primary"><i class="fa fa-check" aria-hidden="true"></i> Resolved: <?php echo getStats('resolved');?></p>
						<p class="text-danger"><i class="fa fa-remove" aria-hidden="true"></i> Not Resolved: <?php echo getStats('notResolved');?></p>
            		</p>
          		</div>
			</div>
	
				<!-- List-Group Panel -->
				<div class="card card-outline-danger " style="margin-top:10px;">
					<div class="card-header pb-0">
						<h5 class="card-title"><i class="fa fa-external-link" aria-hidden="true"></i> Quick Links
						</h5>
					</div>
					<div class="list-group list-group-flush">
            
            <a href="http://iustlive.com" class="list-group-item list-group-item-action text-primary "><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;IUST Home</a>
            <a href="./" class="list-group-item list-group-item-action text-primary "><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;&nbsp;Portal Home</a>
            <a href="studentDashboard.php" class="list-group-item list-group-item-action text-primary "><i class="fa fa-table" aria-hidden="true"></i>&nbsp;&nbsp;Dashboard</a>
            <a href="postCompliant.php" class="list-group-item list-group-item-action text-primary "><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;Post Complaint</a>
            <a href="http://studentservice.iustlive.com/Default.aspx" class="list-group-item list-group-item-action text-primary "><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Student Services</a>
            <a href="http://www.iustlive.com/Index/Examination/OnlineExamResults.aspx" class="list-group-item list-group-item-action text-primary "><i class="fa fa-database" aria-hidden="true"></i>&nbsp;&nbsp;Results</a>
            
          </div>
				</div>
	</div>
	</div>
</div>
<footer class="container-fluid py-2" style="background-color: #dadada;">
	<div class="text-center">
		<div class="my-0"><i class="fa fa-code" aria-hidden="true"></i> with <i class="fa fa-heart" aria-hidden="true"></i> by 
		<a style="text-decoration: none;" href="https://facebook.com/erfaanhussain6"><strong style="color:#292b2c;">ErFaan</strong></a> &amp; <a style="text-decoration: none;" href="https://facebook.com/superstudomi"><strong style="color:#292b2c;">Umar</strong></a> 
		</div>
		<small class="my-0">Copyright &copy; DOCS - IUST 2017 </small>
	</div>
</footer>
</body>
</html>