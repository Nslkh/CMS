<?php
require_once ("includes/DB.php");
require_once ("includes/Functions.php");
require_once ("includes/Sessions.php");
$SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); 



if(isset($_POST["Submit"])) {
	$UserName = $_POST["Username"];
	$Name = $_POST["Name"];
	$Password = $_POST["Password"];
	$ConfirmPassword = $_POST["ConfirmPassword"];
	$Admin = $_SESSION["UserName"] ;	
	date_default_timezone_set("Asia/Tashkent");
	$CurrentTime = time();
	$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
	
	if(empty($UserName) || empty($Password) || empty($ConfirmPassword)) {
		$_SESSION["ErrorMsg"] = "All fields must be filled out";
		Redirect_to("Admins.php");
	}elseif(strlen($Password)<4) {
		$_SESSION["ErrorMsg"] = "Password should be greater than 3 characters";
			Redirect_to("Admins.php");
	}elseif($Password !== $ConfirmPassword) {
		$_SESSION["ErrorMsg"] = "Password and ConfirmPassword should be match";
			Redirect_to("Admins.php");
	}elseif(CheckUserNameExistsOrNot($UserName)) {
		$_SESSION["ErrorMsg"] = "Username exists. Try Another One ";
			Redirect_to("Admins.php");
	}
	else{
		//Query to insert new admin in DB when all is fine
		global $ConnectingDB;
		$sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
		$sql .="VALUES(:dateTime,:userName,:password,:aName,:adminName)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue('dateTime',$DateTime);
		$stmt->bindValue(':userName',$UserName);
		$stmt->bindValue(':password',$Password);
		$stmt->bindValue(':aName',$Name);
		$stmt->bindValue(':adminName',$Admin);

		$Execute=$stmt->execute();
		if($Execute){
			$_SESSION["SuccessMsg"] = "New Admin with the name of $Name Added Successfully";
			Redirect_to("Admins.php");
		}else{
			$_SESSION['ErrorMsg'] = "Something went wrong. Try again !";
			Redirect_to("Admins.php");
		}
	}
} //Ending of submit Button If-Condition
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title>Admin Page</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	</head>
	<body>
		<!-- NAVBAR -->
		<div style="height:10px; background:#27aae1;"></div>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
				<a href="#" class="navbar-brand">Narzullo.co</a>
				<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS" >
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarcollapseCMS">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a href="MyProfile.php" class="nav-link"> <i class="fas fa-user text-success"></i> My Profile</a>
						</li>
						<li class="nav-item">
							<a href="Dashboard.php" class="nav-link">Dashboard</a>
						</li>
						<li class="nav-item">
							<a href="Posts.php" class="nav-link">Post</a>
						</li>
						<li class="nav-item">
							<a href="Categories.php" class="nav-link">Categories</a>
						</li>
						<li class="nav-item">
							<a href="Admins.php" class="nav-link">Manage Admin</a>
						</li>
						<li class="nav-item">
							<a href="Comments.php" class="nav-link">Comments</a>
						</li>
						<li class="nav-item">
							<a href="Blog.php?page=1" class="nav-link">Live Blog</a>
						</li>
					</ul>
					<ul class="navbar-nav ml-auto">
						<li class="nav-item"  ><a href="logout.php" class="nav-link"> <i class="fas fa-user-times text-danger"></i> Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div style="height:10px; background:#27aae1;"></div>
		<!-- NAVBAR END -->
		<!-- HEADER -->
		<header class="bg-dark text-white  py-3" >
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1> <i class="fas fa-user" style="color: #27aae1;"></i>Manage Admins</h1>
					</div>
				</div>
			</div>
		</header>
		<!-- MAIN AREA -->
		<section class="container py-2 mb-4">
			<div class="row">
				<div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
					<?php echo ErrorMsg();
					echo SuccessMsg(); ?>
					<form class="" action="Admins.php" method="post">
						<div class="card bg-secondary text-light mb-3">
							<div class="card-header">
								<h1>Add New Admin</h1>
							</div>
							<div class="card-body bg-dark">
								<div class="form-group">
									<label for="username"	><span class="FieldInfo">Username :</span></label>
									<input class="form-control" type="text" name="Username" id="title" value="">
								</div>
								<div class="form-group">
									<label for="username"	><span class="FieldInfo">Name :</span></label>
									<input class="form-control" type="text" name="Name" id="title"  value="">
									<small class="text-warning text-muted">Optional</small>
								</div>
								<div class="form-group">
									<label for="password"	><span class="FieldInfo">Password :</span></label>
									<input class="form-control" type="text" name="Password" id="title"  value="">
								</div>
								<div class="form-group">
									<label for="ConfirmPassword"	><span class="FieldInfo">Confirm Password :</span></label>
									<input class="form-control" type="text" name="ConfirmPassword" id="ConfirmPassword" value="">
								</div>
								<div class="row">
									<div class="col-lg-6 mb-2">
										<a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard </a>
									</div>
									<div class="col-lg-6 mb-2">
										<button type="Submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i>Publish</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
		<!-- MAIN AREA END-->
		<!-- HEADER END -->
		<!-- FOOTER -->
		<footer class="bg-dark text-white">
			<div class="container">
				<div class="row">
					<div class="col">
						<p class="lead text-center">Made By | Narzullo Salakhidinov. | <span id="year"></span> &copy; All right reserved </p>
					</div>
				</div>
			</div>
			<div style="height:10px; background:#27aae1;"></div>
		</footer>
		<!-- FOOTER END -->
		<!-- jQuery and Bootstrap Bundle (includes Popper) -->
		<script src="js/jquery-3.5.1.slim.min.js"></script>
		<script src="js/bootstrap.bundle.min.js" ></script>
		<script>
			$('#year').text(new Date().getFullYear());
		</script>
	</body>
</html>