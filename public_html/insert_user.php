<?php
require("config.php");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
try{
    $db = new PDO($connection_string, $dbuser, $dbpass);
    $stmt = $db->prepare("INSERT INTO User (email) VALUES (:email)");
    $r = $stmt->execute(array(
        ":email"=>"hello@njit.edu"
    ));

    echo var_export($stmt->errorInfo(), true);
    echo var_export($r, true);
}
catch (Exception $e){
    echo $e->getMessage();
}
?>