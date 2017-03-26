<!-- Super Admin Master Dashboard -->
<?php
	include("includes/user_header.inc.php");
	include("includes/DBConnection.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home-IUST Feedback</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="mainScr">
<table>
	<tr>
		<th class="headSmall">ID</th>
		<th>Name</th>
		<th>Subject</th>
		<th>Compliant</th>
		<th>Reply</th>
		<th>Department</th>
	</tr>
	<?php
	$search_query="SELECT ComptID,name,subject,compliant,reply,DeptID FROM tbl_compliant WHERE `publish_flag`='Y'";
	$query_result=$con->query($search_query);
	if($query_result->num_rows)
	{
		while($returned=$query_result->fetch_assoc())
		{
			$deptSearch="SELECT `DeptName` FROM tbl_departments WHERE `DeptID`=".$returned["DeptID"];
			$searchResult=$con->query($deptSearch);
			$deptName=$searchResult->fetch_assoc();

			echo "<tr><td>".$returned["ComptID"]."</td>";
			echo "<td>".$returned["name"]."</td>";
			echo "<td>".$returned["subject"]."</td>";
			echo "<td>".$returned["compliant"]."</td>";
			echo "<td>".$returned["reply"]."</td>";
			echo "<td>".$deptName["DeptName"]."</td>";
			echo '</tr>';		
		}
	}
	?>
</table>
</div>
</body>
</html>