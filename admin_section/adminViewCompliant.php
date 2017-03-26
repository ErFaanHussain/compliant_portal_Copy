<!-- Super Admin View Selected Compliant -->
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
	<title>Super Admin-View Compliant</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script language="javascript" type="text/javascript">
	function del(delId){
		var ajaxRequest;

		try{
			ajaxRequest=new XMLHttpRequest();
		}catch(e){
				try{
					ajaxRequest=new ActiveXObject("Msxml2.XMLHTTP");
				}catch(e){
					try{
						ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
					}catch(e){
						alert("Can't send XMLHttpRequest, Contact Administrator!");
						return false;
					}
				}
		}
		ajaxRequest.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				if(this.responseText == 1){
					alert("Compliant Successfully Deleted");
				}else{
					alert("No Response from Server");
				}
			}
		}
		var compID = delId;
		var queryString = "?deleteId=" + compID;
		ajaxRequest.open("GET", "deleteAJAX.php" + queryString, true);
		ajaxRequest.send();

	}
</script>
</head>
<body>
<div class="mainScr">
<table class="dashboard">
	<tr>
		<th class="headSmall">ID</th>
		<th>Name</th>
		<th>Contact</th>
		<th>Email</th>
		<th>Subject</th>
		<th>Compliant</th>
		<th>Status</th>
		<th>Reply</th>
		<th class="headSmall">Action</th>
	</tr>
	<?php
	if(isset($_GET["ComptID"]))
	{
		$comptID=$_GET["ComptID"];
		if(!empty($comptID))
		{
		$search_query="SELECT ComptID,name,mobile,email,subject,compliant,status,reply FROM tbl_compliant 
						WHERE ComptID='$comptID'"; 
		$query_result=$con->query($search_query);
		if($query_result->num_rows)
		 {
			while($returned=$query_result->fetch_assoc())
			{
				echo "<tr><td>".$returned["ComptID"]."</td>";
				echo "<td>".$returned["name"]."</td>";
				echo "<td>".$returned["mobile"]."</td>";
				echo "<td>".$returned["email"]."</td>";
				echo "<td>".$returned["subject"]."</td>";
				echo "<td>".$returned["compliant"]."</td>";
				echo "<td>".$returned["status"]."</td>";
				echo "<td>".$returned["reply"]."</td>";
			
			echo '<td><input type="button" class="button" value="Delete" onclick="del('.$returned["ComptID"].');"></td>';
			}
			echo "</tr>";
	   	 }else{
	   	 	header('Location:admin_dashboard.php');
	   	 }
		}
		else{
			header('Location:admin_dashboard.php');
		}
	}
?>
</table>
</div>

</body>
</html>