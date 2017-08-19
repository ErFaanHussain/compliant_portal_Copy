<!-- Super Admin Dashboard -->
<?php
	include("includes/core.inc.php");
	if (!logged_in()) {
		header('Location:./');
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Super Admin Dashboard - IUST Feedback Portal</title>
<?php
	include("includes/DBConnection.inc.php");
	include("includes/adminHeader.inc.php");
?>
<script type="text/javascript" src="js/customJSaDashboard.js"></script>
<!-- Container for main Dashboard -->
<div class="container-fluid pb-5">
<div class="row">
	<div class="col-md-9" id="MainDashboard1">
	<h6>Logged In As:<strong> <?php echo $_SESSION["name"]." -- ";?> Super Admin </strong></h6>
	<?php
		$search_query="SELECT `tbl_compliant`.`ComptID`,`tbl_compliant`.`comptRef`,`tbl_compliant`.`studentID`,`tbl_compliant`.`date`,`tbl_compliant`.`subject`,
		`tbl_compliant`.`compliant`,`tbl_compliant`.`reply`,`tbl_compliant`.`repliedBy`,`tbl_compliant`.`AdminID`,`tbl_compliant`.`replyDate`,`tbl_compliant`.`DeptID`,`tbl_compliant`.`status`,`tbl_compliant`.`resolvedFlag`,`tbl_compliant`.`publish_flag`,`tbl_students`.`studentRegNo`,`tbl_students`.`studentName` FROM `tbl_compliant`,`tbl_students` WHERE `tbl_compliant`.`studentID`=`tbl_students`.`studentID`";
	$query_result=$con->query($search_query);
	if($query_result->num_rows)
	{
		while($returned=$query_result->fetch_assoc())
		{ 
				if ($returned["status"] == 0 AND $returned["resolvedFlag"] == 'N') {
		              ?>
		              <script>
		                $(document).ready(function(){
		                  $("#card<?php echo $returned["ComptID"]; ?>").addClass("bs-callout bs-callout-danger");
		                });
		              </script>
		              <?php
		            }
	            elseif($returned["status"] == 1 && $returned["resolvedFlag"] == 'N'){
		              ?>
		              <script>
		                $(document).ready(function(){
		                  $("#card<?php echo $returned["ComptID"]; ?>").addClass("bs-callout bs-callout-success");
		                });
		              </script>
		              <?php
	          	}elseif($returned["status"] == 1 && $returned["resolvedFlag"] == 'Y'){
		              ?>
		                <script>
		                $(document).ready(function(){
		                  $("#card<?php echo $returned["ComptID"]; ?>").addClass("bs-callout bs-callout-primary");
		                });
		              </script>
		          <?php }
      ?>
			<div class="card" id="card<?php echo $returned["ComptID"];?>" style="margin-top:10px;">
				<h6 class="card-header pb-0 px-1 px-md-3" style="background:#dbe3ea;">
				<label class="form-control-label">Posted By: </label><?php echo " ".$returned["studentName"];?> -- <?php echo " ".$returned["studentRegNo"];?>
				<label class="form-control-label float-right">Status:
				<?php if($returned["status"] == 0){ ?>
					<span id="statusM<?php echo $returned["ComptID"];?>" class="text-danger">Not Replied </span>
				<?php if($returned["publish_flag"] == 'N'){ ?>
					<span id="statusP<?php echo $returned["ComptID"];?>" class="text-danger">| Not Published</span>
				<?php }
					else{ ?>
						<span id="statusP<?php echo $returned["ComptID"];?>" class="text-success">| Published</span>
					<?php }
					}else{ ?>
						<span class="text-success">Replied </span>
						<?php	if($returned["publish_flag"] == 'N'){ ?>
						<span id="statusP<?php echo $returned["ComptID"];?>" class="text-danger">| Not Published</span>
					<?php }
					else{ ?>
						<span id="statusP<?php echo $returned["ComptID"];?>" class="text-info">| Published</span>
					<?php }
					} ?>
					<!--  -->
						<?php if($returned["resolvedFlag"] == 'Y'){
                    		?>  <span id="statusP<?php echo $returned["ComptID"];?>" class="text-primary">| Resolved</span>
                    	<?php }else{
                        	?>  <span id="statusP<?php echo $returned["ComptID"];?>" class="text-danger">| Not Resolved</span>
                      	<?php }?>
					<!--  -->
					</label>
					</h6>
					<?php
						$sql2 = "SELECT `DeptName` FROM `tbl_departments` WHERE `DeptID`=".$returned["DeptID"];
						$res2 = $con->query($sql2);
						if($res2->num_rows){
							$deptDet = $res2->fetch_assoc();
						}
					 ?>
					<div class="card-block py-3 px-1 px-md-3">
						<small><strong>Reference: <?php echo " ".$returned["comptRef"]?></strong></small>
						<h6 class="mb-0"> <label class="form-control-label"><strong>Date:  </strong></label><?php echo " ".$returned["date"]; ?> </h6>
						<h6 class="text-muted mb-1"> <label class="form-control-label mb-0"><strong>To:  </strong></label><?php echo " ".$deptDet["DeptName"]; ?> </h6>
						<h6 class="card-title mb-1"><strong>Subject:</strong> <?php echo " ".$returned["subject"];?></h6>
						<p class="card-text mb-1"><strong>Complaint: </strong><?php echo " ".$returned["compliant"]; ?></p>
					</div>
						<span id="publishResult<?php echo $returned["ComptID"];?>"></span>
					<div class="card-footer text-muted py-1">
					<div class="hidden-sm-down">
							<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#<?php echo $returned["ComptID"]; ?>"><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;View Details</button>
							<?php
							if($returned["publish_flag"] == 'N'){ ?>
								<button type="button" class="btn btn-primary btn-sm" id="publishBtn<?php echo $returned["ComptID"];?>" onclick="publishC(<?php echo $returned["ComptID"];?>);"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;Publish</button>
							<?php	}
							else{ ?>
								<button type="button" class="btn btn-primary btn-sm" id="publishBtn<?php echo $returned["ComptID"];?>" disabled><i class="fa fa-share" aria-hidden="true"></i>&nbsp;Publish</button>
							<?php	} ?>
								<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#forwardModal" aria-hidden="true" onclick="forward(<?php echo $returned["ComptID"]; ?>,<?php echo $returned["DeptID"]; ?>);"><i class="fa fa-external-link"></i>&nbsp;Forward</button>
								<!--  -->
							<?php if($returned["status"] == 1 && $returned["resolvedFlag"] == 'N'){ ?>
			                    <button type="button" class="btn btn-outline-danger btn-sm" id="followUp<?php echo $returned["ComptID"];?>" onclick="followUp(<?php echo $returned['ComptID']; ?>);"><i class="fa fa-quote-left" aria-hidden="true"></i>&nbsp;Follow Up</button>
			                <?php }else{ ?>
			                    <button type="button" class="btn btn-outline-danger btn-sm" disabled id="followUp<?php echo $returned["ComptID"];?>" onclick="followUp(<?php echo $returned['ComptID']; ?>);"><i class="fa fa-quote-left" aria-hidden="true"></i>&nbsp;Follow Up</button>
			                  <?php }?>
								<!--  -->
								<button type="button" class="btn btn-danger btn-sm" onclick="deleteC(<?php echo $returned["ComptID"];?>);" id="deleteBtn<?php echo $returned["ComptID"];?>"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button>
                  				<button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapse<?php echo $returned['ComptID']; ?>" aria-expanded="false">
                     				<i class="fa fa-comment" aria-hidden="true"></i>&nbsp;View Follow Ups</button>
                  </div>
                  <div class="hidden-md-up">
                  <button type="button" class="btn btn-success btn-sm" style="display: inline;" data-toggle="modal" data-target="#<?php echo $returned["ComptID"]; ?>"><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;View Details </button>
              		<div class="dropup" style="display:inline;">
                		<a class="dropdown-toggle btn btn-primary btn-sm" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;Actions</a>
                		<div class="dropdown-menu text-center" style="border-color: #31b0d5;">
                  		<!-- Actions START -->
                  			<?php
							if($returned["publish_flag"] == 'N'){ ?>
								<button type="button" class="btn btn-primary btn-sm" id="publishBtn<?php echo $returned["ComptID"];?>" onclick="publishC(<?php echo $returned["ComptID"];?>);"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;Publish</button>
							<?php	}
							else{ ?>
								<button type="button" class="btn btn-primary btn-sm" id="publishBtn<?php echo $returned["ComptID"];?>" disabled><i class="fa fa-share" aria-hidden="true"></i>&nbsp;Publish</button>
								<div class="dropdown-divider"></div>
							<?php	} ?>
								<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#forwardModal" aria-hidden="true" onclick="forward(<?php echo $returned["ComptID"]; ?>,<?php echo $returned["DeptID"]; ?>);"><i class="fa fa-external-link"></i>&nbsp;Forward</button>
								<div class="dropdown-divider"></div>
								<button type="button" class="btn btn-danger btn-sm" onclick="deleteC(<?php echo $returned["ComptID"];?>);" id="deleteBtn<?php echo $returned["ComptID"];?>"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button><div class="dropdown-divider"></div>
							<?php if($returned["status"] == 1 && $returned["resolvedFlag"] == 'N'){ ?>
			                    <button type="button" class="btn btn-outline-danger btn-sm" id="followUp<?php echo $returned["ComptID"];?>" onclick="followUp(<?php echo $returned['ComptID']; ?>);"><i class="fa fa-quote-left" aria-hidden="true"></i>&nbsp;Add Follow Up</button>
			                    <div class="dropdown-divider"></div>
			                <?php }else{ ?>
			                    <button type="button" class="btn btn-outline-danger btn-sm" disabled id="followUp<?php echo $returned["ComptID"];?>" onclick="followUp(<?php echo $returned['ComptID']; ?>);"><i class="fa fa-quote-left" aria-hidden="true"></i>&nbsp;Add Follow Up</button>
			                    <div class="dropdown-divider"></div>
			                  <?php }?>
                  				<button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapse<?php echo $returned['ComptID']; ?>" aria-expanded="false">
                     				<i class="fa fa-comment" aria-hidden="true"></i>&nbsp;View Follow Ups</button>
                  		<!-- Actions END -->
                  		</div>
                  	</div>
                  </div>
                  <!-- Follow Ups Collapse START -->
            <div class="collapse" id="collapse<?php echo $returned['ComptID']; ?>">
              <div class="card card-block mx-0" style="max-height:200px; overflow-y: scroll;" id="followUpCard<?php echo $returned['ComptID'];?>">
            <?php
              $sql2 = "SELECT `fUpId`,`fUpContent`,`fUpBy`,`studentID`,`AdminID`,`fUptimeStamp` FROM `tbl_followups` WHERE `ComptID`=".$returned["ComptID"];
              $res = $con->query($sql2);
               if($res->num_rows){
                  while($retCom = $res->fetch_assoc()){
                    if($retCom["fUpBy"] == 'student'){
                        	$sql3 = "SELECT `studentName`, `studentRegNo` FROM `tbl_students` WHERE `studentID`=".$retCom["studentID"];
											$res3 = $con->query($sql3);
											if($res3->num_rows){
												$stdDet = $res3->fetch_assoc();

											}	?>
                        <p class="card-text mb-0"><?php echo $retCom["fUpContent"]; ?><small class="float-right">     <?php echo $retCom["fUptimeStamp"]; ?></small>
                           <footer class="blockquote-footer"><cite title="<?php echo $stdDet["studentRegNo"];?>"><?php echo $stdDet["studentName"];?></cite></footer>
                        </p>
                        <?php
                      
                    }
                    elseif($retCom["fUpBy"] == 'depttAdmin'){
                      $sql4 = "SELECT `name`,`DeptID` FROM `tbl_deptadmins` WHERE `AdminID`=".$retCom["AdminID"];
                      $res4 = $con->query($sql4);
                      if($res4->num_rows){
                        $adminDet = $res4->fetch_assoc();
                        $sql6 = "SELECT `DeptName` from `tbl_departments` WHERE `DeptID`=".$adminDet["DeptID"];
                        $res6 = $con->query($sql6);
                        if($res6->num_rows){
                          $deptDet = $res6->fetch_assoc();
                        }
                        ?>
                        <p class="card-text mb-0"><?php echo $retCom["fUpContent"]; ?><small class="float-right">     <?php echo $retCom["fUptimeStamp"]; ?></small>
                           <footer class="blockquote-footer"><cite title="<?php echo $deptDet["DeptName"]; ?>"> <?php echo $adminDet["name"]; ?></cite></footer>
                        </p>
                        <?php
                      }
                    }
                    elseif($retCom["fUpBy"] == 'superAdmin'){
                      $sql4 = "SELECT `name` FROM `tbl_superadmin` WHERE `ID`=".$retCom["AdminID"];
                      $res4 = $con->query($sql4);
                      if($res4->num_rows){
                        $adminDet = $res4->fetch_assoc();
                        ?>
                        <p class="card-text mb-0"><?php echo $retCom["fUpContent"]; ?><small class="float-right">     <?php echo $retCom["fUptimeStamp"]; ?></small>
                           <footer class="blockquote-footer"><cite title="Super Admin"> <?php echo $adminDet["name"]; ?></cite></footer>
                        </p>
                        <?php
                      }
                    }
                  }
                }
              else{
                  ?>
                    <p class="card-text mb-0">
                      No Follow Ups
                   </p>
                  <?php
                  }
                  ?>
              </div>
              <button class="btn btn-danger btn-sm" id="hideFollowUp<?php echo $returned["ComptID"];?>" onclick="hideColl(<?php echo $returned["ComptID"]; ?>)">Hide Follow Ups</button>
            </div> 
              <!-- Follow Ups END -->
					</div>
			</div>
		<!--Complaint Card End  -->
		<!-- Info Modal Start -->
			<div class="modal fade" id="<?php echo $returned["ComptID"];?>" tabindex="-1" role="dialog" aria-hidden="true">
			 	<div class="modal-dialog modal-lg" role="document">
			    	<div class="modal-content">
				      	<div class="modal-header pb-2">
					        <h6 class="modal-title">Complaint By: <?php echo $returned["studentName"];?> -- <?php echo $returned["studentRegNo"];?> </h6>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          		<span aria-hidden="true">&times;</span>
					        </button>
				        </div>
				     	<div class="modal-body pt-1">
							<small><strong>Reference: <?php echo " ".$returned["comptRef"]?></strong></small>
					        <p class="mb-0" style="max-width: 100%; word-wrap: break-word;"><label class="form-control-label mb-0"><strong>Complaint Posted:</strong></label><?php echo " ".$returned["compliant"];?> </p>
							<h6 class="text-muted mb-0"> <label class="form-control-label mb-0"><strong>To:  </strong></label><?php echo " ".$deptDet["DeptName"]; ?> </h6>
							<?php if($returned["status"] == 1){
                        		?> <p class="mb-0"><strong>Reply: </strong><?php echo " ".$returned["reply"]; ?></p>
								<?php
									if($returned["repliedBy"] == 'admin'){
										$sql3 = "SELECT `name`,`DeptID` FROM `tbl_deptadmins` WHERE `AdminID`=".$returned["AdminID"];
										$res3 = $con->query($sql3);
										if($res3->num_rows){
											$adminDet1 = $res3->fetch_assoc();
											?>
												<p class="mb-0"><strong>Replied By: </strong><?php echo $adminDet1["name"];?></p>
											<?php
										}
									}
									else{
										?>
											<p class="mb-0"><strong>Replied By: </strong>Super Admin</p>
										<?php
									}
								?>
                                			<p class="mb-0"><strong>Replied on: </strong><?php echo " ".$returned["replyDate"];?></p>
                          	<?php }
                          	else{
                            	?>  <strong><span ID="status<?php echo $returned["ComptID"];?>" class="text-danger">	
                            		Not Replied Yet
                            	</span></strong>
								<div id="replyCont<?php echo $returned["ComptID"];?>" class="form-group col-md-8 pl-0">
								<textarea class="form-control" id="replyText<?php echo $returned["ComptID"];?>" rows="3" maxlength="500" placeholder="Write your reply..." value=""></textarea>
								</div>
                            <?php } ?>
								<span id="result<?php echo $returned["ComptID"];?>"></span><span id="replyDate<?php echo $returned["ComptID"];?>"></span>
				     	</div>
				        <div class="modal-footer py-2">
						<?php if($returned["status"] == 0){
					                                		?>
							<button type="button" id="replyBtn<?php echo $returned["ComptID"];?>" class="btn btn-outline-primary" onclick="postReply(<?php echo $returned["ComptID"]?>,<?php echo $returned["studentID"]; ?>);"><i class="fa fa-reply" aria-hidden="true"></i> Reply</button>
						<?php } ?>
					        <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
				        </div>
				    </div>
			    </div>
			</div>
		<?php
		}
	}else{
		?>
		<div class="jumbotron">
			<h1>No Posts</h1>
		</div>
	<?php }
	?>
	</div>
	<!-- Forward Modal START -->
	<div class="modal fade" id="forwardModal" tabindex="-1" role="dialog" aria-labelledby="forwardModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group" id="depttSelectForwardCont">
							<select class="form-control" id="depttSelectForward" name="depttID">
								<option selected value="">--Select Department--</option>
								<?php
									$fetch_query="SELECT `DeptID`,`DeptName` FROM `tbl_departments`";
									$query_result=$con->query($fetch_query);
									$cnt = $query_result->num_rows;
									if($cnt)
										{
											while($returned=$query_result->fetch_assoc()){
											echo '<option value="'.$returned["DeptID"].'">'.$returned["DeptName"].'</option>';
											}
										} ?>
							</select>
							<small id="resForward"></small>
						</div>
						<strong><p id="mesForward"></p></strong>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-primary" id="saveForward"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;Forward</button>
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Close</button>
					</div>
				</div>
			</div>
	</div>
	<!--Forward Modal END  -->
	 <!-- Follow Up Modal START -->
  <div class="modal fade" id="followUpModal" tabindex="-1" role="dialog" aria-labelledby="followUpModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form id="followUpForm">
            <div class="form-group" id="followUpCont">
               <textarea class="form-control" id="followUpText" name= "followUpText" rows="3" maxlength="300" placeholder="Write Follow Up here" value=""></textarea>
              <small id="resFollowUp"></small>
            </div>
            </form>
            <strong><p id="mesFollowUp"></p></strong>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" id="saveFollowUp" onclick="saveFollowUpN();"><i class="fa fa-share" aria-hidden="true"></i> Post</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
          </div>
        </div>
      </div>
  </div>
  <!--Follow Up Modal END  -->
	<div class="col-md-3">
				<!-- List-Group Panel -->
				<div class="card card-outline-info" style="margin-top:25px;">
					<div class="card-header pb-0">
						<h5 class="card-title"><i class="fa fa-bar-chart" aria-hidden="true"></i> Portal at Glance</h5>
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
						<h6>Stats by Department</h6>
						<div class="form-group" id="depttSelectStatsCont">
			    						<select class="form-control" id="depttSelectStats" name="depttID">
			    						<option selected value="">--Select Department--</option>
									<?php
										$fetch_query="SELECT `DeptID`,`DeptName` FROM `tbl_departments`";
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
										<small id="res"></small>
			  			</div>
							<p id="selectedDeptt"></p>
							<p id="totalCont" class="text-primary"></p>
							<p id="repliedCont" class="text-success"></p>
							<p id="pendingCont" class="text-warning"></p>
							<p id="resolvedCont" class="text-primary"></p>
							<p id="notResolvedCont" class="text-danger"></p>
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
