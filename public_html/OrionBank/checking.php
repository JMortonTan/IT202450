<?php
include("header.php");
?>

    <h4>My Checking Account</h4>

<?php

if (isset($_GET['account'])){
    $account_number = $_GET['account'];

    echo $account_number;
    $query = file_get_contents("queries/SEARCH_TABLE_ACCOUNTS_ACCOUNTNUM.sql");

    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    try {
        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt = $db->prepare($query);
        $stmt->execute([":account_number" => $account_number]);

    } catch (Exception $e) {
        echo $e->getMessage();
    }


}


?>