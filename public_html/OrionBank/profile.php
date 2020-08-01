<?php
include("header.php");
?>
    <h4>Profile</h4>
<?php
echo '<p>Welcome to Orion Bank!</p>';
if($logged_in){
    print $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"];
    echo '<table>
            <tr>
                <td>Firstname</td>
                <td>' . $_SESSION['user']['first_name'] .'
                </td>
            </tr>
            <tr>
                <td>Lastname</td>
                <td>' . $_SESSION['user']['last_name'] .'
            </tr>
            <tr>
                <td>Email</td>
                <td><td>' . $_SESSION['user']['email'] .'</td>
            </tr>
            </table>';
} else {
    include 'login.php';
}
?>