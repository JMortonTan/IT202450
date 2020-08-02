<?php
include("header.php");
?>
    <h4>Edit User</h4>
<?php
if($logged_in){
    print '<p>What would you like to edit today?</p>';
    echo '<form method="POST">
            <label for="edit_profile">Edit Profile
            <select type="number" id="reset_menu" name="reset_menu" required>
                <option value=1>First Name</option>
                <option value=2>Last Name</option>
                <option value=3>Password</option>
                <option value=4>Email</option>
            </select>
            </label>
            <input type="submit" name="user_edit" value="Edit"/>
           </form>';

    if(isset($_POST["user_edit"])) {
        $reset_menu = $_POST["reset_menu"];
        header("Location: resetfield.php?reset_menu=$reset_menu");
    }
} else {
    include 'login.php';
}
?>