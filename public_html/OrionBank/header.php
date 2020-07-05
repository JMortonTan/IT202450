<head>
    <title>Orion Bank</title>
    <link rel="stylesheet" type="text/css" href="style.css"
</head>

<?php
require("config.php");
?>

<nav id="menu">
    <?php
    ?>
    <ul>
        <li><img src="media/Logo.png" id="logo" alt="Orion Bank"></li>
        <li><a href="home.php">Home</a></li>
        <li><a href="accounts.php">My Accounts</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Registration</a></li>
        <?php if(isset($_SESSION)):?>
            <li><a href="accounts.php">My Accounts</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif;?>
    </ul>
</nav>
