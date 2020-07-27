<?php
include("header.php");
?>

<?php

echo "<h4>" . $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] . "'s Account</h4>";

if (isset($_GET['account'])) {
    $account_number = $_GET['account'];
    $balance = $_GET['balance'];

    #######
    echo $account_number . " number<br>";
    #######
    #######
    echo $balance . " the lance<br>";
    #######

    echo "
        <form method='post'>
        <select name='from_account' id='from_account'>
            <option value='000000000000' selected>World</option>
        </select>
        <label for='amount'>Amount: 
            <input type='number' name='amount'/>
        </label>
        <input type='submit' name='withdraw' value='Withdraw'>
        </form>";

    if (isset($_POST["withdraw"])) {
        $amount = $_POST["amount"];
        $account_src = $account_number;
        $account_dest = $_POST["from_account"];
        $negamount = (-1) * $amount;
        $new_balance = $balance + $amount;

        #######
        echo $account_src . " SRC<br>";
        #######
        #######
        echo $account_dest . " DEST<br>";
        #######

        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try {
            #######
            echo " try get world<br>";
            #######
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $query = file_get_contents("queries/GET_WORLD_BALANCE.sql");
            $stmt = $db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $world_total = $result[0]['balance'];
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        #######
        echo $world_total . " world total<br>";
        #######

        $new_world_balance = $world_total + $amount;

        try {
            #######
            echo "attempting query <br>";
            #######

            $query = file_get_contents("queries/DEPOSIT.sql");
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
                #######
                echo "fetch attempted <br>";
                #######
            } catch (Exception $e) {
                echo $e->getMessage();

                echo "Withdrawal value of " . $amount . " from 000000000000 was unsuccessful";
            }

            #######
            echo "result set <br>";
            #######
            echo "Withdrawal value of $" . $amount . " from 000000000000 was successful <br>";
            $balance = $balance - $amount;
            echo "New balance " . $balance;

        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>