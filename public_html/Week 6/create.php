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
    <input type="submit" name="created" value="Open Account"/>
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
if(isset($_POST["created"])){
    $account_number = $_POST["account_number"];
    $account_type = $_POST["account_type"];
    if(!empty($account_number) && !empty($account_type)){
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
            if ($result){
                echo "Successfully created account: " . $account_number;
                echo "Account Type: " . $account_type;
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