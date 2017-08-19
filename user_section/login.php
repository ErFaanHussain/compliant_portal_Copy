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
				$login_query="SELECT `studentID`,`studentName`,`username`,`password` FROM tbl_students WHERE `username`='$uname' AND `password`='$pass'";
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
                    $_SESSION["studentUname"]=$returned["username"];
                    $_SESSION["studentName"]=$returned["studentName"];
                    $_SESSION["studentID"]=$returned["studentID"];
                    setcookie("user",$returned["username"],time()+(86400*15),"/");
                    echo '<script type="text/javascript">window.location.replace("studentDashboard.php");</script>';
				}
			}
		}
	}
if(isset($_POST["signUpSubmit"]))
{
	if(isset($_POST["name"]) && isset($_POST["regNumber"]) && isset($_POST["rollNo"]) && isset($_POST["mobile"])&& isset($_POST["email"]) && isset($_POST["depttID"]) && isset($_POST["courseID"]) && isset($_POST["username"]) && isset($_POST["password"]))
	{
		if(empty($_POST["name"]) || empty($_POST["regNumber"]) || empty($_POST["rollNo"]) || empty($_POST["mobile"]) || empty($_POST["email"]) || empty($_POST["depttID"]) || empty($_POST["courseID"]) || empty($_POST["username"]) || empty($_POST["password"]))
		{ ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> Please Enter all the details
					</div>
		<?php }
		else
		{
			$name=$_POST["name"];
			$regNo=$_POST["regNumber"];
			$rollNo=$_POST["rollNo"];
			$mobile=$_POST["mobile"];
			$email=$_POST["email"];
			$depttID=$_POST["depttID"];
			$courseID=$_POST["courseID"];
			$username=$_POST["username"];
			$password=$_POST["password"];
			$search_query="SELECT `studentRegNo`,`studentRollNo` FROM `tbl_students` WHERE `studentRegNo`='$regNo' OR `studentRollNo`='$rollNo' OR `username`='$username'";
			$search_result=$con->query($search_query);
			if($search_result->num_rows)
			{ ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> User Already Exists
					</div>
			<?php }
			else{
			$insert_query = "INSERT INTO `tbl_students`(`studentRegNo`,`studentRollNo`,`studentName`,`studentCourse`,`studentDeptt`,`studentEmail`,`studentMobile`,`username`,`password`) VALUES('$regNo','$rollNo','$name',$courseID,$depttID,'$email','$mobile','$username','$password')";
			$query_result = $con->query($insert_query);
			if($con->affected_rows)
			{ ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Success!</strong> You Successfully Signed Up, Please Login!
					</div>
			<?php }
			else{ ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> Something went wrong, Please Contact Administrator
					</div>
				<?php }
			}
		}
	}
	$con->close();
}
?>
		<ul id="login-signup" class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" href="#login" id="login-tab" role="tab" data-toggle="tab" aria-controls="login" aria-expanded="true"><h6><i class="fa fa-sign-in" aria-hidden="true"></i> Login</h6></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="#signup" role="tab" id="signup-tab" data-toggle="tab" aria-controls="signup"><h6><i class="fa fa-user-plus" aria-hidden="true"></i> Sign Up</h6></a>
			</li>
		</ul>
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
  						 	 </button>
 							 Please Login First
						</div>
						<div class="form-group">
						<div class="text-center">
							<button type="submit" class="btn btn-primary" name="loginSubmit"><i class="fa fa-sign-in" aria-hidden="true"></i>  Login</button>
							<button type="reset" class="btn btn-danger ml-md-5" id="resetFormLogin"><i class="fa fa-remove" aria-hidden="true"></i> Cancel</button>
						</div>
						</div>
					</form>

				</div>

				<div role="tabpanel" class="tab-pane fade" id="signup" aria-labelledby="signup-tab">
					<form id="signUpForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<div class="form-group">
							<label class="col-form-label" for="name">Enter Your Name</label>
							<input type="text" class="form-control" id="name" name="name" value="" placeholder="Name">
							<small id="nameHelp" class="form-text text-muted">Your name should be according to university records</small>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="regNumber">Enter Your Registration No.</label>
							<input type="text" class="form-control" id="regNo" name="regNumber" value="" placeholder="e.g. IUST/MCA/14/522">
						</div>
						<div class="form-group">
							<label class="col-form-label" for="rollNo">Enter Your Roll No.</label>
							<input type="text" class="form-control" id="rollNo" name="rollNo" value="" placeholder="e.g. MCA-14-48">
						</div>
						<div class="form-group">
							<label class="col-form-label" for="mobile">Enter Your Mobile Number</label>
							<input type="text" class="form-control" id="mobile" name="mobile" value="" placeholder="Mobile Number" maxlength="10">
						</div>
						<div class="form-group">
							<label class="col-form-label" for="email">Enter Your Email</label>
							<input type="text" class="form-control" id="email" name="email" value="" placeholder="you@example.com">
						</div>
						<div class="form-group">
    						<label for="depttSelect">Select Your Department</label>
    						<select class="form-control" id="depttSelect" name="depttID" onchange="fillCourse();">
    						<option selected value="">--Select Department--</option>
						<?php
							$fetch_query="SELECT DeptID,DeptName FROM tbl_departments";
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
    						<label for="courseSelect">Select Your Program</label>
    						<select class="form-control" id="courseSelect" name="courseID">
    							<option selected value="">--Select Course--</option>
    						</select>
    						<small id="courseStatus"></small>
  						</div>
						<div class="form-group">
							<label class="col-form-label" for="uid">Enter Username</label>
							<input type="text" class="form-control" id="uid1" name="username" value="" placeholder="Create a Username">
							<small id="nameHelp" class="form-text text-muted">You will use it to log into the portal</small>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="pwd">Enter Password</label>
							<input type="password" class="form-control" id="pwd1" name="password" value="" placeholder="Create Password">
							<small id="nameHelp" class="form-text text-muted">Password should be alphanumeric</small>
						</div>

						<div class="form-group">
						<div class="text-center">
							<button type="submit" class="btn btn-primary" name="signUpSubmit"><i class="fa fa-user-plus" aria-hidden="true"></i> Sign Up</button>
							<button type="reset" class="btn btn-danger ml-md-5" id="resetFormSignUp"><i class="fa fa-remove" aria-hidden="true"></i> Cancel</button>
						</div>
						</div>
					</form>
				</div>

			</div>
	</div>
</div>
