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
  	
<?php
include("includes/header.inc.php");
?>
<title>About-IUST Feedback Portal</title>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#aboutLink").addClass("active");
      });
    </script>
<div class="jumbotron">
	<h1>Not Created Yet</h1>
</div>


</body>
</html>