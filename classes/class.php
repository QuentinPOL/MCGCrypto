<?php
session_start();
include("pdo.php");

    class User {
        // Propriété(s)
        private $numSS;
        private $civilite; 
        private $nom;
        private $prenom; 
        private $datenaissance; 
        private $telephone; 
        private $email; 
        private $motdepasse; 
        private $type;
    
        // Constructeur
        public function __construct($numSS, $civilite, $nom, $prenom, $datenaissance, $telephone, $email, $motdepasse, $type)
        {
            if ($GLOBALS["pdo"]) // Si la connexion à la bdd est réussi
            {
                if ($type == "Medecin")// Si c'est un Docteur
                {
                    $count = 0;
                    $cafetiere= "SELECT * FROM medecin";
                    $selectMedecins= $GLOBALS["pdo"]->query($cafetiere);
    
                    if($selectMedecins !=false)
                    {
                        $row_count=$selectMedecins->rowCount();
                        if($row_count>0)
                        {
                            $tabMedecins= $selectMedecins->fetchAll();
                            foreach($tabMedecins as $medecins)
                            {
                                if($email != $medecins['email'])
                                {
                                    $count = 1;
                                }
                                else if ($email == $medecins['email'])
                                {
                                    return 2;
                                }
                            }
    
                            if ($count == 1)
                            {
                                $insert = "INSERT INTO medecin (civilite, nom, prenom, dateDeNaissance, telephone, email, motDePasse) values ('$civilite','$nom','$prenom', '$datenaissance', '$telephone', '$email', '$motdepasse');";
                            }
                        }
                        else if($row_count==0)
                        {
                            $insert = "INSERT INTO medecin (civilite, nom, prenom, dateDeNaissance, telephone, email, motDePasse) values ('$civilite','$nom','$prenom', '$datenaissance', '$telephone', '$email', '$motdepasse');";       
                        }
                    }
                }
                elseif ($type == "Patient") // Si c'est un Patient
                {
                    $count = 0;
                    $cafetiereconnectetoi = "SELECT * FROM patient";
                    $selectPatients = $GLOBALS["pdo"]->query($cafetiereconnectetoi);
    
                    if($selectPatients !=false)
                    {
                        $row_count = $selectPatients->rowCount();
                        if($row_count > 0)
                        {
                            $tabPatients= $selectPatients->fetchAll();
                            foreach($tabPatients as $patients)
                            {
                                if($email != $patients['email'] && $numSS != $patients["numSS"])
                                {
                                    $count = 1;
                                }
                                else if ($email == $patients['email'] && $numSS == $patients["numSS"])
                                {
                                    return 2;
                                }
                                else if ($email == $patients['email'] || $numSS == $patients["numSS"])
                                {
                                    return 2;
                                }
                            }
    
                            if($count == 1)
                            {
                                $insert = "INSERT INTO patient (numSS, civilite, nom, prenom, dateDeNaissance, telephone, email, motDePasse) values ('$numSS', '$civilite','$nom','$prenom', '$datenaissance', '$telephone', '$email', '$motdepasse');";
                            }
                        }
                        else if ($row_count==0)
                        {
                            $insert = "INSERT INTO patient (numSS, civilite, nom, prenom, dateDeNaissance, telephone, email, motDePasse) values ('$numSS', '$civilite','$nom','$prenom', '$datenaissance', '$telephone', '$email', '$motdepasse');";
                        }
                        
                    }
                    
                }
    
                $insertResult = $GLOBALS["pdo"] -> query($insert);
    
                if($insertResult != false)
                {
                    $this->civilite = $civilite;
                    $this->nom = $nom;
                    $this->prenom = $prenom;
                    $this->datenaissance = $datenaissance;
                    $this->telephone = $telephone;
                    $this->email = $email;
                    $this->motdepasse = $motdepasse;
                    $this->type = $type;

                    return 1;
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

        // Méthode(s)
       public function onConnect($login, $password, $type)
       {
        $_SESSION["IsConnecting"] = false;
        
        if ($GLOBALS["pdo"]) // Si la connexion à la bdd est réussi
        {
            $select = "SELECT email, motDePasse FROM {$this->$type} where email='$login'";
            $selectResult = $GLOBALS["pdo"] -> query($select);

            if ($selectResult != false)
            {
                $row_count=$selectResult->rowCount();
                if($row_count>0)
                {
                    $tabUser = $selectResult -> fetchALL();
                    foreach($tabUser as $user)
                    {
                        if($login == $user['email'] &&  $this->$password == $user['motDePasse']) // Si un user avec le même mdp à était trouvé alors on le connecte
                        {
                            return 1;
                        }
                        else if ($this->$password != $user['motDePasse'])
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
    }
?>