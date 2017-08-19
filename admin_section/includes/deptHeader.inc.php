<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="fonts/css/font-awesome.min.css">
<link rel="stylesheet" href="css/customCSS.css">

 <!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="js/jquery-3.2.1.slim.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/tether-1.4.0.min.js"></script>
<script src="css/bootstrap/js/bootstrap.min.js"></script>

<script src="js/validator/dist/jquery.validate.js"></script>
<script src="js/validator/dist/additional-methods.js"></script>
<script type="text/javascript" src="js/depttProfileJS.js"></script>
</head>
<body>
<div class="header px-0 mr-0">
  <div class="container-fluid px-0">
    <div class="row px-0 mx-0">
      <div class="col-md-2">
        <a href="http://iustlive.com"><img src="images/logo2.jpg" class="img-fluid" alt="IUST Logo"></a>
      </div>
      <div class="col-md-6 col-sm-6 col-lg-6 hidden-md-down">
        <div class="nav-brand titleC">
        <h1 class="titleCC">Feedback Portal</h1>
      </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid px-0">
<nav class="navbar naVcustom navbar-toggleable-md navbar-inverse bg-primary">
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="navbar-brand hidden-md-up">Feedback Portal</div>
<!-- Links -->
<div class="collapse navbar-collapse" id="nav-content">
  <ul class="navbar-nav mr-auto" >
    <li class="nav-item" id="dashboardLink">
      <a class="nav-link"  href="dDashboard.php">Dashboard</a>
    </li>
    <li class="nav-item" id="forumLink">
      <a class="nav-link"  href="discussionForum.php">Forum</a>
    </li>
    <li class="nav-item" id="studentsLink">
      <a class="nav-link"  href="aStudents.php">Students</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="dLogout.php">Logout</a>
    </li>
    <li>
      <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Settings</a>
        <div class="dropdown-menu">
          <button type="button" class="dropdown-item" data-toggle="modal" data-target="#settingModal"><i class="fa fa-user" aria-hidden="true"></i> Profile</button>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="dLogout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
        </div>
      </div>
    </li>
  </ul>


    <form class="form-inline">
      <input class="form-control mr-sm-2" type="text" placeholder="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
      </form>
</div>
</nav>
</div>
<!-- Deptt Admin Profile Update Settings -->
<?php
  $sql7 = "SELECT `name`,`UserName`,`email` FROM `tbl_deptadmins` WHERE `AdminID`=".$_SESSION["adminID"];
  $res7 = $con->query($sql7);
  if($res7->num_rows){
    $adDetails = $res7->fetch_assoc(); ?>
<!-- Setting Modal -->
<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="settingModalLabel">Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateForm">
          <input type="hidden" name="aId" id="aId" value="<?php echo $_SESSION["adminID"];?>">
            <div class="form-group row">
            <label for="name" class="col-3 col-form-label">Name</label>
              <div class="col-9" id="nameCont">
                <input class="form-control" type="text" name="name1" value="<?php echo $adDetails["name"];?>" id="name" disabled>
              </div>
            </div>
            <div class="form-group row">
            <label for="username" class="col-3 col-form-label">Email</label>
              <div class="col-9" id="emailCont">
                <input class="form-control" type="email" name="email1" value="<?php echo $adDetails["email"];?>" id="email" disabled>
              </div>
            </div>
            <div class="form-group row">
            <label for="username" class="col-3 col-form-label">Username</label>
              <div class="col-9" id="usernameCont">
                <input class="form-control" type="text" name="uname" value="<?php echo $adDetails["UserName"];?>" id="username" disabled>
              </div>
            </div>
            <div class="form-group row">
            <label for="username" class="col-3 col-form-label">Password</label>
              <div class="col-9" id="passwordCont">
                <input class="form-control" type="password" name="pwd1" value="dummypass" id="password" disabled>
              </div>
                <label class="col-8 offset-3 custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="passCheck" disabled>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Change Password</span>
                </label>
            </div>
        </form>
        <strong><span id="pChangeResult"></span></strong>
      </div>
      <div class="modal-footer pr-2 pr-sm-3">
        <button type="button" class="btn btn-outline-primary" id="updateBtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
        <button type="button" class="btn btn-outline-success" id="saveBtn" disabled><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
        <button type="button" class="btn btn-outline-danger" id="cnclBtn" data-dismiss="modal"><i class="fa fa-remove" aria-hidden="true"></i> Close</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
