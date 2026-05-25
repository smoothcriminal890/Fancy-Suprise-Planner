<?php
session_start();
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_info";
// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
//Identifying and verifying login credentials
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user_info WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        echo "<script>
            localStorage.setItem('userName', '" . addslashes($row['name']) . "');
            localStorage.setItem('userEmail', '" . addslashes($row['email']) . "');
            window.location.href='logged_in.html';
        </script>";
    } 
    else {
        echo "<script>alert('Invalid email or password. Please try again.'); window.location.href='login.html';</script>";
    }
    $conn->close();
?>