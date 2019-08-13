<?php
    $db_hostname = "127.0.0.1";
    $db_database = "login_system";
    $db_username = "root";
    $db_password = "FLKisme312";
    
    $db_server = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    
    if($db_server->connect_errno) {
        die("Cannot Connect to Database: " . $db_server->connect_errno);
    }
?>
