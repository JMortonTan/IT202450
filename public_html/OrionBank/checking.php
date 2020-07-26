<?php
include("header.php");
?>

<?php

echo "<h4>" . $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] . "'s Checking Account</h4>";

if (isset($_GET['account'])){
    $account_number = $_GET['account'];
    echo $account_number;
    $query = file_get_contents("queries/SELECT_TABLE_ACCOUNTS_ACCOUNTNUM.sql");
    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    try {
        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt = $db->prepare($query);
        $stmt->execute([":account_number" => $account_number]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo $result;
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if(isset($result)){
        $this_account = $result[0];
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
    <form method='post'>
    <label for=\"startdate\">Start Date:</label>
    <input type=\"date\" id=\"startdate\" name=\"startdate\">
    <label for=\"enddate\">End Date:</label>
    <input type=\"date\" id=\"enddate\" name=\"enddate\">
    <label for=\"result_num\">Results</label>
    <select name=\"result_num\" id=\"result_num\">
        <option value=\"10\">10</option>
        <option value=\"25\">25</option>
        <option value=\"100\">100</option>
        <option value=\"All\" selected>All</option>
    </select>
    <input type=\"submit\" value='Submit'>
    </form>
    ";
    }
}
?>