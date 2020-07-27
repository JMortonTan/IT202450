<?php
include("header.php");
?>

<?php

echo "<h4>" . $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] . "'s Account</h4>";

$search = $_SESSION["user"]["id"];
if (isset($_GET['account']) && isset($search)) {
    $account_number = $_GET['account'];
    $balance = $_GET['balance'];

    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    $query = file_get_contents("queries/LISTBYID.sql");
    try {
        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt = $db->prepare($query);
        $stmt->execute([":search" => $search]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    echo "
        <form method='post'>
        <select name='from_account' id='from_account'>";
        foreach($results as $accounts_array){
            if ($accounts_array["account_number"] != $account_number){
                echo "<option value=" . $accounts_array["account_number"] . ">" . $accounts_array["account_number"] . "</option>";
            }
        }
    echo "</select>
        <label for='amount'>Amount: 
            <input type='number' name='amount'/>
        </label>
        <input type='submit' name='transfer' value='Transfer'>
        </form>";

    if (isset($_POST["transfer"])) {
        $amount = $_POST["amount"];
        $account_src = $account_number;
        $account_dest = $_POST["from_account"];
        $negamount = (-1) * $amount;
        $new_balance = $balance - $amount;

        if ($amount > $balance) {
            echo "You cannot transfer more than the current balance!";
            exit;
        }

        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try {
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $query = file_get_contents("queries/GET_ACCOUNT_BALANCE.sql");
            $stmt = $db->prepare($query);
            $stmt->execute([":account_number" => $account_dest]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $world_total = $result[0]['balance'];
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $new_world_balance = $world_total + $amount;

        try {
            $query = file_get_contents("queries/TRANSFER.sql");
            try {
                $db = new PDO($connection_string, $dbuser, $dbpass);
                #######
                echo $query . "<br>";
                #######
                $stmt = $db->prepare($query);
                $stmt->execute(array(
                    ":account_src" => $account_src,
                    ":account_dest" => $account_dest,
                    ":amount" => $amount,
                    ":negamount" => $negamount,
                    ":new_balance" => $new_balance,
                    ":new_world_balance" => $new_world_balance
                ));

                $e = $stmt->errorInfo();
            } catch (Exception $e) {
                echo $e->getMessage();

                echo "Withdrawal value of " . $amount . " to 000000000000 was unsuccessful";
            }
            echo "Transfer value of $" . $amount . " to " . $account_dest . " was successful <br>";
            $balance = $balance - $amount;
            echo "New balance $" . $balance;

        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>