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
  include("includes/header.inc.php");
  include("includes/DBConnection.inc.php");
?>
<script type="text/javascript">
      $(document).ready(function(){
        $("#dashboardLink").addClass("active");
      });
    </script>
<!-- Container for main Dashboard -->
<div class="container-fluid px-0">
  <div class="col-md-9"  style="float:left; !important" id="MainDashboard1">
  <h6>Logged In As:<strong> <?php echo $_SESSION["studentName"]; ?></strong></h6>
  <?php
  $search_query="SELECT `ComptID`,`comptRef`,`date`,`subject`,`compliant`,`reply`,`DeptID`,`replyDate`,`status` FROM `tbl_compliant` WHERE `studentID`=".$_SESSION["studentID"];

  $query_result=$con->query($search_query);
  if($query_result->num_rows)
  {
    while($returned=$query_result->fetch_assoc())
    {
      $deptSearch="SELECT `DeptName` FROM `tbl_departments` WHERE `DeptID`=".$returned["DeptID"];
        $searchResult=$con->query($deptSearch);
        $deptName=$searchResult->fetch_assoc();
          if ($returned["status"] == 0) {
              ?>
              <script>
                $(document).ready(function(){
                  $("#Card<?php echo $returned["ComptID"]; ?>").addClass("card-outline-danger");
                });
              </script>
              <?php
            }
          else{
              ?>
              <script>
                $(document).ready(function(){
                  $("#Card<?php echo $returned["ComptID"]; ?>").addClass("card-outline-primary");
                });
              </script>
              <?php
          }
      ?>
        <div class="card" id="Card<?php echo $returned["ComptID"]; ?>" style="margin-top:10px;">
          <h6 class="card-header p-b-0" style="background:#dbe3ea;">
            <label class="form-control-label">Post Reference: </label><?php echo " ".$returned["comptRef"];?>
            <label class="form-control-label float-right">Status: <?php if($returned["status"] == 0){echo '<span class="text-danger">Not Replied</span>';}else{echo '<span class="text-success">Replied</span>';}?></label>
          </h6>
          <div class="card-block">
            <h6 class="card-title"><strong>Subject:</strong> <?php echo $returned["subject"];?></h6>
            <h6 class="card-subtitle mb-2 text-muted"><strong>To: </strong><?php echo $deptName["DeptName"];?></h6>
            <p class="card-text"><strong>Complaint: </strong><?php echo $returned["compliant"]; ?></p>
                        <!-- Button trigger modal -->
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#<?php echo $returned["ComptID"]; ?>">
              View Details
              </button>
              <div class="modal fade" id="<?php echo $returned["ComptID"];?>" tabindex="-1" role="dialog" aria-labelledby="complaintModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h6 class="modal-title" id="complaintModalLabel">Complaint Reference: <?php echo $returned["comptRef"];?></h6>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h6> <label class="form-control-label"><strong>Date: </strong></label><?php echo $returned["date"]; ?> </h6>
                          <h6 class="text-muted"> <label class="form-control-label"><strong>To: </strong></label><?php echo $deptName["DeptName"];?> </h6>
                          <h6><label class="form-control-label"><strong>Subject: </strong></label><?php echo $returned["subject"];?> </h6>
                          <p><label class="form-control-label"><strong>Complaint Posted:</strong></label><?php echo $returned["compliant"];?> </p>
                          <hr>
                          <?php if($returned["status"] == 1){
                                ?> <p><label class="form-control-label"><strong>Reply: </strong> </label><?php echo $returned["reply"]; ?></p>
                                <p><strong>Replied on: </strong><?php echo $returned["replyDate"];?></p>
                          <?php }else{
                            ?>  <span class="text-danger">Not Replied Yet</span>
                            <?php } ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  
          </div>
        </div>
      
      <?php   
    }
  }
  ?>
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

</body>
</html>