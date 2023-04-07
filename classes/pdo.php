<?php

$ipserver ="127.0.0.1";
$nomBase = "MCGcrypto";
$loginPrivilege ="root";
$passPrivilege ="root";

$GLOBALS["pdo"] = new PDO('mysql:host='.$ipserver.';dbname='.$nomBase.";charset=utf8mb4",$loginPrivilege,$passPrivilege);

if($GLOBALS["pdo"]){
    return $GLOBALS["pdo"];
}
else{
    echo "<p>problème à la connexion de la bdd</p>";
}

?>