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
        echo "Account created successfully! Redirecting to login page...";
        echo "<script>setTimeout(function(){ window.location.href = 'login.html'; }, 3000);</script>";
        if(is_null($phone)==true){
            $phone = "N/A";
        }
    }
     else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
?>
