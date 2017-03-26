
<?php
include("includes/core.inc.php");
if(logged_in()){
	include("includes/adminheader.inc.php");
}
else{
	header('Location:index.php');
}
if(isset($_POST["createDeptt"]))
{
	if(isset($_POST["deptName"]))
	{
		$deptName=$_POST["deptName"];
		if(empty($deptName))
		{
			echo '<p class="userErrorLabel">Please Enter Department Name</p>';	
		}
		else
		{
			include("includes/DBConnection.inc.php");
			$search_query="SELECT DeptName FROM tbl_departments WHERE DeptName='$deptName'";
			$search_result=$con->query($search_query);
			if($search_result->num_rows)
			{
				echo "<script>alert('Department Already Exists')</script>";
			}	
			else{
			$insert_query = "INSERT INTO tbl_departments(DeptName) VALUES('$deptName')";
			$query_result = $con->query($insert_query);
			if($con->affected_rows)
			{
				echo "<script>alert('Department Created')</script>";
			}
			else{
				echo "<script>alert('Error in Creation, please try again')</script>";
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Department Creation-Super Admin</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="mainScr">
	<form method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">
		<!-- <p class="Label">Enter name of the Department:</p> -->
		<input type="text" class="textbox" value="" name="deptName" placeholder="Department Name?"/></br>
		<input type="submit" class="button" name="createDeptt" value="Create" />
		<input type="reset" class="button" name="cancel" value="Cancel" />
	</form>
</div>
</body>
</html>