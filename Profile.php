<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title>Profile</title>
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
		<header class="bg-dark text-white  py-3" >
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h1><i class="fas fa-user text-success mr-2" style="color: #27aae1"></i>Name</h1>
					<h3>Headline</h3>
					</div>
				</div>
			</div>
		</header>
		<!-- HEADER END -->
		<section class="container py-2 mb-4">
			<div class="row">
				<div class="col-md-3">
					<img src="images/avatar.png" class="d-block img-fluid mb-3 rounded-circle" alt="">
				</div>
				<div class="col-md-9" style="min-height: 400px;">
					<div class="card">
						<div class="card-body">
						<p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo assumenda laboriosam provident consequuntur tempore ut dicta deleniti dolor maiores quo sint, voluptatum odit incidunt nesciunt at quibusdam. Nostrum ex, illo. Odio iure repellat nam fugit rerum nulla deserunt voluptates! Dignissimos nihil maxime odio debitis. Tempore libero sint voluptate autem doloribus animi cum a quibusdam delectus, voluptates eum ut at repellendus nobis dignissimos sed odio dolorum.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
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