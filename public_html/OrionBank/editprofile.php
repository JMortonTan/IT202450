<?php
include("header.php");
?>
    <h4>Edit User</h4>
<?php
if($logged_in){
    print '<p>What would you like to edit today?</p>';
    echo '<form method="POST">
            <label for="edit_profile">Edit Profile
            <select type="number" id="acc_type" name="account_type" required>
                <option value=1>Username</option>
                <option value=2>Password</option>
                <option value=3>Email</option>
            </select>
            </label>
            <input type="submit" name="user_edit" value="Edit"/>
           </form>';

    if(isset($_POST["user_edit"])) {

    }
} else {
    include 'login.php';
}
?>