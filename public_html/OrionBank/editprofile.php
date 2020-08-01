<?php
include("header.php");
?>
<h4>Edit Profile</h4>
<form method="POST">
    <label for="email">Email
        <input type="email" name="email"/>
    </label>
    <label for="password">Password
        <input type="password" name="password"/>
    </label>
    <label for="password">Confirm Password
        <input type="password" name="cpassword"/>
    </label>
    <br>
    <label for="name">First Name
        <input type="firstname" name="firstname"/>
    </label>
    <label for="name">Last Name
        <input type="lastname" name="lastname"/>
    </label>
    <input type="submit" name="register" value="Register"/>
</form>

<?php
if(isset($_POST["register"])){
    if(isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["email"])){

        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $email = $_POST["email"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];

        $validFlag = true;

        //Validate Input
        if("" == trim($_POST['email'])){
            echo "You need to provide an email.";
            $validFlag = false;
        }
        if("" == trim($_POST['password'])){
            echo "You need to provide a password.";
            $validFlag = false;
        }
        if("" == trim($_POST['cpassword'])){
            echo "You need to confirm the password.";
            $validFlag = false;
        }

        if($validFlag && $password == $cpassword){
            //echo "<div>Passwords Match</div>";
            //require("config.php");
            $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
            try{
                $db = new PDO($connection_string, $dbuser, $dbpass);
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $db->prepare("INSERT INTO Users (email, password, first_name, last_name) VALUES(:email, :password, :firstname, :lastname)");
                $stmt->execute(array(
                        ":email" => $email,
                        ":password" => $hash, //$password -> saving hash not password
                        ":firstname" => $firstname,
                        ":lastname" => $lastname
                ));
                $e = $stmt->errorInfo();
                if($e[0] != "00000"){
                    echo var_export($e, true);
                }
                else{
                    echo "<div>Successfully registered!</div>";
                }
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
            }
        elseif($validFlag) {
            echo "<div>Passwords don't match</div>";
        }
    }
}

?>
