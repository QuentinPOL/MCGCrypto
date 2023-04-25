<?php
  session_start();
  include("forms/session.php");
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
                          <td><?=$wallet["amount"]?></td>
                          <td><?=$wallet["balanceEUR"]?> €</td>
                        </tr>
                      <?php

                      $totalBalance += $wallet["balanceEUR"];
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
      <div class="container">
      <h1 class="my-4 text-center">Achat/Vente de Crypto-monnaie</h1>
      <div class="row">
      <?php
        if ($resulMarket != 2)
        {
          foreach ($resulMarket as $market) 
          {
            ?>
              <div class="col-md-6">
                <h2 class="my-4">Acheter</h2>
                <form id="buy-form" style="display:none">
                  <div class="mb-3">
                    <label for="<?=$market["crypto1"]?>-amount" class="form-label">Montant de la crypto-monnaie <?=$market["crypto1"]?> (<?=$market["price1"]?> €)</label>
                    <input type="number" class="form-control" id="<?=$market["crypto1"]?>-amount" oninput="updatePriceInput(1, 1)" required>
                  </div>
                  <div class="mb-3">
                    <label for="<?=$market["crypto2"]?>-amount" class="form-label">Montant en <?=$market["crypto2"]?> (<?=$market["price2"]?> €)</label>
                    <input type="number" class="form-control" id="<?=$market["crypto2"]?>-amount" oninput="updatePriceInput(2, 1)" required>
                  </div>
                  <button type="button" class="btn btn-primary" id="subimitBuy" onclick="callApi('<?=$market['crypto1']?>-amount', '<?=$market['crypto2']?>-amount', 1, <?=$market['idMarket']?>, <?=$market['idCrypto1']?>, <?=$market['idCrypto2']?>)">Acheter</button>
                </form>
              </div>
              <div class="col-md-6">
                <h2 class="my-4">Vendre</h2>
                <form id="sell-form" style="display:none">
                  <div class="mb-3">
                    <label for="<?=$market["crypto1"]?>-amount" class="form-label">Montant de la crypto-monnaie <?=$market["crypto1"]?> (<?=$market["price1"]?> €)</label>
                    <input type="number" class="form-control" id="<?=$market["crypto1"]?>-amount2"  oninput="updatePriceInput(1, 2)" required>
                  </div>
                  <div class="mb-3">
                    <label for="<?=$market["crypto2"]?>-amount" class="form-label">Montant en <?=$market["crypto2"]?> (<?=$market["price2"]?> €)</label>
                    <input type="number" class="form-control" id="<?=$market["crypto2"]?>-amount2" oninput="updatePriceInput(2, 2)" required>
                  </div>
                  <button type="button" class="btn btn-primary" id="subimitSell" onclick="callApi('<?=$market['crypto1']?>-amount2', '<?=$market['crypto2']?>-amount2', 2, <?=$market['idMarket']?>, <?=$market['idCrypto1']?>, <?=$market['idCrypto2']?>)">Vendre</button>
                </form>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-md-4">
                <div class="d-grid gap-2">
                  <button class="btn btn-primary" type="button" id="buy-button">Acheter</button>
                  <button class="btn btn-primary" type="button" id="sell-button">Vendre</button>
                </div>
              </div>
            </div>
          <?php
          } 
        }
      ?>
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- custom js -->
  <script type="text/javascript" src="js/custom.js"></script>
  <!-- Crypto -->
  <script src="js/crypto.js"></script>

  <script>
    function updatePriceInput(method, type) 
    {
      const euroPrice = <?=$market["price2"]?>;
      const cryptoPrice = <?=$market["price1"]?>;

      var euroAmountInput = null;
      var cryptoAmountInput = null;
      var euroAmountInput2 = null;
      var cryptoAmountInput2 = null;

      if (type == 1)
      {
        euroAmountInput = document.getElementById('<?=$market["crypto1"]?>-amount');
        cryptoAmountInput = document.getElementById('<?=$market["crypto2"]?>-amount');

        if(method == 1)
        {
          euroAmountInput.addEventListener('input', function() {
          const euroAmount = parseFloat(euroAmountInput.value);
          const cryptoAmount = euroAmount * cryptoPrice;
          document.getElementById('<?=$market["crypto2"]?>-amount').value = cryptoAmount.toFixed(3);
          });
        }
        else if (method == 2)
        {
          cryptoAmountInput.addEventListener('input', function() {
          const cryptoAmount = parseFloat(cryptoAmountInput.value);
          const euroAmount = cryptoAmount / cryptoPrice;
          document.getElementById('<?=$market["crypto1"]?>-amount').value = euroAmount.toFixed(8);
          });
        }
      }
      else if (type == 2)
      {
        euroAmountInput2 = document.getElementById('<?=$market["crypto1"]?>-amount2');
        cryptoAmountInput2 = document.getElementById('<?=$market["crypto2"]?>-amount2');

        if(method == 1)
        {
          euroAmountInput2.addEventListener('input', function() {
          const euroAmount = parseFloat(euroAmountInput2.value);
          const cryptoAmount = euroAmount * cryptoPrice;
          document.getElementById('<?=$market["crypto2"]?>-amount2').value = cryptoAmount.toFixed(3);
          });
        }
        else if (method == 2)
        {
          cryptoAmountInput2.addEventListener('input', function() {
          const cryptoAmount = parseFloat(cryptoAmountInput2.value);
          const euroAmount = cryptoAmount / cryptoPrice;
          document.getElementById('<?=$market["crypto1"]?>-amount2').value = euroAmount.toFixed(8);
          });
        }
      }
    }

    function callApi(inputCrypto, inputEuro, type, market, crypto1, crypto2) 
    {
      const amountCrypto = document.getElementById(inputCrypto).value;
      const amountEuro = document.getElementById(inputEuro).value;

      apiBuySellCrypto(amountCrypto, amountEuro, type, market, crypto1, crypto2);
    }

  </script>

</body>

</html>