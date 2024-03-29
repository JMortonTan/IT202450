<?php
$search = "";
$order = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
    $order = $_POST["order"];
}
?>

<form method="POST">
    <label for="Account_Type">Account Type
        <select type="number" id="search" name="search" required>
            <option value=1>Checking</option>
            <option value=2>Savings</option>
            <option value=3>Loan</option>
            <option selected="selected" value=0>All</option>
        </select>
    </label>
    <label for="Order">Balance Sort
        <select type="text" id="order" name="order" required>
            <option selected="selected" value="ASC">Ascending</option>
            <option value="DESC">Descending</option>
        </select>
    </label>
    <input type="submit" value="Search"/>
</form>
<?php
if(isset($search) && $search != 0) {
    require("common.inc.php");
    switch($order):
        case 'ASC':
            $query = file_get_contents(__DIR__ . "/queries/SEARCH_TABLE_TRANSACTIONS_DATE_DESC.sql");
            break;
        case 'DESC':
            $query = file_get_contents(__DIR__ . "/queries/SEARCH_TABLE_ACCOUNTS_ACCOUNTTYPE_DESC.sql");
            break;
    endswitch;
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            $stmt->execute([":search"=>$search]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
if(isset($search) && $search == 0) {
    require("common.inc.php");
    switch($order):
        case 'ASC':
            $query = file_get_contents(__DIR__ . "/queries/SELECT_ALL_ACCOUNTS_ASC.sql");
            break;
        case 'DESC':
            $query = file_get_contents(__DIR__ . "/queries/SELECT_ALL_ACCOUNTS_DESC.sql");
            break;
    endswitch;
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            $stmt->execute();
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
        <th>Balance</th>
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
                <td>
                    <?php echo get($row, "balance");?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php else:?>
    <p>Your query did not return results</p>
<?php endif;?>