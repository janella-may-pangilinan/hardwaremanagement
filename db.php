<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; // Palitan kung ibang server gamit mo
$username = "root"; // Default sa XAMPP
$password = ""; // Default sa XAMPP (walang password)
$database = "hardware"; // Siguraduhin na ito ang tamang database name


// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
