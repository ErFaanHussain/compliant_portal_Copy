<?php
	include("../includes/core.inc.php");
	if (!logged_in()) {
		echo 'not logged in';
		exit;
	}
include("../includes/DBConnection.inc.php");
		if(isset($_POST["depttName"]) && isset($_POST["dShortCode"]))
		{
			$dName = $_POST["depttName"];
			$shortCode = $_POST["dShortCode"];
			if (empty($dName) || empty($shortCode)) {
        echo 'fields empty';
        $con->close();
      }
			else
			{
				$search_query1 = "SELECT `DeptName` FROM `tbl_departments` WHERE `DeptName`='$dName'";
				$search_result1=$con->query($search_query1);
				if($search_result1->num_rows)
				{
					echo 'already exists';
          $con->close();
				}else {
					     $insert_query = "INSERT INTO `tbl_departments`(`DeptName`,`deptShortCode`) VALUES('$dName','$shortCode')";
					     $query_result = $con->query($insert_query);
					        if($con->affected_rows)
						        {
                           			header('Content-Type: application/json');
                					echo json_encode(array('status' => 'success', 'insertId' => $con->insert_id));
                           			$con->close();
                           		}
						         else{
                         			header('Content-Type: application/json');
                					echo json_encode(array('status' => 'failure'));
                         			$con->close();
                       			}
					    }
			}
			
			exit;
}
?>
