<?php
include("header.php");

print $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] . "'s Accounts";
?>

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

if(isset($results) && count($results) > 0){
    echo "<p>Here are your results:</p>
    <table>
        <th>Account #</th>
        <th>Type</th>
        <th>Balance</th>
        <th>Date Created</th>
        <th>Actions</th>";
        foreach($results as $row) {
            echo "<tr>
                <td>";
            echo $row["account_number"];
            echo "</td>
                <td>";
            $type_holder = $row["account_type"];;
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
            };
            echo "</td>
                <td>";
                echo $row["balance"];
                echo "</td>
                <td>";
                echo $row["opened_date"];
                echo "</td>
                <td>";
            switch ($type_holder) {
                case 1:
                    echo "<a href='checking.php?account=$row[account_number]'>Enter</a>";
                    break;
                case 2:
                    echo "<a href='savings.php?account=$row[account_number]'>Enter</a>";
                    break;
                case 3:
                    echo "<a href='loan.php?account=$row[account_number]'>Enter</a>";
                    break;
            };
                echo "<td>
            </tr>";
        }
    echo"</table>";
}
else {
    echo "
    <p>You have not opened an account!</p><br>
    <a href=\"openaccount.php\">Open an account today!</a>
    ";
}
?>