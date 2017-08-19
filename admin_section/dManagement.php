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
<script type="text/javascript" src="js/customJSDeptManager.js"></script>
<div class="container pb-4">
	<h6>Logged In As:<strong> <?php echo $_SESSION["name"]." -- ";?> Super Admin </strong></h6>
	<div class="col-sm-6 mx-auto mt-3" >
		<div id="resultAlert" role="alert">
		</div>
		<ul id="deptManageTabList" class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" href="#cDeptt" id="cDept-tab" role="tab" data-toggle="tab" aria-controls="Create Department" aria-expanded="true"><h6><i class="fa fa-plus-circle" aria-hidden="true"></i> ADD Department</h6></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#cLogin" role="tab" id="cLogin-tab" data-toggle="tab" aria-controls="Create Login"><h6><i class="fa fa-user-plus" aria-hidden="true"></i> Create Login</h6></a>
			</li>
		</ul>
<!-- Content Panel -->
			<div id="dCreate-cLogin-content" class="tab-content">
				<div role="tabpanel" class="tab-pane fade show active" id="cDeptt" aria-labelledby="create department-tab">
					<form id="createDeptForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<div class="form-group" id="depttNameCont">
							<label class="col-form-label" for="depttName">Enter Department Name</label>
							<input type="text" class="form-control" id="depttName" name="depttName" value="" placeholder="Department Name">
						</div>
						<div class="form-group" id="shortCodeCont">
							<label class="col-form-label" for="shortCode">Enter Short Code</label>
							<input type="text" class="form-control" id="shortCode" name="dShortCode" value="" placeholder="e.g. 'DOCS' for Department of Computer Science">
							<small id="shortCodeHelp" class="form-text text-muted">Short Code should be an abbrevation of the department name</small>
						</div>
						<div class="form-group">
						<div class="text-center">
							<button type="button" class="btn btn-primary" id="createBtn"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
							<button type="reset" class="btn btn-danger ml-md-5" id="resetForm"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
						</div>
						</div>
					</form>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="cLogin" aria-labelledby="cLogin-tab">
					<form id="cLoginForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<div class="form-group" id="depttSelectCont">
								<label for="depttSelect">Select Department</label>
								<select class="form-control" id="depttSelect" name="depttID">
								<option selected value="">--Select Department--</option>
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
						<div class="form-group" id="adminNameCont">
							<label class="col-form-label" for="adminName">Enter Admin Name</label>
							<input type="text" class="form-control" id="adminName" name="dAdminName" value="" placeholder="Admin Full Name">
						</div>
						<div class="form-group" id="uidCont">
							<label class="col-form-label" for="uid">Enter Username</label>
							<input type="text" class="form-control" id="uid" name="username" value="" placeholder="Default Username">
						</div>
						<div class="form-group" id="pwdCont">
							<label class="col-form-label" for="pwd">Enter Password</label>
							<input type="password" class="form-control" id="pwd" name="password" value="" placeholder="Default Password">
							<small id="nameHelp" class="form-text text-muted">Password should be alphanumeric</small>
						</div>
						<div class="form-group" id="emailCont">
							<label class="col-form-label" for="email">Enter Email</label>
							<input type="text" class="form-control" id="email" name="dEmail" value="" placeholder="Admin Email">
						</div>
						<div class="form-group">
						<div class="text-center">
							<button type="button" class="btn btn-primary" id="cLoginBtn"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
							<button type="reset" class="btn btn-danger ml-md-5" id="resetForm2"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
						</div>
						</div>
					</form>
				</div>
			</div>
	</div>
</div>
<footer class="container-fluid py-3" style="background-color: #dadada;">
	<div class="text-center">
		<div class="my-0"><i class="fa fa-code" aria-hidden="true"></i> with <i class="fa fa-heart" aria-hidden="true"></i> by 
		<a style="text-decoration: none;" href="https://facebook.com/erfaanhussain6"><strong style="color:#292b2c;">ErFaan</strong></a> &amp; <a style="text-decoration: none;" href="https://facebook.com/superstudomi"><strong style="color:#292b2c;">Umar</strong></a> 
		</div>
		<small class="my-0">Copyright &copy; DOCS - IUST 2017 </small>
	</div>
</footer>
</body>
</html>
