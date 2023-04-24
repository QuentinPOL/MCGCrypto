<?php
  session_start();
  include("classes/session.php");
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <title> MCGCrypto </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>

<body class="sub_page">

  <div class="hero_area">

    <div class="hero_bg_box">
      <div class="bg_img_box">
        <img src="images/hero-bg.png" alt="">
      </div>
    </div>

    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.html">
            <span>
              MCGCrypto
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Accueil</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">A Propos</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="about.php">Marcher<span class="sr-only">(current)</span> </a>
              </li>

              <li class="nav-item">
                <?php
                  if (isset($_SESSION["IsConnecting"]) && $_SESSION["IsConnecting"] == true)
                  {
                    ?>
                      <form action="" method="post">
                        <li class="nav-item">
                          <button type='submit' name='Deconnexion' class="btn btn-primary">Se déconnecter</button>
                        </li>
                      </form>
                    <?php
                  
                    if (isset($_POST["Deconnexion"])) // Sinon si l'utilisateur appuis sur le bouton de déconnexion
                    {
                      session_unset(); // On supprime tout les tableaux de la session
                      session_destroy(); // On détruit la session
                      header("Location: index.php");
                    }
                  }
                  else
                  {
                    header("Location: login.php");
                  }
                ?>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>


  <section class="service_section layout_padding">
    <div class="service_container">
      <div class="container ">
        <div class="heading_container heading_center">
          <div class="container mt-5">
            <h1 class="text-center mb-4">Votre wallet Crypto/Monnaie</h1>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Crypto/monnaie</th>
                  <th scope="col">Quantité</th>
                  <th scope="col">Prix</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if ($resultWallet != 2)
                  {
                    foreach ($resultWallet as $wallet) 
                    {
                      ?>
                        <tr>  
                          <td><?=$wallet["name"]?></td>
                          <td><?=$wallet["nombre"]?></td>
                          <td><?=$wallet["balance"]?> €</td>
                        </tr>
                      <?php

                      $totalBalance += $wallet["balance"];
                    }
                  }
                ?>
              </tbody>
            </table>
            <p class="text-right font-weight-bold">Total du Portefeuille: <?=$totalBalance?> €</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end service section -->

  <section class="service_section layout_padding">
  <div class="container mt-5">
      <h1 class="text-center mb-4">Achat/Vente Crypto-monnaies</h1>
      <form>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="crypto-select">Crypto-monnaie</label>
            <select id="crypto-select" class="form-control">
              <option value="BTC">Bitcoin</option>
              <option value="ETH">Ethereum</option>
              <option value="LTC">Litecoin</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="quantity-input">Quantité</label>
            <input type="number" class="form-control" id="quantity-input" placeholder="Quantité">
          </div>
          <div class="form-group col-md-4">
            <label for="currency-select">Devise</label>
            <select id="currency-select" class="form-control">
              <option value="EUR" selected>Euro</option>
              <option value="USD">Dollar américain</option>
              <option value="GBP">Livre sterling</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="price-input">Prix d'achat</label>
            <input type="text" class="form-control" id="buy-price-input" placeholder="0">
          </div>
          <div class="form-group col-md-4">
            <label for="price-input">Prix de vente</label>
            <input type="text" class="form-control" id="sell-price-input" placeholder="0">
          </div>
          <div class="form-group col-md-4">
            <button type="button" class="btn btn-primary btn-block" onclick="calculatePrices()">Calculer</button>
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- end service section -->

  <!-- footer section -->
  <section class="footer_section">
    <div class="container">
      <p>
      &copy; <span id="displayYear"></span> All Rights Reserved By POLLET Quentin
      </p>
    </div>
  </section>
  <!-- footer section -->

  <!-- jQery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- custom js -->
  <script type="text/javascript" src="js/custom.js"></script>
  <!-- Crypto
  <script src="crypto.js"></script>-->

</body>

</html>