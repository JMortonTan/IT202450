<?php
include("header.php");
?>
<h4>Home</h4>
<?php
echo '<p>Welcome to Orion Bank!</p>';
if($logged_in){
    print $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"];
} else {
    include 'login.php';
}

echo '<p>Our running promotions:</p>
      <ul><li>Get $5 when you open a new checking account!</li>
      <li>Get $5 when you open a new savings account!</li></ul>';
?>