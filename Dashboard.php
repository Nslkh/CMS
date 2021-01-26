<?php
require_once ("includes/DB.php");
require_once ("includes/Functions.php");
require_once ("includes/Sessions.php");

$SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
// echo $SESSION["TrackingURL"];
Confirm_Login(); 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title>Posts</title>
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
						<li class="nav-item"  ><a href="logout.php" class="nav-link"> <i class="fas fa-user-times text-danger"></i> Logout</a>
					</li>
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
					<h1> <i class="fas fa-cog" style="color: #27aae1;"></i>Dashboard</h1>
				</div>
				<div class="col-lg-3 mb-2">
					<a href="AddNewPost.php" class="btn btn-primary btn-block">
						<i class="fas fa-edit"></i>Add New Post
					</a>
				</div>
				<div class="col-lg-3 mb-2">
					<a href="Categories.php" class="btn btn-info btn-block">
						<i class="fas fa-folder-plus"></i>Add New Categoty
					</a>
				</div>
				<div class="col-lg-3 mb-2">
					<a href="Admins.php" class="btn btn-warning btn-block">
						<i class="fas fa-user-plus"></i>Add New Admin
					</a>
				</div>
				<div class="col-lg-3 mb-2">
					<a href="Comments.php" class="btn btn-success btn-block">
						<i class="fas fa-check"></i>Approve Comments
					</a>
				</div>
			</div>
		</div>
	</header>
	<br>
	<!-- HEADER END -->
	<!-- MAIN AREA -->
	<section class="container py-2 mb-4">
		<div class="row">
			<div class="col-lg-12">
				<?php
					echo ErrorMsg();
					echo SuccessMsg(); 
				?>		
				<!-- LEFT SIDE AREA START  -->
				<div class="col-lg-2 d-none d-md-block">
					<div class="card text-center bg-dark text-white mb-3">
						<div class="card-body">
							<h1 class="lead">Posts</h1>
							<h4 class="display-5">
								<i class="fab fa-readme"></i>
								100
							</h4>
						</div>
					</div>

					<div class="card text-center bg-dark text-white mb-3">
						<div class="card-body">
							<h1 class="lead">Categories</h1>
							<h4 class="display-5">
								<i class="fas fa-folder"></i>
								100
							</h4>
						</div>
					</div>

					<div class="card text-center bg-dark text-white mb-3">
						<div class="card-body">
							<h1 class="lead">Admins</h1>
							<h4 class="display-5">
								<i class="fas fa-users"></i>
								100
							</h4>
						</div>
					</div>

					<div class="card text-center bg-dark text-white mb-3">
						<div class="card-body">
							<h1 class="lead">Comments</h1>
							<h4 class="display-5">
								<i class="fas fa-comments"></i>
								100
							</h4>
						</div>
					</div>


				</div>
				<!-- LEFT SIDE AREA END  -->
				
			</div>
		</div>
	</section>
	<!-- MAIN AREA END -->
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