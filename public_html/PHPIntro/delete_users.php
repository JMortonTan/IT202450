<?php
require("config.php");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
try{
    $db = new PDO($connection_string, $dbuser, $dbpass);

    #Delete all
    $stmt = $db->prepare("DELETE from Users");

    #Selective Delete
    #$stmt = $db->prepare("DELETE from Users where email=: email");
    $r = $stmt->execute();

    echo var_export($stmt->errorInfo(), true);
    echo var_export($r, true);
}
catch (Exception $e){
    echo $e->getMessage();
}
?>