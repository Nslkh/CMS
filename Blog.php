<?php
require_once ("includes/DB.php");
require_once ("includes/Functions.php");
require_once ("includes/Sessions.php");

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title>Blog Page</title>
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
							<a href="Blog.php" class="nav-link">Home </a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">About Us</a>
						</li>
						
						<li class="nav-item">
							<a href="Blog.php" class="nav-link">Blog</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">Contact Us</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">Features</a>
						</li>
					</ul>
					<ul class="navbar-nav ml-auto">
						<form class="form-inline d-none d-sm-block" action="Blog.php" >
							<div class="form-group">
								<input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
								<button  class="btn btn-primary" name="SearchButton">Go</button>
							</div>
						</form>
					</ul>
				</div>
			</div>
		</nav>
		<div style="height:10px; background:#27aae1;"></div>
		<!-- NAVBAR END -->
		<!-- HEADER -->
		<div class="container">
			<div class="row my-4">
				<!-- MAIN AREA START -->
				<div class="col-sm-8" >
					<h1>The Complet Responsive CMS Blog</h1>
					
					<?php  
					global $ConnectingDB;
					// SQL QUERY WHEN SEARCH BUTTON IS ACTIVE
					if(isset($_GET["SearchButton"])){
						$Search = $_GET["Search"];
						$sql = "SELECT * FROM post
						WHERE datetime LIKE :search
						OR category LIKE :search
						OR post LIKE :search";
						$stmt = $ConnectingDB->prepare($sql);
						$stmt-> bindValue(':search','%' .$Search. '%');
						$stmt->execute();
					} // QUERY WHEN PAGINATION IS ACTIVE 
					elseif(isset($_GET["page"])){
						$Page = $_GET["page"];	
						if($Page == 0 || $Page<1){
						$ShowPostFrom = 0;
						}	else {

						$ShowPostFrom=($Page*5)-5;
						}
						$sql = "SELECT * FROM post ORDER BY id desc LIMIT $ShowPostFrom, 5";
						$stmt= $ConnectingDB->query($sql);
					}
					// QUERY WHEN CATEGORY IS ACTIVE IN URL
					elseif (isset($_GET["category"])) {
						$Category = $_GET["category"];
						$sql = "SELECT * FROM post WHERE category='$Category' ORDER BY id desc";
						$stmt = $ConnectingDB->query($sql); 
					}
					// THE DEFAULT SQL QUERY
					else {
					$sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,3";
					$stmt = $ConnectingDB->query($sql);
					}
					while ($DataRows = $stmt->fetch()) {
						$PostId = $DataRows['id'];
						$DateTime = $DataRows['datetime'];
						$PostTitle = $DataRows['title'];
						$Category = $DataRows['category'];
						$Admin = $DataRows['author'];
						$Image = $DataRows['image'];
						$PostDescription = $DataRows['post'];
					?>
					<div class="card">
						<?php echo ErrorMsg();
						echo SuccessMsg(); ?>
						<img src="Uploads/<?php echo htmlentities($Image) ; ?>"  style="max-height: 450px;" class="img-fluid card-img-top" />
						<div class="card-body">
							<h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
							<small class="text-muted">Category: <span class="text-dark"> <?php echo htmlentities($Category);  ?> </span>  & Written by <span class="text-dark"> <a href="Profile.php?username=<?php echo htmlentities($Admin) ?>"><?php echo htmlentities($Admin); ?></a> On <span class="text-dark"> <?php echo htmlentities($DateTime); ?> </span></small>
							<span style="float: right; " class="badge badge-dark text-light">Comments
								<?php echo  ApproveCommentsAccordingToPost($PostId); ?>
							</span>
							<hr>
							<p class="card-text">
								<?php if (strlen($PostDescription>150)) {
								$PostDescription = substr($PostDescription,0,150)."...";}echo htmlspecialchars ($PostDescription); ?>
							<a href="FullPost.php?id=<?php echo $PostId?>" style="float: right">
								<span class="btn btn-info my-4" >Read More>></span>
							</a>
							</p>
						</div>
					</div>

					<?php } ?>
					<br>
					 <!-- Pagination  -->
					<nav>
						<ul class="pagination  pagination-lg">
								<!-- CREATING BACKWORD BUTTON START -->
								<?php 
									if (isset($Page)) {
									if ($Page>1) {
								?>
								<li class="page-item ">
									<a href="Blog.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
								</li>	
								<?php } } ?>	
							 <!-- CREATING BACKWORD BUTTON END -->
							<?php 
							global $ConnectingDB;
							$sql = "SELECT COUNT(*) FROM post";
							$stmt  = $ConnectingDB->query($sql);
							$RowPagination = $stmt->fetch();
							$TotalPosts=array_shift($RowPagination);
							// echo $TotalPosts."<br>";
							$PostPagination=$TotalPosts/5;
							$PostPagination=ceil($PostPagination);
							// 
							// echo $PostPagination;
							for ($i=1; $i <=$PostPagination ; $i++) { 
								if(isset($Page)) {
									if ($i == $Page) { 	?>
							<li class="page-item active">
								<a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
							</li>
							<?php 
								}else {
								?>	<li class="page-item ">
											<a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
										</li>
							<?php }

						 	}  }  ?>

							 <!-- CREATING FORWARD BUTTON START -->
								<?php 
									if (isset($Page)	&&!empty($Page)) {
									if ($Page+1<=$PostPagination) {
								?>
								<li class="page-item ">
									<a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
								</li>	
								<?php } } ?>	
							 <!-- CREATING FORWARD BUTTON END -->
						</ul>
					</nav>
				</div>
				<!-- MAIN AREA END -->
				<!-- SIDE AREA START -->
				<div class="col-sm-4">
				<div class="card mt-4">
					<div class="card-body">
						<img src="images/startblog.png" class="d-block img-fluid mb-3" alt="">
						<div class="text-center">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, error, ut saepe fugit quos assumenda ex magnam! Quaerat praesentium voluptate dolor, ex labore odit veritatis, officiis commodi cum necessitatibus vitae.
						</div>
						<br>
						<div class="card">
            <div class="card-header bg-dark text-light">
              <h2 class="lead">Sign Up !</h2>
            </div>
            <div class="card-body">
              <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">Join the Forum</button>
              <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="" placeholder="Enter your email"value="">
                <div class="input-group-append">
                  <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
                </div>
              </div>
            </div>
          </div>
					</div>
				</div>
				<br>
				<div class="card">
					<div class="card-header bg-primary text-light">
						<h2 class="lead">Categories</h2>
					</div>
						<div class="card-body">
							<?php
							global $ConnectingDB;
							$sql = "SELECT * FROM category ORDER BY id desc";
							$stmt = $ConnectingDB->query($sql);
							while($DataRows = $stmt->fetch()) {
								$CategoryId = $DataRows["id"];
								$CategoryName = $DataRows["title"];
							?>
							<a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?></span></a><br>
						<?php } ?>
						</div>
					</div>
					<br>
					<div class="card">
						<div class="card-header bg-info text-white">
							<h2 class="lead">Recent Posts</h2>
						</div>
						<div class="card-body">
							<?php 
              global $ConnectingDB;
              $sql = "SELECT *FROM post ORDER BY id desc LIMIT 0,5";
              $stmt = $ConnectingDB->query($sql);
              while ($DataRows=$stmt->fetch()) {
              	$Id = $DataRows['id']; 
              	$Title = $DataRows['title']; 
              	$DateTime = $DataRows['datetime']; 
              	$Image = $DataRows['image']; 
							?>
							<div class="media">
								<img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="100" height="104" alt="">
								<div class="media-body ml-2">
									<a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank"> <h6 class="lead"><?php echo htmlentities($Title);  ?></h6></a>
									<p class="small"><?php echo htmlentities($DateTime); ?></p>
								</div>
							</div>
							<hr>
						<?php } ?>
						</div>
					</div>
				</div>
				<!-- SIDE AREA END -->
				
			</div>
		</div>
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