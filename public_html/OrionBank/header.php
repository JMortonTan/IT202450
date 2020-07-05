<head>
    <title>Bank</title>
    <link rel="stylesheet" type="text/css" href="style.css"
</head>
<nav id="menu">
    <ul>
        <li><img src="media/Logo.png" alt="Orion Bank"></li>
        <li><a href="home.php">Home</a></li>
        <li><a href="accounts.php">My Accounts</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Registration</a></li>
        <?php if(isset($_SESSION)):?>
        <li><a href="logout.php">Login</a></li>
        <?php endif;?>
    </ul>
</nav>
<?php
    require("config.php");
    session_start();
?>

