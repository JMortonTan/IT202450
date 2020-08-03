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
                <label for='first_name'>New First Name: 
                    <input type='first_name' name='first_name'>
                </label>
                <input type='submit' name='reset' value='Reset'>
                </form>";
                $query = file_get_contents("queries/UPDATE_USER_FIRSTNAME.sql");
                break;
            case 2:
                echo "Enter new Lastname</br>
                <form method='post'>
                <label for='last_name'>New Last Name: 
                    <input type='last_name' name='last_name'>
                </label>
                <input type='submit' name='reset' value='Reset'>
                </form>";
                $query = file_get_contents('queries/UPDATE_USER_LASTNAME.sql');
                break;
            case 3:
                echo "Enter new Password</br>
                <form method='post'>
                <label for='password'>New Password: 
                    <input type='password' name='password'>
                </label>
                <input type='submit' name='reset' value='Reset'>
                </form>";
                $query = file_get_contents('queries/UPDATE_USER_FIRSTNAME.sql');
                break;
            case 4:
                echo "Enter new Email</br>
                <form method='post'>
                <label for='email'>New Email: 
                    <input type='email' name='email'>
                </label>
                <input type='submit' name='reset' value='Reset'>
                </form>";
                $query = file_get_contents('queries/UPDATE_USER_EMAIL.sql');
                break;
            default:
                echo "There is an error</br>";
                break;
        };

        if(isset($_POST['reset'])){
            echo $query;
            echo $_POST['last_name'];
        }

    }
} else {
    include 'login.php';
}
?>