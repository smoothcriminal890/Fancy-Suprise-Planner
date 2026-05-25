<?php
session_start();
    //Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_info";
//Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
//Delete user account
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $sql = "DELETE FROM user_info WHERE name='$name' AND email='$email'";
    if ($conn->query($sql) === TRUE) {
        session_destroy();
        echo "<script>alert('Account deleted successfully.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Error deleting account: " . $conn->error . "'); window.location.href='logged_in.html';</script>";
    }