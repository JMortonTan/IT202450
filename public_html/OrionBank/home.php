<?php
    include("header.php");
?>
<h4>Home</h4>
<?php
    echo "Welcome to Orion Bank!" . $_SESSION["user"]["email"];

    if(isset($_SESSION)):
        include("accounts.php");
    else:
        include("login.php");
    endif;

?>