<?php
  session_start();
  include("pdo.php");
  include("class.php");

  $current_url = $_SERVER['REQUEST_URI']; // On recup la page
  $user = new User(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


        $inscrit = 0;

        if (isset($_POST["inscrireDocteur"])) // Si il appuis le bouton inscrire en tant que Docteur
        {
          if (!(isset($_SESSION["IsConnecting"]))) // Si il est pas connecter
          {
           $user = new User(NULL, $_POST["drone"], $_POST["NomDocteur"], $_POST["PrenomDocteur"], $_POST["DateBornDocteur"], $_POST["TelDocteur"], $_POST["MailDocteur"], $_POST["PwdDocteur"], "Medecin");
          }
      
          $inscrit = $user->__construct(NULL, $_POST["drone"], $_POST["NomDocteur"], $_POST["PrenomDocteur"], $_POST["DateBornDocteur"], $_POST["TelDocteur"], $_POST["MailDocteur"], $_POST["PwdDocteur"], "Medecin");
        
          header('Refresh:0;url=test.php',true,303); // Changer par include
        }
        else if (isset($_POST["inscrirePatient"])) // Si il appuis le bouton inscrire en tant que Patient
        {
          if (!(isset($_SESSION["IsConnecting"]))) // Si il est pas connecter
          {
            $user = new User($_POST["NumSS"], $_POST["drone"], $_POST["NomPatient"], $_POST["PrenomPatient"], $_POST["DateBornPatient"], $_POST["TelPatient"], $_POST["MailPatient"], $_POST["PwdPatient"], "Patient");
          }
      
          $inscrit = $user->__construct($_POST["NumSS"], $_POST["drone"], $_POST["NomPatient"], $_POST["PrenomPatient"], $_POST["DateBornPatient"], $_POST["TelPatient"], $_POST["MailPatient"], $_POST["PwdPatient"], "Patient");
        }
      
        if ($inscrit == 1) // Si l'inscription est réussi
        {
          header('Refresh:0;url=connexion.php',true,303);
        }   

    
    if (strpos($current_url, '/connexion.php') !== false) // Si page de connexion
    {
        $connexion = 0;

        if (isset($_POST["ConnexionDocteur"])) // Si il appuis le bouton connexion en tant que Docteur
        {
          if (!(isset($_SESSION["IsConnecting"]))) // Si il est pas connecter
          {
            if ($user->onConnect($_POST["EmailDocteur"], $_POST["PwdDocteur"], "medecin") == 1)
            {
              $_SESSION["IsConnecting"] = true;
              $_SESSION["Login"] = $_POST["EmailDocteur"]; // Tableau de session Login = login de l'utilsateur
              $_SESSION["IsType"] = "medecin";
      
              header("Location: consultation.php");
            }
          }
        }
        else if (isset($_POST["ConnexionPatient"])) // Si il appuis le bouton connexion en tant que Patient
        {
          if (!(isset($_SESSION["IsConnecting"]))) // Si il est pas connecter
          {
            if ($user->onConnect($_POST["EmailPatient"], $_POST["PwdPatient"], "patient") == 1)
            {
              $_SESSION["IsConnecting"] = true;
              $_SESSION["Login"] = $_POST["EmailPatient"]; // Tableau de session Login = login de l'utilsateur
              $_SESSION["IsType"] = "patient";
      
              header("Location: consultation.php");
            }
          }
        }
    }
?>