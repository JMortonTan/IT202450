<?php
include("header.php");
?>

    <h4>My Checking Account</h4>

<?php

if (isset($_GET['account'])){
    $account_number = $_GET['account'];
    $query = file_get_contents("queries/SEARCH_TABLE_ACCOUNTS_ACCOUNTNUM.sql");

    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    try {
        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt = $db->prepare($query);
        $result = $stmt->execute([":account_number" => $account_number]);

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if(isset($result) && count($result) == 0){
    echo "<h5>Account Number: </h5>";
    echo "<h5>" . $result["account_number"] . "</h5></br>";

    echo "<h5>Account Type: </h5>";
    echo "<h5>";
    switch ($result["account_type"]) {
        case 1:
            echo "Checking";
            break;
        case 2:
            echo "Savings";
            break;
        case 3:
            echo "Loan";
            break;
        default:
            echo "There is an error";
            break;
    };
    echo "</h5></br>";

    echo "
    <form action=\"/action_page.php\">
    <label for=\"startdate\">Start Date:</label>
    <input type=\"date\" id=\"startdate\" name=\"startdate\">
    <input type=\"submit\">
    </form>

    <form action=\"/action_page.php\">
    <label for=\"enddate\">End Date:</label>
    <input type=\"date\" id=\"enddate\" name=\"enddate\">
    <input type=\"submit\">
    </form>
    ";
}

?>