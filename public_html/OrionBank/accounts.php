<?php
include("header.php");
?>
<h4>My Accounts</h4>

<?php
$search = $_SESSION["user"]["id"];
if(isset($search)) {
    $query = file_get_contents("queries/SEARCH_TABLE_ACCOUNTS_ACCOUNTID.sql");
    if (isset($query) && !empty($query)) {
        try {
            echo "The prep execute is executing  <br>";
            $stmt = (new Common)->getDB()->prepare($query);
            //Note: With a LIKE query, we must pass the % during the mapping
            echo "The try execute is executing  <br>";
            $stmt->execute([":search"=>$search]);
            //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
            echo "The fetch statement is executing  <br>";
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>

<?php if(isset($results) && count($results) > 0):?>
    <p>Here are your results:</p>
    <table>
        <th>Account #</th>
        <th>Type</th>
        <?php foreach($results as $row):?>
            <tr>
                <td>
                    <?php echo get($row, "account_number");?>
                </td>
                <td>
                    <?php
                    $type_holder = get($row, "account_type");
                    switch ($type_holder) {
                        case 1:
                            echo "Checking";
                            break;
                        case 2:
                            echo "Savings";
                            break;
                        case 3:
                            echo "Loan";
                            break;
                        default:
                            echo "There is an error";
                            break;
                    };?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php else:?>
    <p>You have not opened an account!</p><br>
    <a href="openaccount.php">Open an account today!</a>
<?php endif;?>
