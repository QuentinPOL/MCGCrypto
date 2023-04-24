<?php
    include("class.php");

    $current_url = $_SERVER['REQUEST_URI']; // Récupérer le nom du fichier
    $theUser = new User(NULL, NULL, NULL); // Définition de l'utilsateur à NULL

    if (strpos($current_url, '/inscription.php') !== false) // Si page inscription
    {
        $isSignUp = -1; // Définition de l'inscriptioon

        if (isset($_POST["btnSubmit"])) // Si il appuis le bouton inscrire en tant que Docteur
        {
          if (!(isset($_SESSION["IsConnecting"]))) // Si il est pas connecter
          {
            $theUser = new User($_POST["inputNom"], $_POST["inputEmail"], hash('sha256', $_POST["inputPassword"]));
          }
        }

        if ($theUser->creationSucceeded() == 1) // Création réussi
        {
          $_SESSION["IsConnecting"] = true;
          $_SESSION["Login"] = $_POST["inputNom"]; // Tableau de session Login = login de l'utilsateur

          echo "<script>window.location.href = 'index.php';</script>";
        }
        else if ($theUser->creationSucceeded() == 2) // Compte existe déjà
        {
            $isSignUp = 2;
        }
        else // Erreur
        {
            $isSignUp = 0;
        }
    }
    else if (strpos($current_url, '/login.php') !== false) // Si page connexion
    {
        $statusConnect = -1; // Définition de la connexion

        if (isset($_POST["btnSubmit"])) // Si il appuis le bouton connexion
        {
          if (!(isset($_SESSION["IsConnecting"]))) // Si il est pas connecter
          {
            $statusConnect = $theUser->onConnect($_POST["inputEmail"], hash('sha256', $_POST["inputPassword"]));
    
            if ($statusConnect == 1)
            {
              $_SESSION["IsConnecting"] = true;
              echo "<script>window.location.href = 'index.php';</script>";
            }
          }
        }
    }
    else if (strpos($current_url, '/marcher.php') !== false) // Si page marcher/wallet
    {
      $resultWallet = $theUser->getAllWallet($_SESSION["idUser"]);
      $totalBalance = null;

      $resulMarket = $theUser->getAllMarket();
    }
?>