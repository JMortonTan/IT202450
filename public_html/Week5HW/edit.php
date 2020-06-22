<form method="POST">
    <label for="Account">Account Number
        <input type="text" id="acc_number" name="account_number" />
    </label>
    <label for="Account_Type">Account Type
        <select type="number" id="acc_type" name="account_type">
            <option value=1>Checking</option>
            <option value=2>Savings</option>
            <option value=3>Loan</option>
        </select>
    </label>
    <input type="submit" name="edited" value="Edit Account"/>
</form>
<div>
    **Account Type need to be automatically generated<br>
    ...Perhaps using hash based on user_id?  Perhaps not secure?<br>
    <br>
    In Account Type:<br>
    Enter 1 for Checking<br>
    Enter 2 for Savings<br>
    Enter 3 for Loan<br>

    **Validate input, Account Number 12 integers,<br>
    **Validate input, Account type 1-2-3.<br>
    <br><br>
</div>

<?php
if(isset($_POST["edited"])){
    $account_number = $_POST["account_number"];
    $account_type = $_POST["account_type"];
    
    //Check if the account number exists. If not, return.
    if(isset($_GET["account_number"])){
        $account_number = $_GET["account_number"];
        $stmt = $db->prepare("SELECT * FROM Accounts where account_number = :account_number");
        $stmt->execute([":account_number"=>$account_number]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $ready_flag = true;
    }
    else{
        echo "The account number you have provided is invalid.";
    }

    if(!empty($account_type) && !empty($account_number)){
        require("common.inc.php");
        $db = getDB();

        $stmt = $db->prepare("UPDATE Accounts set account_type=:account_type where account_number=:account_number");
        $result = $stmt->execute(array(
            ":account_type" => $account_type,
        ));


        //Error Handling
        $e = $stmt->errorInfo();
        if($e[0] != "00000"){
            echo var_export($e, true);
        }
        else{
            if ($result){
                echo "Successfully edited account: " . $account_number;
                echo "Account Type is now: " . $account_type;
            }
            else{
                echo "Error updating account";
            }
        }
    }
    else{
        echo "Account number and Account type must not be empty.";
    }
}
?>