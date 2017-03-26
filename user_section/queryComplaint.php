<?php
include("includes/user_header.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Query Compliant:Compliant Portal</title>
</head>
<body>
<div class="mainScreen">
	<form class="userForm" method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">
		<p class="userLabel">Enter Compliant ID:</p>
		<input type="number" class="textbox" name="compliantID" value="" placeholder="" min="1" /><br/>
		<input type="submit" class="button" name="submit" value="Query"/>
		<input type="reset" class="button" name="reset" value="Cancel"/>
	</form>
	<div class="responseScreen">
	<?php
		if(isset($_POST["submit"]))
		{
			if(isset($_POST["compliantID"]) && !empty($_POST["compliantID"]))
			{
				$complID=$_POST["compliantID"];
				include("includes/DBConnection.inc.php");
				$search_query="SELECT * FROM tbl_compliant WHERE ComptId='$complID'";
				$search_result=$con->query($search_query);
				$cnt=$search_result->num_rows;
					if($cnt)
					{
						while($returned=$search_result->fetch_assoc())
						{
							if($returned["status"]=="0")
							{
								echo '<p class="userLabelError">No Response Yet.</p>';
							}	
							else
							{
							  echo '<p class="retrievalLabel">Yeah! Mr.'.$returned["name"].' You have been replied</p>';
							  echo '<p class="retrievalLabel">'.$returned["reply"].'</p>';
							}
								
						}	
					}
					else{
						echo '<p class="userLabelError">Not Found, Please check your Compliant ID and try again.</p>';
					}
			}else{
				echo '<p class="userLabelError">Please Enter Compliant ID</p>';
			}
		}
	?>
	</div>
</div>
</body>
</html>