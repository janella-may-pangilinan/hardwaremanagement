<?php
// delete_inventory.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hardware";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
