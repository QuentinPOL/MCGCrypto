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

                            $UserId = $this->getIdUser($this->email);
                            $_SESSION["idUser"] = $UserId;

                            $this->createWallet($UserId, 1, 10, 10);
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

                                $UserId = $this->getIdUser($login);
                                $_SESSION["idUser"] = $UserId;
                                
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

        public function getIdUser($login)
        {
            $idUser = null;

            $selectID = "SELECT idUser FROM account where email='$login'";
            $selectIdResult = $GLOBALS["pdo"] -> query($selectID);

            if ($selectIdResult != false)
            {
                $row_countId = $selectIdResult->rowCount();
                if($row_countId > 0)
                {
                    $idUser = $selectIdResult->fetch();
                }
            }

            return $idUser;
        }

        // Méthode pour la création de compte
        public function creationSucceeded() 
        {
            return $this->creationSucceeded;
        }

        // Méthode pour créer un wallet pour l'utilisateur
        public function createWallet($idUser, $idCrypto, $amount, $balance) 
        {
            if ($GLOBALS["pdo"])
            {
                $insertWallet = "INSERT INTO wallet (idUser, idCrypto, nombre, balance) VALUES ('$idUser', '$idCrypto', '$amount', '$balance')";
                $insertWalletResult = $GLOBALS["pdo"] -> query($insertWallet);
                if ($insertWalletResult == false)
                {
                    // La création du wallet a échoué, on le signale dans le log
                    error_log("Erreur lors de la création du wallet pour l'utilisateur $this->nom");
                }
            }
        }

        public function getAllWallet($idUser)
        {
            $idUserNotConv = implode('', $idUser);
            $idUserConvert = substr($idUserNotConv, 0, 1) . substr($idUserNotConv, 2);

            if ($GLOBALS["pdo"])
            {
                $selectAllWallet = "SELECT crypto.name, wallet.nombre, wallet.balance FROM crypto,wallet WHERE wallet.idCrypto = Crypto.idCrypto and wallet.idUser='$idUserConvert'";
                $selectAllResult = $GLOBALS["pdo"] -> query($selectAllWallet);

                if ($selectAllResult != false)
                {
                    $row_count = $selectAllResult->rowCount();
                    if($row_count > 0)
                    {
                        $tabCrypto = $selectAllResult -> fetchALL();
                        return $tabCrypto;
                    }
                    else if ($row_count == 0)
                    {
                        return 2;
                    }
                }
                else if ($selectAllResult == false)
                {
                    // La création du wallet a échoué, on le signale dans le log
                    error_log("Erreur lors de la création du wallet pour l'utilisateur ".$_SESSION["Login"]."");
                }
            }
        }

        // Méthode pour ajouter des fonds à un wallet
        public function addFunds($idUser, $idCryto, $amount) 
        {
            if ($GLOBALS["pdo"])
            {
                $updateWallet = "UPDATE wallet SET balance = balance + $amount WHERE idUser='$idUser' and idCryto='$idCryto'";
                $updateWalletResult = $GLOBALS["pdo"] -> query($updateWallet);
                if ($updateWalletResult == false)
                {
                    // L'ajout de fonds a échoué, on le signale dans le log
                    error_log("Erreur lors de l'ajout de $amount pour la monnaie $idCryto sur wallet de l'utilisateur ".$_SESSION["Login"]."");
                }
            }
        }

        // Méthode pour enlever des fonds à un wallet
        public function RetiereFunds($amount) 
        {
            if ($GLOBALS["pdo"])
            {
                $updateWallet = "UPDATE wallet SET balance = balance + $amount WHERE user_id='$this->email'";
                $updateWalletResult = $GLOBALS["pdo"] -> query($updateWallet);
                if ($updateWalletResult == false)
                {
                    // L'ajout de fonds a échoué, on le signale dans le log
                    error_log("Erreur lors de la soustraction de $amount euros au wallet de l'utilisateur ".$_SESSION["Login"]."");
                }
            }
        }
    }
?>