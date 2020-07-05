<head>
    <title>Orion Bank</title>
    <link rel="stylesheet" type="text/css" href="style.css"
</head>

<nav class="menu">
    <img class="logo" src="media/logo.png" alt="Orion Bank">
    <?php
    echo '<li><a href="home.php">Home</a></li>';
    if(isset($_SESSION)):
        echo '<li><a href="logout.php">Logout</a></li>';
    endif;
    if(!isset($_SESSION)):
        echo '<li><a href="register.php">Registration</a></li>';
    endif;
    ?>
</nav>

<?php
require("config.php");
?>
