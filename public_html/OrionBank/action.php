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
                <option value='transfer'>Transfer</option>
            </select>
            <input type='submit' name='submit' value='Submit'>
            </form>";

        if (isset($_POST["submit"])) {
            $action = $_POST["transact_type"];
            switch ($action) {
                case 'deposit':
                    echo "
                        <form method='post'>
                        <select name='from_account' id='from_account'>
                            <option value='000000000000' selected>World</option>
                        </select>
                        <label for='amount'>Amount<input type='amount' name='amount'></label>
                        <input type='submit' name='deposit_activate' value='Deposit'>
                        </form>";

                    if(isset($_POST["deposit_activate"])) {
                        #######
                        echo "action posted <br>";
                        #######
                        $amount = $_POST["amount"];

                        try {
                            #######
                            echo "attempting query <br>";
                            #######
                            $query = file_get_contents("queries/DEPOSIT.sql");
                            $stmt = $db->prepare($query);
                            $stmt->execute(array(
                                ":account_src" => $result["account_number"],
                                ":account_dest" => '000000000000',
                                ":amount" => $amount,
                            ));
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            #######
                            echo "fetch attempted <br>";
                            #######
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }

                        if(isset($result)){
                            #######
                            echo "result set <br>";
                            #######
                            echo "Deposit value of " . $amount . " from 000000000000 was successful";
                        }else{
                            #######
                            echo "result not set <br>";
                            #######
                            echo "Deposit value of " . $amount . " from 000000000000 was unsuccessful";
                        }
                    }

                    break;
                case 'withdraw':
                    echo "
                        <form method='post'>
                        <select name='to_account' id='to_account'>
                            <option value='000000000000' selected>World</option>
                        </select>
                        <label for='amount'>Amount<input type='amount' name='amount'></label>
                        <input type='submit' name='withdraw' value='Withdraw'>
                        </form>";
                    break;
                case 'transfer':
                    echo "
                        <form method='post'>
                        <select name='to_account' id='to_account'>
                            <option value='000000000000' selected>World</option>
                        </select>
                        <label for='amount'>Amount<input type='amount' name='amount'></label>
                        <input type='submit' name='transfer' value='Transfer'>
                        </form>";
                    break;
            };
        }
    }
}
?>