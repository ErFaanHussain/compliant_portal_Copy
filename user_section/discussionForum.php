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
include("includes/header.inc.php");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
      $(document).ready(function(){
        $("#forumLink").addClass("active");

      });
      function postComment(Id){
           jQuery(document).ready(function(){
              var com = jQuery("#comment"+Id).val();
              console.log(com);
              if(!com == ""){
                jQuery.post("postComment.php",{ topicId: Id , comment: com },
                function(data, status){
                  if(status == 'success'){
                    jQuery("#comment"+Id).val("");
                    jQuery("#commentCont"+Id).removeClass("has-danger");
                    jQuery("#comment"+Id).removeClass("form-control-danger");
                    jQuery("#commentCard"+Id).append('<p class="card-text mb-0">'+com+'<small class="float-right">'+data+'</small><footer class="blockquote-footer"><cite>You</cite></footer></p>');
                  }
                  jQuery("#commentCont"+Id).addClass("has-success");
                  jQuery("#comment"+Id).addClass("form-control-success");
                  setTimeout((function(){jQuery("#commentCont"+Id).removeClass("has-danger").removeClass("form-control-danger");
                      jQuery("#commentCont"+Id).removeClass("has-success").removeClass("form-control-success");}),3000);
              });
            }else{
              jQuery("#commentCont"+Id).addClass("has-danger");
              jQuery("#comment"+Id).addClass("form-control-danger");

            }
           });
      }
    </script>
<!-- Container for main Dashboard -->
<div class="container-fluid px-0">
  <div class="col-md-9"  style="float:left; !important" id="MainDashboard1">
  <h6>Logged In As:<strong> <?php echo $_SESSION["studentName"]; ?></strong></h6>
  <?php
  include("includes/DBConnection.inc.php");
  $search_query="SELECT `topic_id`,`topic`,`topic_timeStamp` FROM `tbl_forum_topic`";
  $query_result=$con->query($search_query);
  if($query_result->num_rows)
  {
    while($returned=$query_result->fetch_assoc())
    {
      ?>
        <div class="card" style="margin-top:10px;">
          <h5 class="card-header p-b-0" style="background:#dbe3ea;">
          <?php echo " ".$returned["topic"];?>
            <label class="form-control-label text-primary float-right"><small><?php echo $returned["topic_timeStamp"]?></small></label>
          </h5>
          <div class="card-block px-0">
                <div id="commentCont<?php echo $returned["topic_id"];?>" class="input-group col-md-9 px-0"> 
                  <textarea class="form-control" id="comment<?php echo $returned["topic_id"];?>" name="comment" placeholder="Write your comment..." maxlength="200" rows="1"></textarea>
                  <span class="input-group-btn">
                    <button id="commentPost" class="btn btn-outline-info" onclick="postComment(<?php echo $returned['topic_id']; ?>);">Post</button>
                  </span>
                  </div>
            <hr>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#<?php echo $returned['topic_id']; ?>" aria-expanded="false">
                  View Comments
                </button>
            <div class="collapse" id="<?php echo $returned['topic_id']; ?>">
              <div class="card card-block mx-0" id="commentCard<?php echo $returned['topic_id'];?>">
            <?php
              $sql2 = "SELECT `tbl_forum_comments`.`comment`,`tbl_forum_comments`.`comment_timeStamp`, `tbl_students`.`studentName`, `tbl_students`.`studentRegNo` FROM `tbl_forum_comments`,`tbl_students` WHERE `tbl_forum_comments`.`student_id`=`tbl_students`.`studentID` AND `tbl_forum_comments`.`topic_id`=".$returned["topic_id"];
              $res = $con->query($sql2);
               if($res->num_rows){
                  while($retCom = $res->fetch_assoc()){
                  ?>               
                   <p class="card-text mb-0"><?php echo $retCom["comment"]; ?><small class="float-right">     <?php echo $retCom["comment_timeStamp"]; ?></small>
                      <footer class="blockquote-footer"><cite title="<?php echo $retCom["studentRegNo"]; ?>"> <?php echo $retCom["studentName"]; ?></cite></footer>
                      </p>
                  <?php   
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
        
          </div>
        </div>   
      <?php   
    }
  }
  else{
    ?>
          <div class="card" style="margin-top:10px;">
          <h5 class="card-header p-b-0" style="background:#dbe3ea;">No Posts Yet</h5>
          </div>
  <?php
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