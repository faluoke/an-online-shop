<?php
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Forum</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
        <link rel="stylesheet" href="http://ec2-3-17-143-15.us-east-2.compute.amazonaws.com/ecommerce/css/style.css">
    </head>
    <body>
        <main>
            <nav>
                <div class = "topnav">
                <a href = "http://ec2-3-17-143-15.us-east-2.compute.amazonaws.com/ecommerce/index.php">Home</a>
                <a href = "http://ec2-3-17-143-15.us-east-2.compute.amazonaws.com/ecommerce/php/shop.php">Shop</a>
                <div class = "login-container">
                
                <?php
                // display login status
                if (isset($_SESSION['userId'])) {
                    if (isset($_SESSION['userId'])) {
                        echo'<label class="login-status">Welcome ' . $_SESSION['user_name'] . '</label>';
                    } else {
                        echo'<label class="login-status">You are logged out</label>';
                    }
                    if (isset($_GET['status'])) {
                        if ($_GET['status'] == 'loginsuccessful') {
                            echo '<label class="status_successful login-status">Login Successful</label>';
                        }
                    }
                    echo'
                            <form action="http://ec2-3-17-143-15.us-east-2.compute.amazonaws.com/ecommerce/php/logout.php" method="post">
                            <input type="submit" name="logout" value="Logout">
                        </form>';
                } else {
                    echo'
                        <form action="http://ec2-3-17-143-15.us-east-2.compute.amazonaws.com/ecommerce/php/login.php" method="post">
                            <input type="text" name="email" placeholder="Email">
                            <input type="password" name="password" placeholder="Password">
                            <input type="submit" name="login" value="Login">
                        </form>
                        <a href="http://ec2-3-17-143-15.us-east-2.compute.amazonaws.com/ecommerce/php/register.php">Signup</a>';
                }
                ?>
                </div>
                </div>
            </nav>
        </main>
    </div>
</body>
</html>
