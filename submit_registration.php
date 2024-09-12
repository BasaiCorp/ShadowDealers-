<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shadow_dealers";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$user = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];
$confirm_pass = $_POST['confirm_password'];

// Basic validation
if (empty($user) || empty($email) || empty($pass) || empty($confirm_pass)) {
    echo "All fields are required.";
    exit();
}

if ($pass !== $confirm_pass) {
    echo "Passwords do not match.";
    exit();
}

// Hash password
$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $email, $hashed_pass);

// Execute the statement
if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>