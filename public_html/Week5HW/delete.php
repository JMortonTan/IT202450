<form method="POST">
    <label for="Account">Account Number
        <input type="text" id="acc_number" name="account_number" />
    </label>
    <input type="submit" name="delete" value="Delete Account"/>
</form>

<?php
if(isset($_POST["delete"])){
    $account_number = $_POST["account_number"];

    if(!empty($account_number)){
        require("common.inc.php");
        $db = getDB();
        try {
            $stmt = $db->prepare("DELETE from Accounts where account_number=:account_number");
            $result = $stmt->execute(array(
                ":account_number" => $account_number
            ));

            //Error Handling
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                if ($result) {
                    echo "Successfully deleted account: " . $account_number;
                } else {
                    echo "Error deleting account";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "You must indicate your account number";
    }
}
?>