<?php
include 'header.php';
require 'dblogin.php';
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['conf_password'];
    // if all fields are empty take user back to html page and prompt error
    if (empty($email) || empty($password) || empty($password2)) {
        header("Location: ../php/register.php?status=emptyfields");
        exit();
        // if username includes special chars send back to prev page and prompt error
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../php/register.php?status=invalidemail");
        exit();
        // if password doesn't match return error
    } else if ($password != $password2) {
        header("Location: ../php/register.php?status=unmatchedpassword");
        exit();
    } else {
        $sql1 = "SELECT username FROM user_record WHERE username = ?";
        if (!mysqli_prepare($db_server, $sql1)) {
            header("Location: ../php/register.php?status=sqlerror");
            exit();
        } else {
            $stmt1 = mysqli_prepare($db_server, $sql1);
            $stmt1->bind_param("s", $email);
            $stmt1->execute();
            $stmt1->store_result();
            $resultCheck = $stmt1->num_rows();
            echo $resultCheck;
            if ($resultCheck > 0) {
                header("Location: ../php/register.php?status=emailtaken");
                exit();
            } else {
                $sql2 = "INSERT INTO user_record (username, password) VALUES (?, ?)";
                $stmt2 = $db_server->prepare($sql2);
                $hasedPwd = password_hash($password, PASSWORD_DEFAULT);

                $stmt2->bind_param("ss", $email, $hasedPwd);
                if ($stmt2->execute()) {
                    header("Location: register.php?status=successful");
                } else {
                    'Failed to register: ' . $stmt2->errno . $stmt2->error;
                }
            }
        }
    }
}
?>


