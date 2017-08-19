<?php
  include("../includes/core.inc.php");
  if (!logged_in()) {
    echo 'not logged in';
  }
if(isset($_POST["topicContents"])){
  		if(!empty($_POST["topicContents"])){
  			$topic=$_POST["topicContents"];
  			date_default_timezone_set("Asia/Kolkata");
  			$timeStamp=date("d-m-Y h:i:s A");
  			$sql = "INSERT INTO `tbl_forum_topic`(`topic`,`topic_timeStamp`,`admin_id`)VALUES('$topic','$timeStamp',".$_SESSION["adminID"].")";
        include_once("../includes/DBConnection.inc.php");
        $result = $con->query($sql);
  			if ($con->affected_rows) {
  				echo 'success';
  			}
  			else{
  				echo 'failure DB';
  			}
  		}
  		else{
  		echo 'failure empty';
  		}
}
?>
