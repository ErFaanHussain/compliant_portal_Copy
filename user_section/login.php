<div class="container">
	<div class="col-sm-6 mx-auto mt-md-3" >	
<?php 
if(isset($_POST["loginSubmit"]))
	{
		if(isset($_POST["username"]) && isset($_POST["password"]))
		{
			$uname = $_POST["username"];
			$pass = $_POST["password"];
			if (empty($uname) || empty($pass)) 
			{
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> Please Enter Username and Password
					</div>';
			}
			else 
			{
				$login_query="SELECT `studentID`,`studentName`,`username`,`password` FROM tbl_students WHERE `username`='$uname' AND `password`='$pass'";
				$query_result=$con->query($login_query);
				$cnt = $query_result->num_rows;
				if(!$cnt)
				{
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> Username or Password Incorrect, <strong> Please retry</strong> 
					</div>';
				}
				else
				{
					$returned=$query_result->fetch_assoc();
                    $_SESSION["studentUname"]=$returned["username"];
                    $_SESSION["studentName"]=$returned["studentName"];
                    $_SESSION["studentID"]=$returned["studentID"];
                    setcookie("user",$returned["username"],time()+(86400*15),"/");
                    echo '<script type="text/javascript">window.location.replace("homeDashboard.php");</script>';
                    exit;
				}
			}
		}
	}
if(isset($_POST["signUpSubmit"]))
{
	if(isset($_POST["name"]) && isset($_POST["regNo"]) && isset($_POST["rollNo"]) && isset($_POST["mobile"])&& isset($_POST["email"]) && isset($_POST["depttID"]) && isset($_POST["courseID"]) && isset($_POST["username"]) && isset($_POST["password"]))
	{
		$name=$_POST["name"];
		$regNo=$_POST["regNo"];
		$rollNo=$_POST["rollNo"];
		$mobile=$_POST["mobile"];
		$email=$_POST["email"];
		$depttID=$_POST["depttID"];
		$courseID=$_POST["courseID"];
		$username=$_POST["username"];
		$password=$_POST["password"];
		if(empty($_POST["name"]) || empty($_POST["regNo"]) || empty($_POST["rollNo"]) || empty($_POST["mobile"]) || empty($_POST["email"]) || empty($_POST["depttID"]) || empty($_POST["courseID"]) || empty($_POST["username"]) || empty($_POST["password"]))
		{
			echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> Please Enter all the details
					</div>';	
		}
		else
		{
			$search_query="SELECT studentRegNo,studentRollNo FROM tbl_students WHERE `studentRegNo`='$regNo' OR `studentRollNo`='$rollNo' OR `username`='$username'";
			$search_result=$con->query($search_query);
			if($search_result->num_rows)
			{
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> User Already Exists
					</div>';
			}	
			else{
			$insert_query = "INSERT INTO tbl_students(studentRegNo,studentRollNo,studentName,studentCourse,studentDeptt,studentEmail,studentMobile,username,password) VALUES('$regNo','$rollNo','$name',$courseID,$depttID,'$email','$mobile','$username','$password')";
			$query_result = $con->query($insert_query);
			if($con->affected_rows)
			{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Success!</strong> You Successfully Signed Up, Please Login!
					</div>';
			}
			else{
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					  <span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Error!</strong> Something went wrong, Please Contact Administrator
					</div>';
				}
			}
		}
	}
}
?>
		<ul id="login-signup" class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" href="#login" id="login-tab" role="tab" data-toggle="tab" aria-controls="login" aria-expanded="true"><h6>Login</h6></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="#signup" role="tab" id="signup-tab" data-toggle="tab" aria-controls="signup"><h6>Sign Up</h6></a>
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
  						 	 </button>
 							 Please Login First
						</div>
						<div class="form-group">
						<div class="offset-md-3 col-md-9">
							<input type="submit" class="btn btn-primary" name="loginSubmit" value="Login">
							<button type="reset" class="btn btn-danger ml-md-5">Cancel</button>
						</div>
						</div>
					</form>
						
				</div>

				<div role="tabpanel" class="tab-pane fade" id="signup" aria-labelledby="signup-tab">
					<form id="signupForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<div class="form-group">
							<label class="col-form-label" for="name">Enter Your Name</label>
							<input type="text" class="form-control" id="name" name="name" value="" placeholder="Name">
							<small id="nameHelp" class="form-text text-muted">Your name should by according to university records</small>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="regNo">Enter Your Registration No.</label>
							<input type="text" class="form-control" id="regNo" name="regNo" value="" placeholder="e.g. IUST/MCA/14/522">
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
    						<select class="form-control" id="depttSelect" name="depttID">
    						<option selected value="null">--Select Department--</option>
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
    						<label for="courseSelect">Select Your Course</label>
    						<select class="form-control" id="courseSelect" name="courseID">
    						<option selected value="null">--Select Course--</option>
						<?php 
							$fetch_query="SELECT courseID,courseName FROM tbl_courses";
							$query_result=$con->query($fetch_query);
							$cnt = $query_result->num_rows;
							if($cnt)
								{
									while($returned=$query_result->fetch_assoc()){
										echo '<option value="'.$returned["courseID"].'">'.$returned["courseName"].'</option>';	
										}	
								}
						?>
							</select>
  						</div>
						<div class="form-group">
							<label class="col-form-label" for="uid">Enter Username</label>
							<input type="text" class="form-control" id="uid" name="username" value="" placeholder="UserName">
						</div>
						<div class="form-group">
							<label class="col-form-label" for="pwd">Enter Password</label>
							<input type="password" class="form-control" id="pwd" name="password" value="" placeholder="Password">
							<small id="nameHelp" class="form-text text-muted">Password should be alphanumeric</small>
						</div>

						<div class="form-group">
						<div class="offset-md-3 col-md-9">
							<button type="submit" class="btn btn-primary" name="signUpSubmit">Sign Up</button>
							<button type="reset" class="btn btn-danger ml-md-5">Cancel</button>
						</div>
						</div>
					</form>
				</div>

			</div>

	</div>	
</div>
