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
    <title>Student Dashboard - IUST Feedback Portal</title>

<?php
  include("includes/DBConnection.inc.php");
  include("includes/header.inc.php");
?>
<script src="js/customJSstdDashboard.js"></script>
<!-- Container for main Dashboard -->
<div class="container-fluid pb-4">
<div class="row">
  <div class="col-md-9" id="MainDashboard1">
  <h6>Logged In As:<strong> <?php echo $_SESSION["studentName"]; ?></strong></h6>
  <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <strong>Info!&nbsp;</strong>All the Complaints you have posted are stationed here. 
      </div>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <strong>Do you Know?&nbsp;</strong>You can add follow up to your complaint if it isn't resolved by the first reply.
      </div>
      <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <strong>Info!&nbsp;</strong>Kindly mark the posts 'Resolved' to close the complaints, if it has been resolved.
      </div>
  <?php
  $search_query="SELECT `ComptID`,`comptRef`,`date`,`subject`,`repliedBy`,`AdminID`,`compliant`,`reply`,`DeptID`,`replyDate`,`status`,`resolvedFlag` FROM `tbl_compliant` WHERE `studentID`=".$_SESSION["studentID"];

  $query_result=$con->query($search_query);
  if($query_result->num_rows)
  {
    while($returned=$query_result->fetch_assoc())
    {
      $deptSearch="SELECT `DeptName` FROM `tbl_departments` WHERE `DeptID`=".$returned["DeptID"];
        $searchResult=$con->query($deptSearch);
        $deptName=$searchResult->fetch_assoc();
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
        <div class="card" id="Card<?php echo $returned["ComptID"]; ?>" style="margin-top:10px;">
          <h6 class="card-header pb-0 px-1 px-md-3" style="background:#dbe3ea;">
            <label class="form-control-label">Post Reference: </label><?php echo " ".$returned["comptRef"];?>
            <label class="form-control-label float-right">Status: <?php if($returned["status"] == 0){echo '<span class="text-danger">Not Replied</span>';}else{echo '<span class="text-success">Replied</span>';}?>
              <?php if($returned["resolvedFlag"] == 'Y'){
                    ?>  <span id="statusP<?php echo $returned["ComptID"];?>" class="text-primary">| Resolved</span>
                    <?php }else{
                        ?>  <span id="statusP<?php echo $returned["ComptID"];?>" class="text-danger">| Not Resolved</span>
                      <?php }?>
            </label>
          </h6>
          <div class="card-block py-3 px-1 px-md-3">
            <h6 class="card-title "><strong>Subject:</strong> <?php echo $returned["subject"];?></h6>
            <h6 class="card-subtitle text-muted"><strong>To: </strong><?php echo $deptName["DeptName"];?></h6>
            <p class="card-text mb-0"><strong>Complaint: </strong><?php echo $returned["compliant"]; ?></p>
            <strong><span id="publishResult<?php echo $returned["ComptID"];?>"></span></strong>
          </div>
          <div class="card-footer text-muted py-1">
              
            <div class="hidden-sm-down">
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#<?php echo $returned["ComptID"]; ?>">
              <i class="fa fa-list-alt" aria-hidden="true"></i>  View Details
              </button>
                <?php if($returned["status"] == 1 && $returned["resolvedFlag"] == 'N'){ ?>
                    <button type="button" class="btn btn-outline-danger btn-sm" id="followUp<?php echo $returned["ComptID"];?>" onclick="followUp(<?php echo $returned['ComptID']; ?>);"><i class="fa fa-quote-left" aria-hidden="true"></i> Follow Up</button>
                <?php }else{ ?>
                    <button type="button" class="btn btn-outline-danger btn-sm" disabled><i class="fa fa-quote-left" aria-hidden="true"></i> Follow Up</button>
                  <?php }?>
              <?php if($returned["status"] == 0 || $returned["resolvedFlag"] == 'Y'){
                    ?>
                    <button type="button" class="btn btn-outline-primary btn-sm" disabled><i class="fa fa-check-square" aria-hidden="true"></i> Resolved?</button>
                 <?php     
                }
                else{ ?>
                    <button type="button" id="resolveBtn<?php echo $returned["ComptID"];?>" class="btn btn-outline-primary btn-sm" onclick="resolveC(<?php echo $returned["ComptID"];?>);"><i class="fa fa-check-square" aria-hidden="true"></i> Resolved?</button>
                  <?php } ?>
                  <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapse<?php echo $returned['ComptID']; ?>" aria-expanded="false">
                     <i class="fa fa-comment" aria-hidden="true"></i> View Follow Ups
                  </button>
              </div>
            <div class="hidden-md-up">
            <button type="button" class="btn btn-success btn-sm" style="display: inline;" data-toggle="modal" data-target="#<?php echo $returned["ComptID"]; ?>"><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;View Details </button>
              <div class="dropup" style="display:inline;">
                <a class="dropdown-toggle btn btn-primary btn-sm" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;Actions</a>
                <div class="dropdown-menu text-center" style="border-color: #31b0d5;">
                <!-- actions start -->
                <?php if($returned["status"] == 1 && $returned["resolvedFlag"] == 'N'){ ?>
                    <button type="button" class="btn btn-outline-danger btn-sm" id="followUpMob<?php echo $returned["ComptID"];?>" onclick="followUp(<?php echo $returned['ComptID']; ?>);"><i class="fa fa-quote-left" aria-hidden="true"></i>&nbsp;Add Follow Up</button>
                     <div class="dropdown-divider"></div>
                <?php }else{ ?>
                    <button type="button" class="btn btn-outline-danger btn-sm" disabled><i class="fa fa-quote-left" aria-hidden="true"></i>&nbsp;Add Follow Up</button>
                     <div class="dropdown-divider"></div>
                  <?php }?>
              <?php if($returned["status"] == 0 || $returned["resolvedFlag"] == 'Y'){
                    ?>
                    <button type="button" class="btn btn-outline-primary btn-sm" disabled><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Mark Resolved?</button>
                     <div class="dropdown-divider"></div>
                 <?php     
                }
                else{ ?>
                    <button type="button" id="resolveBtnMob<?php echo $returned["ComptID"];?>" class="btn btn-outline-primary btn-sm" onclick="resolveC(<?php echo $returned["ComptID"];?>);"><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Mark Resolved?</button>
                     <div class="dropdown-divider"></div>
                  <?php } ?>
                  <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapse<?php echo $returned['ComptID']; ?>" aria-expanded="false">
                     <i class="fa fa-comment" aria-hidden="true"></i>&nbsp;View Follow Ups
                  </button>
                <!-- actions end -->
                </div>
              </div>
            </div>
              <!-- Follow Ups START-->
            <div class="collapse" id="collapse<?php echo $returned['ComptID']; ?>">
              <div class="card card-block mx-0" style="max-height:200px; overflow-y: scroll;" id="followUpCard<?php echo $returned['ComptID'];?>">
            <?php
              $sql2 = "SELECT `fUpId`,`fUpContent`,`fUpBy`,`studentID`,`AdminID`,`fUptimeStamp` FROM `tbl_followups` WHERE `ComptID`=".$returned["ComptID"];
              $res = $con->query($sql2);
               if($res->num_rows){
                  while($retCom = $res->fetch_assoc()){
                    if($retCom["fUpBy"] == 'student'){
                        ?>
                        <p class="card-text mb-0"><?php echo $retCom["fUpContent"]; ?><small class="float-right">     <?php echo $retCom["fUptimeStamp"]; ?></small>
                           <footer class="blockquote-footer"><cite title="You">You</cite></footer>
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
                    <p class="card-text mb-0" id="noFollowUp<?php echo $returned["ComptID"];?>">
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
              <div class="modal fade" id="<?php echo $returned["ComptID"];?>" tabindex="-1" role="dialog" aria-labelledby="complaintModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header pb-0">
                          <h6 class="modal-title " id="complaintModalLabel">Complaint Reference: <?php echo $returned["comptRef"];?></h6>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h6 class="mb-0"> <label class="form-control-label"><strong>Date: </strong></label><?php echo $returned["date"]; ?> </h6>
                          <h6 class="text-muted"> <label class="form-control-label mb-0"><strong>To: </strong></label><?php echo $deptName["DeptName"];?> </h6>
                          <h6 class="mb-0" style="max-width: 100%; word-wrap: break-word;"><label class="form-control-label mb-1"><strong>Subject: </strong></label><?php echo $returned["subject"];?> </h6>
                          <p class="mb-0" style="max-width: 100%; word-wrap: break-word;"><label class="form-control-label mb-1"><strong>Complaint Posted:</strong></label><?php echo $returned["compliant"];?> </p>
                          <?php if($returned["status"] == 1){
                                ?> <p class="mb-0"><label class="form-control-label mb-1"><strong>Reply: </strong> </label><?php echo $returned["reply"]; ?></p>
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
                            ?>  <span class="text-danger"><strong>No Reply Yet</strong></span>
                            <?php } ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove" aria-hidden="true"></i> Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
      <?php   
    }
  }
  ?>
  </div>
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
          <form id="followUpForm1">
            <div class="form-group" id="followUpCont">
              <textarea class="form-control" id="followUpText" name="followUpText1" rows="3" placeholder="Write Follow Up here" value=""></textarea>
              <small class="form-text" id="resFollowUp"></small>
            </div>
          </form>
            <strong><p id="mesFollowUp"></p></strong>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" id="saveFollowUp" onclick="saveFollowUpN();"><i class="fa fa-share" aria-hidden="true"></i> Post</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="modalClose"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
          </div>
        </div>
      </div>
  </div>
  <!--Follow Up Modal END  -->
  <div class="col-md-3">
        <!-- List-Group Panel -->
        <div class="card card-outline-info mt-3 mt-md-4">
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