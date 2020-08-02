<?php
include("header.php");
?>
    <h4>Edit Field</h4>
<?php
if($logged_in){
    if (isset($_GET['reset_menu'])) {
        switch ($_GET['reset_menu']) {
            case 1:
                echo "Enter new Firstname</br>
                <form method='post'>
                <label for='first_name'>New First Name: </label>
                <input type='submit' name='reset' value='Reset'>
                </form>";

                $query = file_get_contents("queries/UPDATE_USER_FIRSTNAME.sql");
                break;
            case 2:
                echo "Enter new Lastname</br>";
                break;
            case 3:
                echo "Enter new Password</br>";
                break;
            case 4:
                echo "Enter new Email</br>";
                break;
            default:
                echo "There is an error</br>";
                break;
        };

        if(isset($_POST['reset'])){
            echo $query;
        }

    }
} else {
    include 'login.php';
}
?>