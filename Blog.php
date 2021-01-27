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
							<small class="text-muted">Category: <span class="text-dark"> <?php echo htmlentities($Category);  ?> </span>  & Written by <span class="text-dark"> <?php echo htmlentities($Admin); ?> On <span class="text-dark"> <?php echo htmlentities($DateTime); ?> </span></small>
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
						<ul class="pagination  pagination -lg">
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
						</ul>
					</nav>
				</div>
				<!-- MAIN AREA END -->
				<!-- SIDE AREA START -->
				<div class="col-sm-4" style="min-height: 40px;background: green;">
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