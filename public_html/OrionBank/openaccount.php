<?php
include("header.php");
?>
<h4>Open Account</h4>

<form method="POST">
    <label for="Account_Type">Account Type
        <select type="number" id="acc_type" name="account_type" required>
            <option value=1>Checking</option>
            <option value=2>Savings</option>
            <option value=3>Loan</option>
        </select>
    </label>
    <input type="submit" name="created" value="Open Account"/>
</form>

<?php
########
echo "enter php <br>";
########

function next_avail_account_num($id, $count) {
    ########
    echo "generating account num <br>";
########
    $left10 = (string)$id;
    while (strlen($left10) < 10) {
        $left10 = '0' . $left10;
    }

    $right2 = (string)$count;
    while (strlen($right2) < 2) {
        $right2 = '0' . $right2;
    };
    $returnstr = $left10 . $right2;
    ########
    echo $returnstr . " <br>";
########
    return ($returnstr);
}

if(isset($_POST["created"])){
    ########
    echo "Attempt post <br>";
########
    $account_type = $_POST["account_type"];
    $user_id = $_SESSION["user"]["id"];
    $user_account_count = $_SESSION['user']['accounts_count'];

    $account_number = next_avail_account_num($user_id,$user_account_count);

    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    if(!empty($account_number) && !empty($account_type)){
        ########
        echo "Prepare statement <br>";
        ########

        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt = $db->prepare("INSERT INTO Accounts (account_number, user_id, account_type) VALUES (:account_number, :user_id, :account_type)");

        $result = $stmt->execute(array(
            ":account_number" => $account_number,
            ":user_id" => $user_id,
            ":account_type" => $account_type
        ));

        ########
        echo "executed statement <br>";
        ########
        //Error Handling
        $e = $stmt->errorInfo();
        if($e[0] != "00000"){
            echo var_export($e, true);
        }
        else{
            if ($result){
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
