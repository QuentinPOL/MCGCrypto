<?php
session_start();
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
  <link rel="shortcut icon" href="images/favicon.png">

  <title> A Propos </title>

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
            <ul class="navbar-nav  ">
              <li class="nav-item ">
                <a class="nav-link" href="index.php">Accueil</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="about.php">A Propos<span class="sr-only">(current)</span> </a>
              </li>

              <?php          
                if (isset($_SESSION["IsConnecting"]) && $_SESSION["IsConnecting"] == true)
                {
                  ?>
                    <li class="nav-item">
                      <a class='nav-link' href='marcher.php'>Marcher</a>
                    </li>
                  <?php
                }
              ?>

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
                    echo "<a class='nav-link' href='login.php'><i class='fa fa-user' aria-hidden='true'></i> Login</a>";
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

  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          A propos de <span>Nous</span>
        </h2>
        <p>
          MCGCrypto est une application web simple spécialement conçu pour faire des petits investissements dans le milieu des cryptomonnaies
        </p>
      </div>
    </div>
  </section>
  <!-- end about section -->

  <!-- footer section -->
  <section class="footer_section">
    <div class="container" style="margin-top: 20px;">
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
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->

</body>

</html>