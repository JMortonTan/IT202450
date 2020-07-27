<?php
include("header.php");
?>

<h4>Make it Rain</h4>

<?php

if (isset($_GET['account'])){
    $account_number = $_GET['account'];

    echo $account_number;
    $query = file_get_contents("queries/MAKEITRAIN.sql");

    try {
        $db = getDB();
        $stmt = $db->prepare($query);
        $stmt->execute([":account_number" => $account_number]);
        header("Location: accounts.php");

    } catch (Exception $e) {
    echo $e->getMessage();
}
}



?>