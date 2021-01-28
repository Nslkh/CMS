<?php
require_once ("includes/DB.php");
require_once ("includes/Functions.php");
require_once ("includes/Sessions.php");
$SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); 

// FETCHING EXISTING ADMIN DATA START
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while($DataRows = $stmt->fetch()) {
	$ExistingName = $DataRows['aname'];
	$ExistingUsername = $DataRows['username'];
	$ExistingHeadline = $DataRows['aheadline'];
	$ExistingBio = $DataRows['abio'];
	$ExistingImage = $DataRows['aimage'];
}
// FETCHING EXISTING ADMIN DATA END

if(isset($_POST["Submit"])) {
	$AdminName = $_POST["Name"];
	$AdminHeadline = $_POST['Headline'];
	$AdminBio = $_POST['Bio'];
	$Image = $_FILES["Image"]["name"];
	$Target = "Images/".basename($_FILES["Image"]["name"]);
	
	if(strlen($AdminHeadline)>30) {
		$_SESSION["ErrorMsg"] = "Headline should be less than 30 characters";
		Redirect_to("MyProfile.php");
	}
	elseif(strlen($AdminBio)>500) {
		$_SESSION["ErrorMsg"] = "Bio should be less than 500 characters";
			Redirect_to("MyProfile.php");
	}else{
	//Query to Update Admin in DB when all is fine
		global $ConnectingDB;
		if(!empty($_FILES["Image"]["name"])){
			$sql = "UPDATE admins 
				SET aname='$AdminName', aheadline='$AdminHeadline', abio='$AdminBio', aimage='$Image'
				WHERE id='$AdminId'";
			} else {
			$sql = "UPDATE admins 
				SET aname='$AdminName', aheadline='$AdminHeadline', abio='$AdminBio'
				WHERE id='$AdminId'";
			}
		$Execute = $ConnectingDB->query($sql);	
		move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
		if($Execute){
			$_SESSION["SuccessMsg"] = "Details Updated Successfully";
			Redirect_to("MyProfile.php");
		}else{
			$_SESSION['ErrorMsg'] = "Something went wrong. Try again !";
			Redirect_to("MyProfile.php");
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
		<title>My Profile</title>
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
					<div class="col-md-30">
						<h1> <i class="fas fa-user mr-2 text-success" style="color: #27aae1;"></i>@<?php 	echo $ExistingUsername; ?></h1>
						<small>	<?php  echo $ExistingHeadline;?></small>	
					</div>
				</div>
			</div>
		</header>
		<!-- MAIN AREA -->
		<section class="container py-2 mb-4">
			<div class="row">
				<!-- LEFT AREA -->
				<div class="col-md-3">
					<div class="card">
						<div class="card-header bg-dark text-light">
							<h3><?php echo  $ExistingName; ?></h3>
						</div>
						<div class="card-body">
							<img src="images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">	
							<div class="">
							<?php echo $ExistingBio; ?>
							</div>
						</div>
					</div>
				</div>
				<!-- RIGHT AREA -->
				<div class="col-md-9" style="min-height: 400px;">
					<?php echo ErrorMsg();
					echo SuccessMsg(); ?>
					<form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
						<div class="card bg-dark text-light ">
							<div class="card-header bg-secondary text-light">
								<h4>Edit Profile</h4>
							</div>
							<div class="card-body ">
								<div class="form-group">
									<input class="form-control" type="text" name="Name" id="title" value="" placeholder="Your Name">
								</div>


								<div class="form-group">
									<input class="form-control" type="text" name="Headline" id="title"value="" placeholder="Headline" >
									<small class="text-muted">Add a professional headline like, 'Engineer' at XYZ or 'Architect' </small>
									<span class="text-danger">Not more than 30 characters</span>
								</div>

								<div class="form-group">
									<textarea  placeholder="Bio" class="form-control" name="Bio" id="Post" cols="30" rows="10"></textarea>
								</div>

								<div class="form-group mb-1">
									<div class="custom-file">
										<input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
										<label for="imageSelect" class="custom-file-label">Select Image</label>
									</div>
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
						<p class="lead text-center">Made By | Narzullo Salakhidinov.| <span id="year"></span> &copy; All right reserved </p>
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