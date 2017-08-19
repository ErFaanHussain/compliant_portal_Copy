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
    <title>Post Topic - IUST Feedback Portal</title>

<?php
  include("includes/DBConnection.inc.php");
  include("includes/adminheader.inc.php");

  if(isset($_POST["postTopic"])){
  	if(isset($_POST["topicContents"])){
  		if(!empty($_POST["topicContents"])){
  			$topic=$_POST["topicContents"];
  			date_default_timezone_set("Asia/Kolkata");
  			$timeStamp=date("d-m-Y h:i:s A");
  			// admin id $_SESSION["adminID"]
  			$sql = "INSERT INTO `tbl_forum_topic`(`topic`,`topic_timeStamp`,`admin_id`)VALUES('$topic','$timeStamp',".$_SESSION["adminID"].")";
  			$result = $con->query($sql);
  			if ($con->affected_rows) {
  				echo '<script>alert("Topic Successfully Posted");</script>';
  			}
  			else{
  				echo '<script>alert("Something went wrong in DB Insertion, Contact Administrator");</script>';
  			}
  		}
  		else{
  		echo '<script>alert("Please enter the Post Contents");</script>';
  		}
  	}

  }
?>
</head>
<body>
	<div align="center">
		<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
			<textarea id="topicText" name="topicContents" placeholder="Topic Contents here" value="" rows="5"></textarea><br>
			<button type="submit" name="postTopic">Post</button>
			<button type="reset">Cancel</button>
		</form>
	</div>
</body>
</html>
