<!-- Super Admin Master Dashboard -->
<?php
	include("includes/core.inc.php");
	if(logged_in()){
		include("includes/adminheader.inc.php");
		include("includes/DBConnection.inc.php");
	}	
	else{
		header('Location:index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Super Admin-Compliant Dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="mainScr">
<table class="dashboard">
	<tr>
		<th class="headSmall">S.No</th>
		<th class="headSmall">ID</th>
		<th>Subject</th>
		<th colspan=3 class="headSmall">Action</th>
	</tr>
	<?php
	// $deptID=$_SESSION["deptID"];
	$serial=0;
	$search_query="SELECT ComptID,subject FROM tbl_compliant"; // WHERE DeptID='$deptID'";
	$query_result=$con->query($search_query);
	if($query_result->num_rows)
	{
		while($returned=$query_result->fetch_assoc())
		{
			echo "<tr><td>";
			echo ++$serial."</td>";
			echo "<td>".$returned["ComptID"]."</td>";
			echo "<td>".$returned["subject"]."</td>";
			echo '<td><a href="adminViewCompliant.php?ComptID='.$returned["ComptID"].'">View</a></td>';
			echo '<td><a href="publish.php?ComptID='.$returned["ComptID"].'">Publish</a></td>';
			echo '<td><a href="deleteCompliant.php?ComptID='.$returned["ComptID"].'">Delete</a></td></tr>';		
		}
	}
	?>
</table>
</div>
</body>
</html>