<?php
include("header.php");
?>
<h4>New Loan</h4>

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
$search = $_SESSION["user"]["id"];
if(isset($search)) {
    $query = file_get_contents("queries/LISTBYID.sql");
    if (isset($query) && !empty($query)) {
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try {
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare($query);
            $stmt->execute([":search" => $search]);
            //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if(isset($results) && count($results) > 0) {
    $valid_accounts = [];
    foreach ($results as $row) {
        if ($row['account_type'] == 1 || $row['account_type'] == 2) {
            $valid_accounts.add($row['account_number']);
        }
    }

    echo "Select an account";
}
else {
    echo "
    <p>You must have a checking or savings account to take out a loan.</p><br>
    <a href=\"openaccount.php\">Open an account today!</a>
    ";
}
?>
