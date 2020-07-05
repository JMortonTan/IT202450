<?php
include("header.php");
?>
<h4>Home</h4>
<?php
echo '<p>Welcome to Orion Bank!</p>';
if($logged_in){
    echo $_SESSION["user"]["email"];
    echo 'You are logged in';
} else {
    include 'login.php';
}
?>