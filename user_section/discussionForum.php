<?php
	include("includes/core.inc.php");
	if (!logged_in()) {
		header('Location:index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Discussion Forum-IUST Feedback Portal</title>
<?php
include("includes/DBConnection.inc.php");
include("includes/header.inc.php");
?>
<script src="js/customJSforum.js"></script>
<!-- Container for main Dashboard -->
<div class="container-fluid pb-3 mb-1">
<div class="row">
  <div class="col-md-9" id="MainDashboard1">
  <h6 >Logged In As:<strong> <?php echo $_SESSION["studentName"]; ?></strong></h6>
  <?php
  $search_query="SELECT `topic_id`,`topic`,`topic_timeStamp` FROM `tbl_forum_topic`";
  $query_result=$con->query($search_query);
	if($query_result->num_rows)
  {
    while($returned=$query_result->fetch_assoc())
    {
      ?>
        <div class="card card-outline-info" style="margin-top:10px;">
          <h5 class="card-header pb-0 px-1 px-md-3" style="background:#dbe3ea;"><i class="fa fa-comments" aria-hidden="true"></i> 
          <?php echo " ".$returned["topic"];?>
            <label class="form-control-label text-primary float-right pr-1"><small><?php echo $returned["topic_timeStamp"]?></small></label>
          </h5>
          <div class="card-block px-0 py-2">
                <div id="commentCont<?php echo $returned["topic_id"];?>" class="input-group col-md-9 pl-0 pr-1 pb-0">
                  <textarea class="form-control ml-2" style="overflow-y:auto;" id="comment<?php echo $returned["topic_id"];?>" name="comment" placeholder="Write your comment" maxlength="200" rows="1"></textarea>
                  <span class="input-group-btn">
                    <button id="commentPost" class="btn btn-outline-primary px-1 px-md-2" onclick="postComment(<?php echo $returned['topic_id']; ?>);"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Post</button>
                  </span>
                  </div>
									<?php
										$sql5 = "SELECT COUNT(*) AS `totalComments` FROM `tbl_forum_comments` WHERE `topic_id`=".$returned["topic_id"];
										$res5 = $con->query($sql5);
										if($res5->num_rows){
											$tCount=$res5->fetch_assoc();
											?>
											<div class="text-primary ml-3 pb-1" id="commentCount<?php echo $returned["topic_id"]; ?>" ><?php echo $tCount["totalComments"]." ";?>Comments</div>
											<?php
										}else{
											?>
												<span class="text-primary ml-3 pb-1">0 Comments</span>
											<?php
										}
									 ?>
                  <button class="btn btn-primary btn-sm ml-2" type="button" data-toggle="collapse" data-target="#<?php echo $returned['topic_id']; ?>" aria-expanded="false">
                     <i class="fa fa-comment" aria-hidden="true"></i>&nbsp;View Comments
                  </button>
            <div class="collapse" id="<?php echo $returned['topic_id']; ?>">
              <div class="card card-block mx-0" style="max-height:200px; overflow-y: scroll;" id="commentCard<?php echo $returned['topic_id'];?>">
            <?php
              $sql2 = "SELECT `comment`,`user`,`AdminID`,`student_id`,`comment_timeStamp` FROM `tbl_forum_comments` WHERE `topic_id`=".$returned["topic_id"];
              $res = $con->query($sql2);
               if($res->num_rows){
                  while($retCom = $res->fetch_assoc()){
										if($retCom["user"] == 'student'){
											$sql3 = "SELECT `studentName` FROM `tbl_students` WHERE `studentID`=".$retCom["student_id"];
											$res3 = $con->query($sql3);
											if($res3->num_rows){
												$stdDet = $res3->fetch_assoc();
												?>
												<p class="card-text mb-0"><?php echo $retCom["comment"]; ?><small class="float-right">     <?php echo $retCom["comment_timeStamp"]; ?></small>
		                       <footer class="blockquote-footer"><cite title="Student"> <?php echo $stdDet["studentName"]; ?></cite></footer>
		                    </p>
												<?php
											}
										}
										elseif($retCom["user"] == 'dAdmin'){
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
												<p class="card-text mb-0"><?php echo $retCom["comment"]; ?><small class="float-right">     <?php echo $retCom["comment_timeStamp"]; ?></small>
		                       <footer class="blockquote-footer"><cite title="<?php echo $deptDet["DeptName"]; ?>"> <?php echo $adminDet["name"]; ?></cite></footer>
		                    </p>
												<?php
											}
										}
										elseif($retCom["user"] == 'superAdmin'){
											$sql4 = "SELECT `name` FROM `tbl_superadmin` WHERE `ID`=".$retCom["AdminID"];
											$res4 = $con->query($sql4);
											if($res4->num_rows){
												$adminDet = $res4->fetch_assoc();
												?>
												<p class="card-text mb-0"><?php echo $retCom["comment"]; ?><small class="float-right">     <?php echo $retCom["comment_timeStamp"]; ?></small>
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
                      No Comments
                   </p>
                  <?php
                  }
                  ?>
              </div>
            </div>    
                <!-- here -->
          </div>
        </div>
      <?php
    }
  }
  else{
    ?>
          <div class="card" style="margin-top:10px;">
          <h5 class="card-header pb-0" style="background:#dbe3ea;">No Posts Yet</h5>
          </div>
  <?php
    $con->close(); }
  ?>
  </div>
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
          </div>
        </div>
<?php  $con->close(); ?>
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
    <a style="text-decoration: none;" href="http://facebook.com/erfaanhussain6"><strong style="color:#292b2c;">ErFaan</strong></a> &amp; <a style="text-decoration: none;" href="facebook.com/erfaanhussain6"><strong style="color:#292b2c;">Umar</strong></a> 
    </div>
    <small class="my-0">Copyright &copy; DOCS - IUST 2017 </small>
  </div>
</footer>
</body>
</html>
