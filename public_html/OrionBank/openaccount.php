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
function next_avail_account_num($id, $count) {
    $left10 = (string)$id;
    while (strln($left10) < 10) {
        $left10 = '0' . $left10;
    }

    $right2 = (string)$count;
    while (strln($right2) < 2) {
        $right2 = '0' . $right2;
    };

    return ($left10 . $right2);
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
