<style type="text/css">
html{
	font-size: 15;
	font-family: helvetica;
}
	.nav-bar{
		list-style-type:none;
		padding:0;
		margin:0;
		overflow:hidden;
		margin-top: 10px;
		margin-left: 50px;
		margin-right: 50px;
		/*background-color: #f1f1f1;*/
		background-color: rgb(106,102,110);
	}	
	li{
		float:left;
		
	}
	li a{
		display: block;
		color:#fff;
		background-color: rgb(106,102,110);
		padding:16px 20px;
		text-decoration: none;
		text-align: center;
		/*border-bottom: 0.5px solid #555;*/
		border-right: 1px solid #bbb;
	}
	li a:active{
		background-color: #3a3;
		color:white;

	}
	li a:hover{
		background-color: #3a3;
		color:white;
		font-size: 15px;
	}
	
</style>
<ul class="nav-bar">
<li><a href="depttCreation.php">Create Department</a></li>
<li><a href="createDepttLogin.php">Create Department Login</a></li>
<li><a href="admin_dashboard.php">Compliant Dashboard</a></li>
<li><a href="logout.php">Logout</a></li>	
</ul>