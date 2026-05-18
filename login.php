<?php
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
        echo "Login successful!";
    } 
    else {
        echo "<script>alert('Invalid email or password. Please try again.'); window.location.href='login.html';</script>";
    }
    $conn->close();
?>