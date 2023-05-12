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

                            $this->createWallet($UserId, 1, 1, 15); // Création MCGCoin (pour 15 euros = 1 MCGCoin)
                            $this->createWallet($UserId, 2, 10, 10); // Création Euro (pour 10 euros = 10 euros)
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
                $insertWallet = "INSERT INTO wallet (idUser, idCrypto, amount, balanceEUR) VALUES ('$idUser', '$idCrypto', '$amount', '$balance')";
                $insertWalletResult = $GLOBALS["pdo"] -> query($insertWallet);
                if ($insertWalletResult == false)
                {
                    // La création du wallet a échoué, on le signale dans le log
                    error_log("Erreur lors de la création du wallet pour l'utilisateur $this->nom");
                }
            }
        }

        // Méthode pour récuperer tout les wallets
        public function getAllWallet($idUser)
        {
            $idUserNotConv = implode('', $idUser);
            $idUserConvert = substr($idUserNotConv, 0, 1) . substr($idUserNotConv, 2);

            if ($GLOBALS["pdo"])
            {
                $selectAllWallet = "SELECT crypto.name, wallet.amount, wallet.balanceEUR FROM crypto,wallet WHERE wallet.idCrypto = crypto.idCrypto and wallet.idUser='$idUserConvert'";
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
                    return 2;
                }
            }
        }

        // Méthode pour Récupérer tout les marcher
        public function getAllMarket()
        {
            if ($GLOBALS["pdo"])
            {
                $selectAllMarket = "SELECT m.idMarket, m.idCrypto1, c1.name AS crypto1, c1.price AS price1, m.idCrypto2, c2.name AS crypto2, c2.price AS price2 FROM market m JOIN crypto c1 ON m.idCrypto1 = c1.idCrypto JOIN crypto c2 ON m.idCrypto2 = c2.idCrypto";
                $selectAllResult = $GLOBALS["pdo"] -> query($selectAllMarket);

                if ($selectAllResult != false)
                {
                    $row_count = $selectAllResult->rowCount();
                    if($row_count > 0)
                    {
                        $tabMarket = $selectAllResult -> fetchALL();
                        return $tabMarket;
                    }
                    else if ($row_count == 0)
                    {
                        return 2;
                    }
                }
                else if ($selectAllResult == false)
                {
                    // La création du wallet a échoué, on le signale dans le log
                    error_log("Erreur lors de l'optention des marchés de crypto disponible");
                }
            }
        }

        // Méthode pour créer une nouvelle transaction
        public function createTransaction($amountCrypto, $amountEuro, $type, $idMarket, $idUser, $idCryto1, $idCrypto2)
        {
            $idUserNotConv = implode('', $idUser);
            $idUserConvert = substr($idUserNotConv, 0, 1) . substr($idUserNotConv, 2);

            if ($GLOBALS["pdo"])
            {
                if ($type == 1)
                {
                    $selectAmountEuro = "SELECT wallet.balanceEUR FROM wallet WHERE wallet.idCrypto = '$idCrypto2' and wallet.idUser='$idUserConvert'";
                }
                
                $selectAmoutResult = $GLOBALS["pdo"] -> query($selectAmountEuro);

                if ($selectAmoutResult != false)
                {
                    $row_count = $selectAmoutResult->rowCount();
                    if($row_count > 0)
                    {
                        $amountEuroWallet = $selectAmoutResult ->fetch();

                        if ($amountEuroWallet["balanceEUR"] < $amountEuro) // Si le montant en euro est pas suffisant dans le wallet
                        {
                            $amountEuroWallet = 2;
                        }
                        else
                        {
                            $amountEuroWallet = 1;
                        }
                    }
                    else if ($row_count == 0)
                    {
                        return 2;
                    }
                }
                else if ($selectAmoutResult == false)
                {
                    return 2;
                }

                if ($type == 1 && $amountEuroWallet == 2) // Si c'est un achat et qu'il n'a pas le montant suffisant
                {
                    return 3;
                }

                $insertTransaction = "INSERT INTO transaction (idMarket, idUser, type, amountCrypto, amountEuro) VALUES ('$idMarket', '$idUserConvert', '$type', '$amountCrypto', '$amountEuro')";
                $insertTransactionResult = $GLOBALS["pdo"] -> query($insertTransaction);
            
                if ($insertTransactionResult != false)
                {
                    if ($type == 1) // Si c'est un achat
                    {
                        if ($this->addFunds($idUserConvert, $idCryto1, $amountCrypto) == 2) // On va ajouter le montant en crypto
                        {
                            return 2;
                        }

                        if ($this->retrieveFunds($idUserConvert, $idCrypto2, $amountEuro) == 2) // On va retirer le montant en euro
                        {
                            return 2;
                        }
            
                    }
                    else if($type == 2) // Si c'est une vente
                    {
                        if ($this->addFunds($idUserConvert, $idCrypto2, $amountEuro) == 2) // On va rajouter le montant en euro
                        {
                            return 2;
                        }

                        if ($this->retrieveFunds($idUserConvert, $idCryto1, $amountCrypto) == 2) // On va retier le montant en crypto
                        {
                            return 2;
                        }
            
                    }
                }
            }
        }

        // Méthode pour ajouter des fonds à un wallet
        public function addFunds($idUser, $idCryto, $newBalance) 
        {
            if ($GLOBALS["pdo"])
            {
                $updateWallet = "UPDATE wallet w INNER JOIN crypto c ON w.idCrypto = c.idCrypto SET w.balanceEUR = w.balanceEUR + ($newBalance * c.price), w.amount = w.balanceEUR / c.price WHERE w.idUser='$idUser' and w.idCrypto='$idCryto'";
                $updateWalletResult = $GLOBALS["pdo"] -> query($updateWallet);

                if ($updateWalletResult == false)
                {
                    return 2;
                }
            }
        }

        // Méthode pour enlever des fonds à un wallet
        public function retrieveFunds($idUser, $idCryto, $newBalance) 
        {
            if ($GLOBALS["pdo"])
            {
                $updateWallet = "UPDATE wallet w INNER JOIN crypto c ON w.idCrypto = c.idCrypto SET w.balanceEUR = w.balanceEUR - ($newBalance * c.price), w.amount = w.balanceEUR / c.price WHERE w.idUser='$idUser' and w.idCrypto='$idCryto'";
                $updateWalletResult = $GLOBALS["pdo"] -> query($updateWallet);

                if ($updateWalletResult == false)
                {
                    return 2;
                }
            }
        }
    }
?>