<?php
include_once(__DIR__."/partials/header.partial.php");
?>
<h4>Home</h4>
<?php
echo '<p>Welcome to Orion Bank!</p>';
if($logged_in){
    echo $_SESSION["user"]["email"];
    include 'accounts.php';
} else {
    include 'login.php';
}
?>