<?php
include("header.php");
?>

<h4>Make it Rain</h4>

<?php

if (isset($_GET['account'])){
    $account_number = $_GET['account'];

    echo $account_number;
    $query = file_get_contents("queries/MAKEITRAIN.sql");

    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    if(!empty($account_number)) {
        echo "I love PDO  <br>";
        $db = new PDO($connection_string, $dbuser, $dbpass);
        echo "It works everytime I want it to. <br>";
        $stmt = $db->prepare($query);
        echo "Its not anyone's fault but mine.";
        $stmt->execute([":account_number" => $account_number]);

    }
}



?>