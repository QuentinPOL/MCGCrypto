<?php
    session_start();

    include("class.php");

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body, true);

    // Récupération des données
    $tableauDonnee[0] = $data['amountCryp'];
    $tableauDonnee[1] = $data['amountEur'];
    $tableauDonnee[2] = $data['method'];
    $tableauDonnee[3] = $data['marketnumber'];
    $tableauDonnee[4] = $data['crypt1'];
    $tableauDonnee[5] = $data['crypt2'];

    $theUser = new User(NULL, NULL, NULL); // Définition de l'utilsateur à NULL
    $resulAction = $theUser->createTransaction($tableauDonnee[0],  $tableauDonnee[1],  $tableauDonnee[2], $tableauDonnee[3], $_SESSION["idUser"], $tableauDonnee[4], $tableauDonnee[5]); // On Créer la nouvelle transaction
    
    if ($resulAction != 2)
    {
        echo json_encode($tableauDonnee);
    }
    else 
    {
        $tableauDonnee[0] = "erreur";
        echo json_encode($tableauDonnee[0]);
    }
?>
