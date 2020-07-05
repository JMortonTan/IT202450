<?php
include("header.php");
?>
<h4>My Accounts</h4>

<?php
print $_SESSION["user"]["id"];
$search = $_SESSION["user"]["id"];

if(isset($search)) {
    echo "The first if statement is executing  <br>";
    require("includes/common.inc.php");
    $query = file_get_contents("/queries/SEARCH_TABLE_ACCOUNTS_ACCOUNTID.sql");
    print $query;
    if (isset($query) && !empty($query)) {
        echo "The query statement is executing  <br>";
        try {
            $stmt = getDB()->prepare($query);
            //Note: With a LIKE query, we must pass the % during the mapping
            $stmt->execute([":search"=>$search]);
            //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "The try statement is executing  <br>";
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
