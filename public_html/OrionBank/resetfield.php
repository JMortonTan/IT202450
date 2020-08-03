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
                    <input type='first_name' name='input'>
                </label>
                <input type='submit' name='reset' value='Reset'>
                </form>";
                $query = file_get_contents("queries/UPDATE_USER_FIRSTNAME.sql");
                break;
            case 2:
                echo "Enter new Lastname</br>
                <form method='post'>
                <label for='last_name'>New Last Name: 
                    <input type='last_name' name='input'>
                </label>
                <input type='submit' name='reset' value='Reset'>
                </form>";
                $query = file_get_contents('queries/UPDATE_USER_LASTNAME.sql');
                break;
            case 3:
                echo "Enter new Password</br>
                <form method='post'>
                <label for='password'>New Password: 
                    <input type='password' name='input'>
                </label>
                <input type='submit' name='reset' value='Reset'>
                </form>";
                $query = file_get_contents('queries/UPDATE_USER_FIRSTNAME.sql');
                break;
            case 4:
                echo "Enter new Email</br>
                <form method='post'>
                <label for='email'>New Email: 
                    <input type='email' name='input'>
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
            $input = $_POST['input'];

            if($GET_['reset_menu'] == 3){
                $input = password_hash($input, PASSWORD_BCRYPT);
            }

            $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
            try {
                $db = new PDO($connection_string, $dbuser, $dbpass);
                $stmt = $db->prepare($query);
                $stmt->execute([
                        ":input" => $input,
                        ":user_id" => $_SESSION["user"]["id"]
                ]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            echo "Success! Log back in!</br>";

            session_unset();
            session_destroy();
            echo "You have been logged out";
            echo var_export($_SESSION, true);
            //get session cookie and delete/clear it for this session
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                //clones then destroys since it makes it's lifetime
                //negative (in the past)
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
}
?>
        }

    }
} else {
    include 'login.php';
}
?>