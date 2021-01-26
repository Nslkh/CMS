<?php
require_once ("includes/DB.php");
require_once ("includes/Functions.php");
require_once ("includes/Sessions.php");
$SearchQueryParameters = $_GET["id"];

if(isset($_POST["Submit"])) {
	$Name = $_POST["CommenterName"];
	$Email = $_POST["CommenterEmail"];
	$Comment = $_POST["CommenterThoughts"];
	date_default_timezone_set("Asia/Tashkent");
	$CurrentTime = time();	
	$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

	if(empty($Name) || empty($Email) || empty($Comment)) {
		$_SESSION["ErrorMsg"] = "All fields must be filled out";
		Redirect_to("FullPost.php?id=$SearchQueryParameters;");
	}elseif(strlen($Comment)>500) {
		$_SESSION["ErrorMsg"] = "Comment length should be less than 500 characters";
		Redirect_to("FullPost.php?id=$SearchQueryParameters;");
	}
	else{
		//Query to insert COMMENT in DB when all is fine
		global $ConnectingDB;
		$sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
		$sql .="VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:PostIdFromURL)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':dateTime',$DateTime);
		$stmt->bindValue(':name',$Name);
		$stmt->bindValue(':email',$Email);
		$stmt->bindValue(':comment',$Comment);
		$stmt->bindValue(':PostIdFromURL',$SearchQueryParameters);
		$Execute=$stmt->execute();
	
		if($Execute){
			$_SESSION["SuccessMsg"] = "Comment Submitted Successfully";
		Redirect_to("FullPost.php?id={$SearchQueryParameters};");
		}else{
			$_SESSION['ErrorMsg'] = "Something went wrong. Try again !";
		Redirect_to("FullPost.php?id={$SearchQueryParameters};");
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
						echo SuccessMsg();
						echo ErrorMsg();
					?>
					<?php
					global $ConnectingDB;
					if(isset($_GET["SearchButton"])){
						$Search = $_GET["Search"];
						$sql = "SELECT * FROM post
						WHERE datetime LIKE :search
						OR category LIKE :search
						OR post LIKE :search";
						$stmt = $ConnectingDB->prepare($sql);
						$stmt-> bindValue(':search','%' .$Search. '%');
						$stmt->execute();
					}
					// THE DEFAULT SQL QUERY
					else {
					$PostIdFromURL = $_GET["id"];
					if(!isset($PostIdFromURL)) {
						$_SESSION["ErrorMsg"]="Bad Request !";
						Redirect_to("Blog.php"); 
					}
					$sql = "SELECT * FROM post WHERE id='$PostIdFromURL'";
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
						<img src="Uploads/<?php echo htmlentities($Image) ; ?>"  style="max-height: 450px;" class="img-fluid card-img-top" />
						<div class="card-body">
							<h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
							<small class="text-muted">Written by <?php echo htmlentities($Admin); ?> On <?php echo htmlentities($DateTime); ?></small>
							<hr>
							<p class="card-text ">
								<?php 
								echo htmlspecialchars ($PostDescription); ?>
							</p>
						</div>
					</div>
					<?php } ?>
					<br>  	
					<!-- COMMENT PART START -->

					<!-- FETCHING EXISTING COMMENT -->
				 <span class="FieldInfo" >Comments</span>
				 <br><br>
				 

					<?php 
					global $ConnectingDB;
					$sql = "SELECT * FROM comments
					WHERE post_id='$SearchQueryParameters' ";
					$stmt = $ConnectingDB->query($sql);
					while ($DataRows = $stmt->fetch()) {
						$CommentDate = $DataRows['datetime'];
						$CommenterName = $DataRows['name'];
						$CommentContent = $DataRows['comment'];

					?>
					<div >
						<div class="media CommentBlock">
							<img class="d-block imf-fluid align-self-start" src="images/comment.png" alt="">
							<div class="media-body ml-2">
								<h6 class="lead"><?php echo $CommenterName; ?></h6>
								<p class="small"><?php echo $CommentDate; ?></p>
								<p><?php echo $CommentContent; ?></p>
							</div>
						</div>
					</div>
					<hr>
				<?php } ?>


					<!-- FETCHING EXISTING COMMENT END -->
					<div class="">
						<form class="" action="FullPost.php?id=<?php echo $SearchQueryParameters; ?>" method="post">
							<div class="card mb-3">
								<div class="card-header">
									<h5 class="FieldInfo">Share your thoughts about this post</h5>
								</div>
								<div class="card-body">
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="fas fa-user"></i>
												</span>
											</div>											
										<input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
										</div>
									</div>
										<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="fas fa-envelope"></i>
												</span>
											</div>											
										<input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
										</div>
									</div>
									<div class="form-group">
										<textarea name="CommenterThoughts" class="form-control" id="" cols="30" rows="4"></textarea>
									</div>
									<div class="">
										<button type="submit" name="Submit" class="btn btn-primary">Submit</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- COMMENT END -->

				<!-- MAIN AREA END -->

				<!-- SIDE AREA START -->
				<div class="col-sm-4" style="min-height: 40px;background: green;">
				</div>
				<!-- SIDE AREA END -->
				
			</div>
		</div
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