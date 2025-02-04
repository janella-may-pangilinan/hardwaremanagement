<?php
// delete_inventory.php

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

// Delete asset
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM hardware_assets WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Hardware asset deleted successfully!";
        header("Location: inventory.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
