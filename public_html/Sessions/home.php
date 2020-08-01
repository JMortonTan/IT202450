<?php
include("header.php");
//session_start();
?>
<h4>Home</h4>
<?php
echo "Welcome to IT202 Bank!" . $_SESSION["user"]["email"];
?>

