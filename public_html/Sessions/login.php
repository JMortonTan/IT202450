<?php
include("header.php")
?>
<h4>Login</h4>
<form method="POST">
    <label for="email">Email
    <input type="email" name="email"/>
    </label>
    <label for="email">Password
    <input type="password" name="password"/>
    </label>
    <input type="submit" name="login" value="Login"/>
</form>

<?php
session_start();
//echo var_export($_GET, true);
//echo var_export($_POST, true);
//echo var_export($_REQUEST, true);

//Show user confirm
if(isset($_POST["login"])){
    if(isset($_POST["password"]) && isset($_POST["email"])){
        $password = $_POST["password"];
        $email = $_POST["email"];

        //require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("SELECT * FROM Users where email = :email LIMIT 1");
            $stmt->execute(array(
                    ":email" => $email
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result){
                    $rpassword = $result["password"];
                    if(password_verify($password, $rpassword)){
                        echo "<div>Passwords matched! You are technically logged in!</div>";
                        $_SESSION["user"] = array(
                            "id"=>$result["id"],
                            "email"=>$result["email"],
                            "first_name"=>$result["first_name"],
                            "last_name"=>$result["last_name"]
                        );
                        echo var_export($_SESSION, true);
                        header("Location: home.php");
                    }
                    else{
                        echo "<div>Your username or password was invalid. Check your input and try again.</div>";
                    }
                }
                else{
                    echo "<div>Your username or password was invalid. Check your input and try again.</div>";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
}

?>
