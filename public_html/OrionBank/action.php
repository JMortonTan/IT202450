<?php
include("header.php");
?>

<?php

echo "<h4>" . $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] . "'s Account</h4>";

if (isset($_GET['account'])) {
    $account_number = $_GET['account'];
    $balance = $_GET['balance'];

    $query = file_get_contents("queries/SELECT_TABLE_ACCOUNTS_ACCOUNTNUM.sql");
    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    try {
        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt = $db->prepare($query);
        $stmt->execute([":account_number" => $account_number]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if (isset($result)) {
        #$this_account = $result[0];
        echo "<h5>Account Number: " . $result["account_number"] . "</h5>";
        echo "<h5>Account Type: ";
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
        echo "</h5>";
        echo "<h5>Account Balance: " . $balance . "</h5><br>";

        echo "What type of transaction would you like to make today?";
        echo "<form method='post'>
            <select name='transact_type' id='transact_type'>
                <option value='deposit' selected>Deposit</option>
                <option value='withdraw'>Withdraw</option>
                <option value='transfer'>Transfer Internal</option>
                <option value='external'>Transfer External</option>

            </select>
            <input type='submit' name='submit' value='Submit'>
            </form>";

        if (isset($_POST["submit"])) {
            $action = $_POST["transact_type"];
            switch ($action) {
                case 'deposit':
                    header("Location: deposit.php?account=$account_number&balance=$balance");
                    break;
                case 'withdraw':
                    header("Location: withdraw.php?account=$account_number&balance=$balance");
                    break;
                case 'transfer':
                    header("Location: transfer.php?account=$account_number&balance=$balance");
                    break;
                case 'external':
                    header("Location: transferexternal.php?account=$account_number&balance=$balance");
                    break;
            };
        }
    }
}
?>