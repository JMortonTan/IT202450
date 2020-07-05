<?php
require_once (__DIR__."/includes/common.inc.php");
$logged_in = Common::is_logged_in(false);
?>

<head>
    <title>Orion Bank</title>
    <link rel="stylesheet" type="text/css" href="style.css"
</head>
<nav class="menu">
    <ul>
        <li><img src="media/Logo.png" class="logo"></li>
        <li><a href="home.php">Home</a></li>
        <?php if($logged_in):?>
            <li><a href="accounts.php">My Accounts</a></li>
            <li><a href="openaccount.php">Open</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
        <?php if(!$logged_in):?>
            <li><a href="register.php">Registration</a></li>
        <?php endif; ?>

    </ul>
</nav>
<?php
    require("config.php");
    session_start();
?>

