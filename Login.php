<?php
require_once ("includes/DB.php");
require_once ("includes/Functions.php");
require_once ("includes/Sessions.php");
$SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); 


if(isset($SESSION["UserId"])) {
	Redirect_to("Dashboard.php");
}

if(isset($_POST["Submit"])) {
	$UserName = $_POST['Username'];
	$Password = $_POST['Password'];
	if(empty($UserName)||empty($Password)) {
		$_SESSION['ErrorMsg'] = "All fields must be filled out";
		Redirect_to("Login.php");
	}else{
		//CODE FOR CHECKING USERNAME AND PASSWORD FROM DATABASE
		$Found_Account = Login_Attemt($UserName,$Password);
 		if($Found_Account) {
 			$_SESSION["UserId"] = $Found_Account["id"];
 			$_SESSION["UserName"] = $Found_Account["username"];
 			$_SESSION["AdminName"] = $Found_Account["aname"];

 			$_SESSION['SuccessMsg'] = "Welcome ".$_SESSION["AdminName"]."!";

 			if(isset($SESSION["TrackingURL"])){
 			Redirect_to("Dashboard.php");	
 			}
 			Redirect_to("Dashboard.php");
 		}else{
 			$_SESSION['ErrorMsg'] = "Incorrect Username/Password";
 			Redirect_to("Login.php");
 		}
 	}
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title>Login </title>
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
					</div>
				</div>
			</div>
		</header>
		<!-- HEADER END -->

		<!-- MAIN AREA START -->
		<section class="container py-2 mb-4">
			<div class="row">
				<div class="offset-sm-3 col-sm-6" style="min-height: 500px;">
					<br><br><br>
					<?php 
					echo ErrorMsg();
					echo SuccessMsg();

					?>
					<div class="card bg-secondary text-light">
						<div class="card-header">
							<h4>Welcome Back !</h4>
							</div>
							<div class="card-body bg-dark">
							
							<form action="Login.php" method="post">
								<div class="form-group">
									<label for="username"><span class="FieldInfo">Username:</span></label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
										</div>
										<input type="text" class="form-control" name="Username" id="username">
									</div>
								</div>
								<div class="form-group">
									<label for="password"><span class="FieldInfo">Password:</span></label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
										</div>
										<input type="password" class="form-control" name="Password" id="password">
									</div>
								</div>
								<input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
							</form>
						</div>
					</div>
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