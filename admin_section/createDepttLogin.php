<!DOCTYPE html>
<html>
<head>
	<title>Create Department Login-Super Admin</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php
include("includes/core.inc.php");
if(logged_in()){
	include("includes/adminheader.inc.php");
	include("includes/DBConnection.inc.php");
	$fetch_query="SELECT DeptID,DeptName FROM tbl_departments";
	$query_result=$con->query($fetch_query);
	$cnt = $query_result->num_rows;
	if($cnt)
	{
		echo '<div class="mainScr">
				<form method="POST" action="'.$_SERVER["PHP_SELF"].'">
				 	Select Department: 
				 	<select class="dropdown" name="deptt" value="">';
				while($returned=$query_result->fetch_assoc()){
					echo '<option value="'.$returned["DeptID"].'">'.$returned["DeptName"].'</option>';		
				}
			echo '</select></br>
			<input type="text" class="textbox" name="name" value="" placeholder="Name of Department Admin" /><br/>
			<input type=text class="textbox" name="username" value="" placeholder="Enter Username"/><br/>
			<input type="text" class="textbox" name="password" value="" placeholder="Enter Password"/><br/>
			<input type="submit" class="button" name="create" value="Create"/>
			<input type="reset" class="button" name="cancel" value="Cancel"/>';
	}
	else{
		echo '<p class="label">No Departments Found, Please add some.</p>';
		exit;
	}

}
else{
	header('Location:index.php');
}
?>
<?php
if(isset($_POST["create"]))
{
	if(isset($_POST["deptt"]) && isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["password"])){
		$dept=$_POST["deptt"];
		$name=$_POST["name"];
		$usern=$_POST["username"];
		$passw=$_POST["password"];
		if(empty($dept) || empty($name) || empty($usern) || empty($passw))
		{
			echo '<p class="label">Some Details missing, please fill up.</p>';
		}
		else{
			include("includes/DBconnection.inc.php");
			$search_query = "SELECT UserName FROM tbl_deptadmins WHERE UserName='$usern'";
			$search_result=$con->query($search_query);
			if($search_result->num_rows)
			{
				echo "<script>alert('Username already exixts, choose something different')</script>";
			}else{
				$insert_query="INSERT INTO tbl_deptadmins(DeptID,name,UserName,Password) VALUES('$dept','$name','$usern','$passw')";
				$insert_result=$con->query($insert_query);
				if($con->affected_rows)
				{
					echo "<script>alert('Department Login Created')</script>";
				}
				else{
					echo "<script>alert('Error in Login Creation, please try again')</script>";
				}
			}
		}
	}
}
?>

</body>
</html>