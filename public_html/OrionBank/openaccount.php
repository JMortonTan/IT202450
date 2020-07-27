<?php
include("header.php");
?>
<h4>Open Account</h4>

<form method="POST">
    <label for="Account_Type">Account Type
        <select type="number" id="acc_type" name="account_type" required>
            <option value=1>Checking</option>
            <option value=2>Savings</option>
        </select>
    </label>
    <input type="submit" name="created" value="Open Account"/>
</form>

<?php
function next_avail_account_num($id, $count) {
    $left10 = (string)$id;
    while (strlen($left10) < 10) {
        $left10 = '0' . $left10;
    }

    $right2 = (string)$count;
    while (strlen($right2) < 2) {
        $right2 = '0' . $right2;
    };
    $returnstr = $left10 . $right2;
    return ($returnstr);
}

if(isset($_POST["created"])){
    $account_type = $_POST["account_type"];
    $user_id = $_SESSION["user"]["id"];
    $user_account_count = $_SESSION['user']['accounts_count'];

    $account_number = next_avail_account_num($user_id,$user_account_count);

    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    if(!empty($account_number) && !empty($account_type)){
        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt = $db->prepare("INSERT INTO Accounts (account_number, user_id, account_type) VALUES (:account_number, :user_id, :account_type)");

        $result = $stmt->execute(array(
            ":account_number" => $account_number,
            ":user_id" => $user_id,
            ":account_type" => $account_type
        ));

        //Error Handling
        $e = $stmt->errorInfo();
        if($e[0] != "00000"){
            echo var_export($e, true);
        }
        else{
            if ($result){
                $query = file_get_contents("queries/INCREMENT_USERS_ACCOUNT_COUNT.sql");
                $stmt = $db->prepare($query);
                $result = $stmt->execute(array(
                    ":user_id" => $user_id,
                ));
                $_SESSION['user']['accounts_count'] += 1;
                switch($account_type) {
                    case 1:
                        #######
                        echo'case is checking <br>';
                        #######
                        try {
                            $query = file_get_contents("queries/GET_WORLD_BALANCE.sql");
                            $stmt = $db->prepare($query);
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                        #######
                        echo $result[0] . '<br>';
                        #######
                        #######
                        echo $result . '<br>';
                        #######

                        $world_total = $result[0] - 5;

                        #######
                        echo $world_total . "<br>";
                        #######

                        $query = file_get_contents("queries/OPEN_CHECKING_PROMOTION.sql");
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute(array(
                            ":init_account" => $account_number,
                            ":new_world_total" => $world_total
                        ));

                        #######
                        echo'Transactions should be set. <br>';
                        #######

                        $query = file_get_contents("queries/UPDATE_TRANSACTION_BALANCES.sql");
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute(array(
                            ":account_number_src" => $account_number,
                            ":account_number_dest" => '000000000000',
                            ":new_balance_src" => 5,
                            ":new_balance_dest" => $world_total
                        ));

                        #######
                        echo'Account balances updated. <br>';
                        #######

                        break;
                    case 2:
                        #######
                        echo'case is savings <br>';
                        #######
                        $query = file_get_contents("queries/GET_WORLD_BALANCE.sql");
                        $stmt = $db->prepare($query);
                        $world_total = $stmt->execute();
                        $world_total -= 5;

                        $query = file_get_contents("queries/OPEN_SAVINGS_PROMOTION.sql");
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute(array(
                            ":init_account" => $account_number,
                            ":new_world_total" => $world_total
                        ));

                        #######
                        echo'Transactions should be set. <br>';
                        #######

                        $query = file_get_contents("queries/UPDATE_TRANSACTION_BALANCES.sql");
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute(array(
                            ":account_number_src" => $account_number,
                            ":account_number_dest" => '000000000000',
                            ":new_balance_src" => 5,
                            ":new_balance_dest" => $world_total
                        ));

                        #######
                        echo'Account balances updated. <br>';
                        #######

                        break;
                }

                echo "Successfully created account: " . $account_number . "<br>";
                echo "We are happy to serve you.";
            }
            else{
                echo "Error creating account";
            }
        }
    }
    else{
        echo "Account number and Account type must not be empty.";
    }
}
?>
