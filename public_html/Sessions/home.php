<?php
    include("header.php");
    //session_start();
    echo "Welcome to IT202 Bank, " . $_SESSION["user"]["email"];
?>
<h4>Home</h4>
<?php
echo "Welcome! " . $_SESSION["user"]["email"];
?>