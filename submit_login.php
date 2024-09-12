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
$email = $_POST['email'];
$pass = $_POST['password'];

// Basic validation
if (empty($email) || empty($pass)) {
    echo "All fields are required.";
    exit();
}

// Prepare and bind
$stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashed_pass);
$stmt->fetch();

if ($stmt->num_rows > 0) {
    // Verify password
    if (password_verify($pass, $hashed_pass)) {
        echo "Login successful!";
        // Set session or redirect to a protected page
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No account found with that email.";
}

// Close connection
$stmt->close();
$conn->close();
?>