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

        if (is_null($phone) || trim($phone) === "") {
            $phone = "N/A";
        }

        // Send a notification email via Formspree when a new user signs up.
        $formspreeEndpoint = "https://formspree.io/f/xlgvdrnb"; 
        $notificationData = [
            'name' => $name,
            '_replyto' => $email,
            '_subject' => "New signup on Fancy Surprise Planner",
            'message' => "A new user has signed up.\n\nName: $name\nEmail: $email\nPhone: $phone"
        ];

        $ch = curl_init($formspreeEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
        curl_exec($ch);
        curl_close($ch);
    }
     else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
?>
