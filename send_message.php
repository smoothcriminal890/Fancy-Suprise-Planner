<?php
header('Content-Type: application/json; charset=utf-8');

// Basic validation and DB save for package messages
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_info";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

$package_name = isset($_POST['package_name']) ? trim($_POST['package_name']) : '';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$event_date = isset($_POST['event_date']) ? trim($_POST['event_date']) : '';
$location = isset($_POST['location']) ? trim($_POST['location']) : '';
$details = isset($_POST['details']) ? trim($_POST['details']) : '';

// Allow missing sender info (account credentials may arrive separately)
if ($name === '') { $name = 'From Account'; }
if ($phone === '') { $phone = 'N/A'; }

// Create table if not exists
$createSql = "CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  package_name VARCHAR(255),
  sender_name VARCHAR(255),
  phone VARCHAR(100),
  email VARCHAR(255),
  event_date DATE NULL,
  location VARCHAR(500),
  details TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$conn->query($createSql);

$stmt = $conn->prepare("INSERT INTO messages (package_name, sender_name, phone, email, event_date, location, details) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sssssss', $package_name, $name, $phone, $email, $event_date, $location, $details);
$ok = $stmt->execute();

if ($ok) {
    // Send notification to Formspree (optional)
    $formspreeEndpoint = "https://formspree.io/f/xlgvdrnb"; // replace with your own if needed
    $payload = [
        'package' => $package_name,
        'name' => $name,
        '_replyto' => $email ?: 'no-reply@example.com',
        '_subject' => "New package message: $package_name",
        'message' => "Name: $name\nPhone: $phone\nEmail: $email\nDate: $event_date\nLocation: $location\n\nDetails:\n$details"
    ];

    $ch = curl_init($formspreeEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'Accept: application/json', 'Content-Type: application/json' ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_exec($ch);
    curl_close($ch);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'DB insert failed']);
}

$stmt->close();
$conn->close();
?>
