<?php
include("../includes/core.inc.php");
if(!logged_in()){
  echo 'not logged in';
}
 	if(isset($_POST['topicID']) && !empty($_POST['topicID']))
	{
		include("../includes/DBConnection.inc.php");
				$deleteQuery="DELETE FROM `tbl_forum_topic` WHERE `topic_id`=".$_POST['topicID'];
				$con->query($deleteQuery);
					if($con->affected_rows){
						echo 'success';
					}
					else{
						echo 'failure';
					}
		}else{
      echo 'failure';
    }
?>
