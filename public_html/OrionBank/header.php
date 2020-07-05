<head>
    <title>Orion Bank</title>
    <link rel="stylesheet" type="text/css" href="style.css"
</head>

<img src="media/Logo.png" id="logo" alt="Orion Bank">
<nav id="menu">
    <?php
    ?>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="register.php">Registration</a></li>
        <?php if(isset($_SESSION)):?>
            <li><a href="logout.php">Logout</a></li>
        <?php endif;?>
    </ul>
</nav>

<?php
require("config.php");
session_start();
?>
