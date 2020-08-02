<?php
include("header.php");
?>
    <h4>Edit Field</h4>
<?php
if($logged_in){
    if (isset($_GET['reset_menu'])) {
        switch ($_GET['reset_menu']) {
            case 1:
                echo "Reset User";
                break;
            case 2:
                echo "Reset Password";
                break;
            case 3:
                echo "Reset Email";
                break;
            default:
                echo "There is an error";
                break;
        };

    }
} else {
    include 'login.php';
}
?>