<!doctype html>
<html>

<head>
	<title>Novone - Home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="/novone/public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/novone/public/assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/novone/public/assets/animate-css/animate.css">
	<link rel="stylesheet" type="text/css" href="/novone/public/css/index.css">
	<link rel="stylesheet" type="text/css" href="/novone/public/css/products.css">
	<link rel="stylesheet" href="/novone/public/plugins/dropify/css/dropify.min.css" />
	<link rel="stylesheet" href="/novone/public/plugins/jquerysteps/jquery.steps.css"/>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<style>

	</style>


	<script  src="/novone/public/assets/jquery/jquery.min.js"></script>
	<script defer src="/novone/public/assets/bootstrap/js/bootstrap.min.js"></script>

	<script  src="/novone/public/assets/jquery/jquery-ui.js"></script>
	
	

</head>


<body>
	<nav class="navbar navbar-fixed-top navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Novone</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right effect4">
					<li class="home-menu">
						<a href="/novone/public/">
							<i class="fa fa-home" aria-hidden="true"></i> Home</a>
					</li>
					<li class="products-menu">
						<a href="/novone/public/products">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i> Products</a>
					</li>
					<li class="services-menu">
						<a href="#" role="button">
							<i class="fa fa-handshake-o" aria-hidden="true"></i> Services</a>
					</li>
					<li>
						<a href="#" class="about-menu">
							<i class="fa fa-info-circle" aria-hidden="true"></i> About</a>
					</li>
					<li>
						<a href="#" class="contact-menu">
							<i class="fa fa-phone-square" aria-hidden="true"></i> Contact</a>
					</li>
					@if(Session::has('currentClient'))


					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Hi {{Session::get('currentClient')['firstname']}}!
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="#">Profile</a>
							</li>
							<li>
								<a href="/novone/public/cart/user">Shopping Cart</a>
							</li>
							<li>
								<a href="#">Settings</a>
							</li>
							<li>
								<a href="/novone/public/client/logout">Logout</a>
							</li>
						</ul>
					</li>
					@else
					<li>
						<a href="/novone/public/login">
							<i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
					</li>
					<li>
						<a href="/novone/public/signup">
							<i class="fa fa-sign-up" aria-hidden="true"></i> Signup</a>
					</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>