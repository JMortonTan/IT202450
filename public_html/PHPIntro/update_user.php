<?php
require("config.php");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
try{
    $db = new PDO($connection_string, $dbuser, $dbpass);

    #Delete all
    $stmt = $db->prepare("UPDATE Users set email=:email WHERE email = :original");

    $stmt->bindValue(":email","newemail@test.com");
    $stmt->bindValue(":original","hello@njit.edu");

    $r = $stmt->execute();

    echo var_export($stmt->errorInfo(), true);
    echo var_export($r, true);
}
catch (Exception $e){
    echo $e->getMessage();
}
?>