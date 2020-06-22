<form method="POST">
    <label for="Account">Account Number
        <input type="text" id="acc_number" name="account_number" />
    </label>
    <label for="Account_Type">Account Type
        <input type="number" id="acc_type" name="account_type" />
    </label>
    <input type="submit" name="created" value="Create Thing"/>
</form>

<?php
require("common.inc.php");
$db = getDB();
//example usage, change/move as needed
$stmt = $db->prepare("SELECT * FROM Things");
$stmt->execute();
?>