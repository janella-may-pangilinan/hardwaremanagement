<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    
    // Insert the data into the database
    $query = "INSERT INTO hardware (name, location, status, created_at) VALUES ('$name', '$location', '$status', NOW())";
    if (mysqli_query($conn, $query)) {
        echo "New hardware added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
