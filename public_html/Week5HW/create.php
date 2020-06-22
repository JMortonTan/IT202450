<form method="POST">
    <label for="Account">Account Number
        <input type="text" id="acc_number" name="account_number" />
    </label>
    <label for="Account_Type">Account Type
        <input type="number" id="acc_type" name="account_type" />
    </label>
    <input type="submit" name="created" value="Open Account"/>
</form>
<div>
    **Account Type need to be automatically generated
    ...Perhaps using hash based on user_id?  Perhaps not secure?

    In Account Type:
    Enter 1 for Checking
    Enter 2 for Savings
    Enter 3 for Loan
    **Need to change to dropdown menu**
</div>

<?php
if(isset($_POST["created"])){
    $account_number = $_POST["account_number"];
    $account_type = $_POST["account_type"];
    if(!empty($name) && !empty($quantity)){
        require("common.inc.php");
        $db = getDB();

        $stmt = $db->prepare("INSERT INTO Accounts (account_number, account_type) VALUES (:account_number, :account_type)");
        $result = $stmt->execute(array(
            ":account_number" => $account_number,
            ":account_type" => $account_type
        ));
        //Error Handling
        $e = $stmt->errorInfo();
        if($e[0] != "00000"){
            echo var_export($e, true);
        }
        else{
            echo var_export($result, true);
            if ($result){
                echo "Successfully created account: " . $account_number;
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