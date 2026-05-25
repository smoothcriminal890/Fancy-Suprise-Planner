<?php
session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    echo json_encode(["error" => "Unauthorized access. Please log in."]);
    exit();
}
echo json_encode([
    "name" => $_SESSION['name'],
    "email" => $_SESSION['email']
]);
?>