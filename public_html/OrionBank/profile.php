<?php
include("header.php");
?>
    <h4>My Profile</h4>
<?php
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
                    <td>' . $_SESSION['user']['email'] .'</td>
                </tr>
                </table>';
        echo '<a href="editprofile.php">Edit</a>';

    } else {
        include 'login.php';
    }
?>