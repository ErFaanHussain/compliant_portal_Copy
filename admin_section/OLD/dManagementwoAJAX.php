<?php
	include("includes/core.inc.php");
	if (!logged_in()) {
		header('Location:./');
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Department Management-IUST Feedback Portal</title>
<?php
	include("includes/DBConnection.inc.php");
	include("includes/adminHeader.inc.php");
?>
<script type="text/javascript">
  		$(document).ready(function(){
  			$("#deptManager").addClass("active");
  		});
  	</script>
<script type="text/javascript" src="js/customJSDeptManager.js"></script>
<!-- ==START== Department Creation and Login Creation Code Starts -->
<div class="container">
	<div class="col-sm-6 mx-auto mt-md-3" >
<?php
if(isset($_POST["createSubmit"]))
{
		if(isset($_POST["depttName"]) && isset($_POST["dShortCode"]))
		{
			$dName = $_POST["depttName"];
			$shortCode = $_POST["dShortCode"];
			if (empty($dName) || empty($shortCode)) { ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<strong>Error!</strong> Please Enter Department Name and Short Code
					</div>
			<?php }
			else
			{
				$search_query1 = "SELECT `DeptName` FROM `tbl_departments` WHERE `DeptName`='$dName'";
				$search_result1=$con->query($search_query1);
				if($search_result1->num_rows)
				{
					?>
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<strong>Error!</strong> Department Already Exists
							</div>
					<?php
				}else {
					$insert_query = "INSERT INTO `tbl_departments`(`DeptName`,`deptShortCode`) VALUES('$dName','$shortCode')";
					$query_result = $con->query($insert_query);
						if($con->affected_rows)
						{ ?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<strong>Success!</strong> Department Created Successfully!
								</div>
						<?php }
						else{ ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<strong>Error!</strong> Cannot Create Department, Please Contact Administrator
								</div>
								<?php	}
							}
			}
	}
}
if(isset($_POST["cLoginSubmit"]))
{
	if(isset($_POST["depttID"]) && isset($_POST["dAdminName"]) && isset($_POST["dEmail"]) && isset($_POST["username"]) && isset($_POST["password"]))
	{
		$name=$_POST["dAdminName"];
		$email=$_POST["dEmail"];
		$depttID=$_POST["depttID"];
		$username=$_POST["username"];
		$password=$_POST["password"];
		if(empty($_POST["depttID"]) || empty($_POST["dAdminName"]) || empty($_POST["dEmail"]) || empty($_POST["username"]) || empty($_POST["password"]))
		{ ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<strong>Error!</strong> Please Enter all the details
					</div>
   <?php		}
		else
		{
			$search_query = "SELECT `UserName` FROM `tbl_deptadmins` WHERE `UserName`='$username'";
			$search_result=$con->query($search_query);
			if($search_result->num_rows)
			{
				?>
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<strong>Error!</strong> Username already Exists
						</div>
				<?php
			}else{
			$insert_query = "INSERT INTO `tbl_deptadmins`(`DeptID`,`name`,`email`,`UserName`,`Password`) VALUES('$depttID','$name','$email','$username','$password')";
			$query_result = $con->query($insert_query);
			if($con->affected_rows)
			{ ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<strong>Success!</strong> Login Created Successfully!
					</div>
			<?php }
			else{ ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<strong>Error!</strong> Something went wrong, Please Contact Administrator
					</div>
			<?php	}
			}
		}
	}
}
?>
		<ul id="deptManageTabList" class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" href="#cDeptt" id="cDept-tab" role="tab" data-toggle="tab" aria-controls="Create Department" aria-expanded="true"><h6>Create Department</h6></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="#cLogin" role="tab" id="cLogin-tab" data-toggle="tab" aria-controls="Create Login"><h6>Create Login</h6></a>
			</li>
		</ul>

<!-- Content Panel -->
			<div id="dCreate-cLogin-content" class="tab-content">
				<div role="tabpanel" class="tab-pane fade show active" id="cDeptt" aria-labelledby="create department-tab">
					<form id="createDeptForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<div class="form-group">
							<label class="col-form-label" for="username">Enter Department Name</label>
							<input type="text" class="form-control" id="depttName" name="depttName" value="" placeholder="Department Name">
						</div>
						<div class="form-group">
							<label class="col-form-label" for="shortCode">Enter Short Code</label>
							<input type="text" class="form-control" id="shortCode" name="dShortCode" value="" placeholder="e.g. 'DOCS' for Department of Computer Science">
							<small id="shortCodeHelp" class="form-text text-muted">Short Code should be an abbrevation of the department name</small>
						</div>
						<div class="form-group">
						<div class="text-center">
							<input type="submit" class="btn btn-primary" name="createSubmit" value="Create">
							<button type="reset" class="btn btn-danger ml-md-5">Cancel</button>
						</div>
						</div>
					</form>

				</div>

				<div role="tabpanel" class="tab-pane fade" id="cLogin" aria-labelledby="cLogin-tab">
					<form id="cLoginForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<div class="form-group">
								<label for="depttSelect">Select Department</label>
								<select class="form-control" id="depttSelect" name="depttID">
								<option selected value="null">--Select Department--</option>
						<?php
							$fetch_query="SELECT `DeptID`,`DeptName` FROM `tbl_departments`";
							$query_result=$con->query($fetch_query);
							$cnt = $query_result->num_rows;
							if($cnt)
								{
									while($returned=$query_result->fetch_assoc()){
										echo '<option value="'.$returned["DeptID"].'">'.$returned["DeptName"].'</option>';
										}
								}
						?>
							</select>
							</div>
						<div class="form-group">
							<label class="col-form-label" for="adminName">Enter Admin Name</label>
							<input type="text" class="form-control" id="adminName" name="dAdminName" value="" placeholder="Admin Full Name">
						</div>
						<div class="form-group">
							<label class="col-form-label" for="uid">Enter Username</label>
							<input type="text" class="form-control" id="uid" name="username" value="" placeholder="Default Username">
						</div>
						<div class="form-group">
							<label class="col-form-label" for="pwd">Enter Password</label>
							<input type="password" class="form-control" id="pwd" name="password" value="" placeholder="Default Password">
							<small id="nameHelp" class="form-text text-muted">Password should be alphanumeric</small>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="email">Enter Email</label>
							<input type="text" class="form-control" id="email" name="dEmail" value="" placeholder="Admin Email">
						</div>
						<div class="form-group">
						<div class="text-center">
							<button type="submit" class="btn btn-primary" id="cLoginBtn" name="cLoginSubmit">Create</button>
							<button type="reset" class="btn btn-danger ml-md-5">Cancel</button>
						</div>
						</div>
					</form>
				</div>

			</div>

	</div>
</div>

<!-- ==END== Department Creation and Login Creation Code Ends -->
</body>
</html>
