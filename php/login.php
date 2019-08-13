<?php
require 'dblogin.php';
include 'header.php';

if (isset($_SESSION['userId'])) {
    echo'<label class="login-status">You are logged in </label>'
    . '<a href="http://ec2-3-17-143-15.us-east-2.compute.amazonaws.com/ecommerce/php/shop.php">browse our shop</a>';
    exit();
} else {

// if posted using login button in login.php
    if (isset($_POST['login'])) {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            header("Location: login.php?status=emptyfields");
            exit();
        } else {
            $sql = "SELECT id, username, password FROM user_record WHERE username = ?";
            $stmt = mysqli_prepare($db_server, $sql);
            $stmt->bind_param("s", $_POST['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($_POST['password'], $row['password']);
                if ($pwdCheck == false) {
                    header("Location: login.php?status=invalidentry");
                    exit();
                } else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION['signed_in'] = true;
                    $_SESSION['userId'] = $row['id'];
                    $_SESSION['user_name'] = $row['email'];
                    header("Location: ../index.php?status=loginsuccessful");
                    exit();
                } else {
                    header("Location: login.php?status=unknownerror");
                    exit();
                }
            }
        }
        // if posted using login button in header.php
    }
    // take user back to login.php if no post received
}
?>

<?php
// error checker
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'invalidentry') {
        echo '<p class="status_failed">Invalid Email or Password</p>';
    } else if ($_GET['status'] == 'unknownerror') {
        echo '<p class="status_failed">Unknown Error Occurred</p>';
    } else if ($_GET['status'] == 'emptyfields') {
        echo '<p class="status_failed">Please Enter Email and Password</p>';
    } else if ($_GET['status'] == 'notsignedin') {
        echo '<p class="status_failed">Please Sign in to access the shop</p>';
    } else if ($_GET['status'] == 'successful') {
        echo '<p class="status_successful">Successfully Registered</p>';
    }
}
?>
<!DOCTYPE html>

<div class="login_register">
    <form action="http://ec2-3-17-143-15.us-east-2.compute.amazonaws.com/ecommerce/php/login.php" method="post">
        <h1>Welcome back</h1>
        <p>Login</p>
        <span>new user? <a href="http://ec2-3-17-143-15.us-east-2.compute.amazonaws.com/ecommerce/php/register.php">register here</a></span>
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="login" value="Login">
    </form>
</div>


