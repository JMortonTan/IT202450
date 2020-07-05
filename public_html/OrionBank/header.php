<?php
session_start()
?>
<head>
    <title>Orion Bank</title>
    <link rel="stylesheet" type="text/css" href="style.css"
</head>

<nav class="menu">
    <img class="logo" src="media/Logo.png" alt="Orion Bank">
    <?php
    echo '<a href="home.php">Home</a>';
    if(isset($_SESSION)):
        echo '<li><a href="logout.php">Logout</a>';
    endif;
    if(!isset($_SESSION)):
        echo '<a href="register.php">Registration</a>';
    endif;
    ?>
</nav>

<?php
require("config.php");
?>
