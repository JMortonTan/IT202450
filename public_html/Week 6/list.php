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
    <ul>
        <?php foreach($results as $row):?>
            <li>
                <?php echo get($row, "account_number")?>
                <?php echo get($row, "account_type");?>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>Your query did not return results</p>
<?php endif;?>