<?php
include("header.php");
?>

<?php

echo "<h4>" . $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] . "'s Account</h4>";

if (isset($_GET['account'])) {
    $account_number = $_GET['account'];
    $balance = $_GET['balance'];

    echo "
        <form method='post'>
        <select name='from_account' id='from_account'>
            <option value='000000000000' selected>World</option>
        </select>
        <input type='text' name='amount' form='Form2'>
        <input type='submit' name='deposit' value='Deposit'>
        </form>";

    if (isset($_POST["deposit"])) {
        #######
        echo "action posted <br>";
        #######
        $amount = $_POST["amount"];
        $account_dest = $_POST["from_account"];
        $negamount = (-1) * $amount;
        $account_src = $account_number;

        #######
        echo $account_dest . " DESTINATION<br>";
        #######
        #######
        echo $account_src . " SRC<br>";
        #######
        #######
        echo $amount . " AMNT<br>";
        #######

        try {
            #######
            echo "attempting query <br>";
            #######
            $query = file_get_contents("queries/DEPOSIT.sql");
            $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
            try {
                $db = new PDO($connection_string, $dbuser, $dbpass);
                $stmt = $db->prepare($query);
                $stmt->execute(array(
                    ":account_src" => $result["account_number"],
                    ":account_dest" => $account_dest,
                    ":amount" => $amount,
                    ":negamount" => $negamount,
                ));
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                #######
                echo "fetch attempted <br>";
                #######
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            if (isset($result)) {
                #######
                echo "result set <br>";
                #######
                echo "Deposit value of " . $amount . " from 000000000000 was successful";
                $balance = $balance + $amount;
                echo "New balance " . $balance;
            } else {
                #######
                echo "result not set <br>";
                #######
                echo "Deposit value of " . $amount . " from 000000000000 was unsuccessful";

            }
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>