<!-- Department Dashboard -->
<?php
include("includes/admin.core.inc.php");
	if(logged_in()){
		include("includes/dept.adminheader.inc.php");
	}
	else
	{
		header('Location:depttLogin.php');
	}
include("includes/DBConnection.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Department Dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="mainScr">
<table class="dashboard">
	<tr>
		<th class="headSmall">S.No</th>
		<th class="headSmall">ID</th>
		<th>Subject</th>
		<th class="headSmall">Action</th>
	</tr>
	<?php
	$deptID=$_SESSION["deptID"];
	$serial=0;
	$search_query="SELECT ComptID,subject FROM tbl_compliant WHERE DeptID='$deptID'";
	$query_result=$con->query($search_query);
	if($query_result->num_rows)
	{
		while($returned=$query_result->fetch_assoc())
		{
			echo "<tr><td>";
			echo ++$serial."</td>";
			echo "<td>".$returned["ComptID"]."</td>";
			echo "<td>".$returned["subject"]."</td>";
			echo '<td><a href="viewCompliant.php?ComptID='.$returned["ComptID"].'" target=_blank>View</a></td></tr>';		
		}
	}
	?>
</table>
</div>
</body>
</html>