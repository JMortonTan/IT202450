<?php
include("header.php");
?>

<?php

echo "<h4>" . $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] . "'s Checking Account</h4>";

if (isset($_GET['account'])) {
    $account_number = $_GET['account'];
    $query = file_get_contents("queries/SELECT_TABLE_ACCOUNTS_ACCOUNTNUM.sql");
    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    try {
        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt = $db->prepare($query);
        $stmt->execute([":account_number" => $account_number]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if (isset($result)) {
        $this_account = $result[0];
        echo "<h5>Account Number: " . $result["account_number"] . "</h5>";
        echo "<h5>Account Type: ";
        switch ($result["account_type"]) {
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
        echo "</h5></br>";

        echo "
            <form method='post'>
            <label for='startdate'>Start Date:</label>
            <input type='date' id='startdate' name='startdate'>
            <label for='enddate'>End Date:</label>
            <input type='date' id='enddate' name='enddate'>
            <label for='result_num'>Results</label>
            <select name='result_num' id='result_num'>
                <option value='10'>10</option>
                <option value='25'>25</option>
                <option value='100'>100</option>
                <option value='All' selected>All</option>
            </select>
            <input type='submit' name='submit' value='Submit'>
            </form>
            ";

        if (isset($_POST["submit"])) {
            ##########
            echo "SUBMIT POST";
            ##########
            if (isset($_POST["startdate"]) && isset($_POST["enddate"]) && isset($_POST["result_num"])) {
                ##########
                echo "ITSALL SET";
                ##########
                $startdate = $_POST["startdate"];
                $enddate = $_POST["enddate"];
                $result_num = $_POST["result_num"];
                $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
                try {
                    ##########
                    echo "ATTEMPTING QUERY";
                    ##########
                    $db = new PDO($connection_string, $dbuser, $dbpass);
                    $query = file_get_contents("queries/SEARCH_TABLE_TRANSACTIONS_DATE_DESC.sql");
                    $stmt = $db->prepare($query);
                    $stmt->execute(array(
                        ":account_number" => $account_number,
                        ":startdate" => $startdate,
                        ":enddate" => $enddate
                    ));

                    $results = $stmt->fetch(PDO::FETCH_ASSOC);

                    ##########
                    echo $stmt;
                    ##########

                    $e = $stmt->errorInfo();

                    if (isset($results) && count($results) > 0) {
                        ##########
                        echo "YA GOT RESULTS";
                        ##########
                        echo "
                            <table>
                                <th>Account Source</th>
                                <th>Account Destination</th>
                                <th>Amount</th>
                                <th>Memo</th>
                                <th>Date</th>";
                        foreach ($results as $row) {
                            echo "<tr><td>";
                            echo $row["account_src"];
                            echo "</td><td>";
                            echo $row["account_dest"];
                            echo "</td><td>";
                            echo $row["amount"];
                            echo "</td><td>";
                            echo $row["date"];
                            echo "</td><td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }

                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
    }
}
?>