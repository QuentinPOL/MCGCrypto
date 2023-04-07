<?php
  session_start();
  include("forms/session.php");
?>

<!doctype html>
<html lang="fr">
  <head>
  	<title> Connexion </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/login.css">

	</head>

	
	<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">

    <!-- header section strats -->
    <header class="header_section">
		<div class="container-fluid">
		  <nav class="navbar navbar-expand-lg custom_nav-container ">
			<a class="navbar-brand" href="index.html">
			  <span>
				MCGCrypto
			  </span>
			</a>
  
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			  <ul class="navbar-nav ml-auto lead">
				<li class="nav-item active">
				  <a class="nav-link" href="index.php">Accueil</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="about.php">A Propos</a>
				</li>
			  </ul>
			</div>
		  </nav>
		</div>
	</header>

	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Connexion</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Déjà un compte ?</h3>
		      	<form action="#" class="signin-form">
		      		<div class="form-group">
		      			<input type="text" class="form-control" placeholder="Email" required>
		      		</div>
	            <div class="form-group">
	              <input id="password-field" type="password" class="form-control" placeholder="Mot de passe" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Se connecter</button>
	            </div>
	          </form>
	          <p class="w-100 text-center">&mdash; Pas inscrit ? &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="inscription.php" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Inscription</a>
	          </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
  	<script src="js/main.js"></script>
	</body>
</html>

