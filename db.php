<?php
$servername = "localhost"; 
$username = "u729491923_hardware"; 
$password = "Hardware@0527"; 
$database = "u729491923_hardware"; 


// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>