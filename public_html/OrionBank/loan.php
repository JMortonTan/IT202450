<?php
include("header.php");
?>
<h4>Home</h4>
<?php
echo '<p>Welcome to Orion Bank!</p>';
if($logged_in){
    print $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"];
} else {
    include 'login.php';
}
?>