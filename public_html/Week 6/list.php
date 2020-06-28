<?php
require("common.inc.php");
$query = file_get_contents(__DIR__ . "/queries/SELECT_ALL_ACCOUNTS.sql");
if(isset($query) && !empty($query)){
    try{
        $stmt = getDB()->prepare($query);
        //No arguments, since results not being filtered.
        $stmt->execute();

        //fetchAll() over fetch(), due to plural results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    catch (Exception $e){
        echo $e->getMessage();
    }
}
?>

<?php if(isset($results)):?>
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
    <p>Your query did not return results</p>
<?php endif;?>