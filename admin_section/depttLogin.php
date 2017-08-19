<?php
include("includes/admin.core.inc.php");
if(logged_in()){
header('Location:dDashboard.php');
}?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Admin Login - IUST Feedback Portal</title>
<?php
	include("includes/logOut.header.php");
	include("includes/DBConnection.inc.php");
?>
<script type="text/javascript" src="js/customJSdeptLogin.js"></script>

<div class="container pb-2">
	<div class="col-sm-6 mx-auto mt-3" >
<?php
if(isset($_POST["loginSubmit"]))
	{
		if(isset($_POST["username"]) && isset($_POST["password"]))
		{
			$uname = $_POST["username"];
			$pass = $_POST["password"];
			if (empty($uname) || empty($pass))
			{ ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> Please Enter Username and Password
					</div>
			<?php }
			else
			{
				$login_query="SELECT `AdminID`,`name`,`DeptID`,`UserName` FROM `tbl_deptadmins` WHERE `UserName`='$uname' AND `Password`='$pass'";
				$query_result=$con->query($login_query);
				$cnt = $query_result->num_rows;
				if(!$cnt)
				{ ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> Username or Password Incorrect, <strong> Please retry</strong>
					</div>
				<?php }
				else
				{
					$returned=$query_result->fetch_assoc();
					$_SESSION["dept_admin_uname"]=$returned["UserName"];
					$_SESSION["deptID"]=$returned["DeptID"];
					$_SESSION["aName"]=$returned["name"];
          			$_SESSION["adminID"]=$returned["AdminID"];
					setcookie("user","depttAdmin",time()+(86400*15),"/");
					header('Location:dDashboard.php');
                    // echo '<script type="text/javascript">window.location.replace("homeDashboard.php");</script>';
				}
			}
		}
		$con->close();
	}
?>
		<ul id="login-signup" class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" href="#" id="login-tab" role="tab" data-toggle="tab" aria-controls="login" aria-expanded="true"><h6><i class="fa fa-sign-in" aria-hidden="true"></i> Login</h6></a>
			</li>
		</ul>

<!-- Content Panel -->
			<div id="login-signup-content" class="tab-content">
				<div role="tabpanel" class="tab-pane fade show active" id="login" aria-labelledby="login-tab">
					<form id="loginForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<div class="form-group">
							<label class="col-form-label" for="username">Enter Username</label>
							<input type="text" class="form-control" id="uid" name="username" value="" placeholder="Username">
						</div>

						<div class="form-group">
							<label class="col-form-label" for="pwd">Enter Password</label>
							<input type="password" class="form-control" id="pwd" name="password" value="" placeholder="Password">
						</div>
						<div id="loginAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
							<button id="alertClose" type="button" class="close" data-dismiss="alert" aria-label="Close">
  						 	 <span aria-hidden="true">&times;</span>
  						 	 </button>Please Login First
						</div>
						<div class="form-group">
						<div class="text-center">
							<button type="submit" class="btn btn-primary" name="loginSubmit"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
							<button type="reset" class="btn btn-danger ml-md-5"><i class="fa fa-remove" aria-hidden="true"></i> Cancel</button>
						</div>
						</div>
					</form>
				</div>
			</div>
<!-- dont delete below two divs -->
	</div>
</div>
<footer class="container-fluid py-2" style="background-color: #dadada;">
	<div class="text-center">
		<div class="my-0"><i class="fa fa-code" aria-hidden="true"></i> with <i class="fa fa-heart" aria-hidden="true"></i> by 
		<a style="text-decoration: none;" href="https://facebook.com/erfaanhussain6"><strong style="color:#292b2c;">ErFaan</strong></a> &amp; <a style="text-decoration: none;" href="https://facebook.com/superstudomi"><strong style="color:#292b2c;">Umar</strong></a> 
		</div>
		<small class="my-0">Copyright &copy; DOCS - IUST 2017 </small>
	</div>
</footer>
</body>
</html>
