<!DOCTYPE html>
<html>
<head>
	<title>Super Admin:Login-Compliant Portal</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<div class="mainScr">
<?php 
if(isset($_POST["Login"]))
	{
		if(isset($_POST["username"]) && isset($_POST["password"]))
		{
			$uname=$_POST["username"];
			$pass=$_POST["password"];
			if (empty($uname) || empty($pass)) 
			{
				echo '<script>alert("Please Enter Username and Password");</script>';
			}
			else 
			{
				$login_query="SELECT ID,UserName,Password FROM tbl_superadmin WHERE UserName='$uname' AND 
				Password='$pass'";
				$query_result=$con->query($login_query);
				$cnt = $query_result->num_rows;
				if(!$cnt)
				{
					echo '<script>alert("Username or Password Incorrect");</script>';
				}
				else
				{
					$returned=$query_result->fetch_assoc();
					$_SESSION["admin_uname"]=$returned["UserName"];
					$_SESSION["adminID"]=$returned["ID"];
                    setcookie("user","superAdmin",time()+(86400*15),"/");
				}
			}
		}
	}
?>
	<form method="POST" action="<?php echo $current_page ?>">
	<p class="label">Username:<input type="text" class="textbox" name="username" value="" placeholder="Your Username?" /></p>

	<p class="label">Password: <input type="password" class="textbox" name="password" value="" placeholder="Your Password?" /></p>
	</br> <input type="submit" class="button" name="Login" value="Login" />
	<input type="reset"  class="button" name="reset" value="Cancel" />
	</form>
</div>
</body>
</html>