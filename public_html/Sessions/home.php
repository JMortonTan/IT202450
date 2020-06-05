<?php
session_start();
echo "Welcome to IT202 Bank, " . $_SESSION["user"]["email"];
?>

<a href="logout.php">Logout Now!</a>
