<?php
	include("../includes/core.inc.php");
	if (!logged_in()) {
		echo 'not logged in';
		exit;
	}
include("../includes/DBConnection.inc.php");
if(isset($_POST["depttID"]) && isset($_POST["dAdminName"]) && isset($_POST["dEmail"]) && isset($_POST["uname"]) && isset($_POST["pwd"]))
{
		if(empty($_POST["depttID"]) || empty($_POST["dAdminName"]) || empty($_POST["dEmail"]) || empty($_POST["uname"]) || empty($_POST["pwd"]))
		{
      echo 'fields empty';
      $con->close();
      exit;
    		}
		else
		{
			$name=$_POST["dAdminName"];
			$email=$_POST["dEmail"];
			$depttID=$_POST["depttID"];
			$username=$_POST["uname"];
			$password=$_POST["pwd"];
			$search_query = "SELECT `UserName` FROM `tbl_deptadmins` WHERE `UserName`='$username'";
			$search_result=$con->query($search_query);
			if($search_result->num_rows)
			{
				echo 'uid exists';
        $con->close();
			}else{
			     $insert_query = "INSERT INTO `tbl_deptadmins`(`DeptID`,`name`,`email`,`UserName`,`Password`) VALUES('$depttID','$name','$email','$username','$password')";
			        $query_result = $con->query($insert_query);
			           if($con->affected_rows)
			              {
                      echo 'success';
                      $con->close();
                    }
			            else{
                     echo 'system error';
                     $con->close();
      	             }
			}
		}
}
?>
