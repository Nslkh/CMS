<?php
require_once ("includes/DB.php");
require_once ("includes/Functions.php");
require_once ("includes/Sessions.php");
$SearchQueryParameters = $_GET['id'];
if(isset($_POST["Submit"])) {
		//Query to Delete  Post in DB when all is fine
		global $ConnectingDB;
		$sql = "DELETE FROM post WHERE id='$SearchQueryParameters'";
		$Execute = $ConnectingDB->query($sql);	
		// var_dump($Execute);
		if($Execute){
			$_SESSION["SuccessMsg"] = "Post DELETED  Successfully";
			Redirect_to("Posts.php");
		}else{
			$_SESSION['ErrorMsg'] = "Something went wrong. Try again !";
			Redirect_to("Posts.php");
		}
} //Ending of submit Button If-Condition
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title>Delete Post</title>
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
						<h1> <i class="fas fa-edit" style="color: #27aae1;"></i>Delete Post</h1>
					</div>
				</div>
			</div>
		</header>
		<!-- MAIN  AREA -->
		<section class="container py-2 mb-4">
			<div class="row">
				<div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
					<?php echo ErrorMsg();
						echo SuccessMsg(); 
						 // FETCHING EXISTING CONTENT ACCORDING TO OUR  
						global $ConnectingDB;
						$sql = "SELECT *FROM post WHERE id='$SearchQueryParameters'";
						$stmt = $ConnectingDB->query($sql);
						while ($DataRows=$stmt->fetch()) {
							$TitleToBeUpdated = $DataRows['title'];
							$CategoryToBeUpdated = $DataRows['category'];
							$ImageToBeUpdated = $DataRows['image'];
							$PostToBeUpdated = $DataRows['post'];
						}
						?>
					<form class="" action="DeletePost.php?id=<?php 	echo $SearchQueryParameters; ?>" method="post" enctype="multipart/form-data">
						<div class="card bg-secondary text-light mb-3">
							<div class="card-body bg-dark">
								<div class="form-group">
									<label for="title"	><span class="FieldInfo">Post Title:</span></label>
									<input disabled class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="<?php 	echo $TitleToBeUpdated; ?>">
								</div>
								<div class="form-group">
									<span class="FieldInfo">Existing Category:</span>
									<?php 	echo $CategoryToBeUpdated; ?>
									<br>
								</div>
								<div class="form-group">
									<span class="FieldInfo">Existing Image:</span>
									<img class="mb-1" src="Uploads/<?php 	echo $ImageToBeUpdated; ?>" width="170px"; height="70px"; >
									<br>
								<div class="form-group">
									<label for="Post"><span class="FieldInfo">Post:</span></label>
									<textarea disabled class="form-control" name="PostDescription" id="Post" cols="30" rows="10">
									<?php 	echo $PostToBeUpdated; ?>
									</textarea>
								</div>
								<div class="row">
									<div class="col-lg-6 mb-2">
										<a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard </a>
									</div>
									<div class="col-lg-6 mb-2">
										<button type="Submit" name="Submit" class="btn btn-danger btn-block"><i class="fas fa-trash"></i>Delete </button>
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