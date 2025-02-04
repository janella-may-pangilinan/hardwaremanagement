<?php

$servername = "localhost"; // Palitan kung ibang server gamit mo
$username = "u729491923_hardware"; // Default sa XAMPP
$password = "Hardware@0527"; // Default sa XAMPP (walang password)
$database = "u729491923_hardware"; // Siguraduhin na ito ang tamang database name


// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
