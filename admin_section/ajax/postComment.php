<?php
	include("../includes/admin.core.inc.php");
	if (!logged_in()) {
		echo 'not logged in';
	}
	else{
		if(isset($_POST["topicId"]) && isset($_POST["comment"]) && !empty($_POST["topicId"]) && !empty($_POST["comment"])){
			$topicID = $_POST["topicId"];
			$comment = htmlentities($_POST["comment"]);
			date_default_timezone_set("Asia/Kolkata");
  			$timeStamp=date("d-m-Y h:i:s A");
  			$sql = "INSERT INTO `tbl_forum_comments`(`topic_id`,`user`,`AdminID`,`comment`,`comment_timeStamp`) VALUES($topicID,'dAdmin',".$_SESSION["adminID"].",'$comment','$timeStamp')";
  			include("../includes/DBConnection.inc.php");
  			$res=$con->query($sql);
  			if ($con->affected_rows) {
  				echo $timeStamp;
  			}
		}
		$con->close();
	}
?>
