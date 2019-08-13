<?php
include 'header.php';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'successful') {
        header("Location: login.php?status=successful");
    } else if ($_GET['status'] == 'emailtaken') {
        echo '<p class="status_failed">Email is taken</p>';
    }
}
?>
<div class="login_register">
    <h1>Welcome</h1>
    <p>Register</p>
    <span>existing user? <a href="login.php">login here</a></span>
    <form action="adduser.php" method="post">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="conf_password" placeholder="Repeat Password">
        <input type="submit" name="submit" value="Register">
    </form>
</div>