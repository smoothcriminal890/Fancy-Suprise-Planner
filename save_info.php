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
    //Handling user input and saving to database
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "INSERT INTO user_info (name, email) VALUES ('$name', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
?>
