<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db_connection.php'; // Include database connection

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: register.php?error=Passwords do not match");
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        header("Location: index.php?success=Registration successful! Please log in.");
        exit();
    } else {
        header("Location: register.php?error=Registration failed. Try again.");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
