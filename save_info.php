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
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $sql = "INSERT INTO user_info (name, email, password, phone) VALUES ('$name', '$email', '$password', '$phone')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    //After saving user info, send an email.
        $to = "nettanyonas@gmail.com"; //My email address
        $subject = "New Sign-up Information";
        $message = "A new user has signed up to the Fancy Surprise Planner website with the following information:\n\nName: $name\nEmail: $email\nPhone: $phone";
        mail($to, $subject, $message);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    
?>
