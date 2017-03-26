<!DOCTYPE html>
<html>
<head>
	<title>Deptt Admin:Login-Compliant Portal</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<div class="login_form">
<header class="login_header">Department Login</header>
<?php 
include("includes/admin.core.inc.php");
include("includes/DBConnection.inc.php");
if(isset($_POST["Login"]))
	{
		if(isset($_POST["username"]) && isset($_POST["password"]))
		{
			$uname=$_POST["username"];
			$pass=$_POST["password"];
			if (empty($uname) || empty($pass)) 
			{
				echo '<p class="login_error"> Please Enter Username and Password</p>';
			}
			else 
			{
				$login_query="SELECT DeptID,UserName,Password FROM tbl_deptadmins WHERE UserName='$uname' AND 
				Password='$pass'";
				$query_result=$con->query($login_query);
				$cnt = $query_result->num_rows;
				if(!$cnt)
				{
					echo '<p class="login_error">Username or Password Incorrect</p>';
				}
				else
				{
					$returned=$query_result->fetch_assoc();
					$_SESSION["dept_admin_uname"]=$returned["UserName"];
					$_SESSION["deptID"]=$returned["DeptID"];
					// echo '<p>Welcome '.$_SESSION["dept_admin_uname"].'</p>';
                    setcookie("user","depttAdmin",time()+(86400*15),"/");
					header('Location:depttDashboard.php');
					// echo '<a href="logout.php" class="logout_button">Logout</a>';
				}
			}
		}
	}
?>
	<form method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
	<p class="label">Username: <input type="text" class="textbox" name="username" value="" placeholder="Your Username?" /></p>

	<p class="label">Password: <input type="password" class="textbox" name="password" value="" placeholder="Your Password?" /></p>
	</br> <input type="submit" class="button" name="Login" value="Login" />
	<input type="reset" class="button" name="reset" value="Cancel" />
	</form>
</div>
</body>
</html>