<?php
    include("pdo.php"); // Base de donnée

    class User // Utilisateur(s) du site
    {
        // Attribut(s)
        private $nom;
        private $email;
        private $creationSucceeded;

        // Constructeur
        public function __construct($nom, $email, $motdepasse)
        {
            $insert = null;
            $this->creationSucceeded = -1; // par défaut, la création échoue
    
            if ($email != null) // Si un des champs n'est pas nul
            {
                if ($GLOBALS["pdo"]) // Si la connexion à la bdd est réussi
                {
                    $count = 0;
    
                    $account = "SELECT * FROM account";
                    $selectAccount = $GLOBALS["pdo"]->query($account);
        
                    if($selectAccount != false)
                    {
                        $row_count = $selectAccount->rowCount();
                        if($row_count > 0)
                        {
                            $tabAccount = $selectAccount->fetchAll();
                            foreach($tabAccount as $accountX)
                            {
                                if($email != $accountX['email'] && $nom != $accountX['nom'])
                                {
                                    $count = 1;
                                }
                                else if ($email == $accountX['email'] || $nom == $accountX['nom'])
                                {
                                    $this->creationSucceeded = 2;
                                    $insert = 2;
                                    break;
                                }
                            }
        
                            if ($count == 1)
                            {
                                $insert = "INSERT INTO account (nom, email, password) VALUES ('$nom', '$email', '$motdepasse');";
                            }
                        }
                        else if($row_count == 0)
                        {
                            $insert = "INSERT INTO account (nom, email, password) VALUES ('$nom', '$email', '$motdepasse');";     
                        }
                    }
    
                    if ($insert != null && $insert != 2)
                    {
                        $insertResult = $GLOBALS["pdo"] -> query($insert);
        
                        if ($insertResult != false)
                        {
                            $this->nom = $nom;
                            $this->email = $email;
                            $this->creationSucceeded = 1;

                            $selectID = "SELECT idUser FROM account where nom='$this->nom' and email='$this->email'";
                            $selectIdResult = $GLOBALS["pdo"] -> query($selectID);
                
                            if ($selectIdResult != false)
                            {
                                $row_countId = $selectIdResult->rowCount();
                                if($row_countId > 0)
                                {
                                    $UserId = $selectIdResult->fetch();

                                    $this->createWallet($UserId);
                                    $this->addFunds($UserId, 1, 10);
                                }
                            }
                        }
                        else
                        {
                            $this->creationSucceeded = 0;
                        }
                    }
                    else if ($insert == null)
                    {
                        $this->creationSucceeded = 0;
                    }
                }
                else
                {
                    $this->creationSucceeded = 0;
                }
            }
        } 

        public function onConnect($login, $password)
        {
            if ($GLOBALS["pdo"]) // Si la connexion à la bdd est réussi
            {
                $select = "SELECT nom, email, password FROM account where email='$login'";
                $selectResult = $GLOBALS["pdo"] -> query($select);
    
                if ($selectResult != false)
                {
                    $row_count = $selectResult->rowCount();
                    if($row_count > 0)
                    {
                        $tabUser = $selectResult -> fetchALL();
                        foreach($tabUser as $user)
                        {
                            if($login == $user['email'] &&  $password == $user['password']) // Si un user avec le même mdp à était trouvé alors on le connecte
                            {
                                // On va ainsi prendre le pseudo pour la session
                                $_SESSION["Login"] = $user['nom']; // Tableau de session Login = login de l'utilsateur
                                return 1;
                            }
                            else if ($password != $user['password'])
                            {
                                return 3;
                            }
                        }
                    }
                    else if ($row_count == 0)
                    {
                        return 2;
                    }
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return 0;
            }
        }
        // Méthode pour la création de compte
        public function creationSucceeded() 
        {
            return $this->creationSucceeded;
        }

        // Méthode pour créer un wallet pour l'utilisateur
        private function createWallet($idUser) 
        {
            if ($GLOBALS["pdo"])
            {
                $insertWallet = "INSERT INTO wallet (idUser) VALUES ('$idUser')";
                $insertWalletResult = $GLOBALS["pdo"] -> query($insertWallet);
                if ($insertWalletResult == false)
                {
                    // La création du wallet a échoué, on le signale dans le log
                    error_log("Erreur lors de la création du wallet pour l'utilisateur $this->nom");
                }
            }
        }

        // Méthode pour ajouter des fonds à un wallet
        private function addFunds($idUser, $idCryto, $amount) 
        {
            if ($GLOBALS["pdo"])
            {
                $updateWallet = "UPDATE wallet SET balance = balance + $amount WHERE idUser = '$idUser' and idCryto = '$idCryto'";
                $updateWalletResult = $GLOBALS["pdo"] -> query($updateWallet);
                if ($updateWalletResult == false)
                {
                    // L'ajout de fonds a échoué, on le signale dans le log
                    error_log("Erreur lors de l'ajout de $amount pour la monnaie $idCryto sur wallet de l'utilisateur $this->nom");
                }
            }
        }

        // Méthode pour enlever des fonds à un wallet
        private function RetiereFunds($amount) 
        {
            if ($GLOBALS["pdo"])
            {
                $updateWallet = "UPDATE wallet SET balance = balance + $amount WHERE user_id = '$this->email'";
                $updateWalletResult = $GLOBALS["pdo"] -> query($updateWallet);
                if ($updateWalletResult == false)
                {
                    // L'ajout de fonds a échoué, on le signale dans le log
                    error_log("Erreur lors de la soustraction de $amount euros au wallet de l'utilisateur $this->email");
                }
            }
        }
    }
?>