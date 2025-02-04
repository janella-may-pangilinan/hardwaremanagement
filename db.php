<?php
$host = 'localhost';
$username = 'u729491923_hardware'; 
$password = 'Hardware@0527'; 
$dbname = 'u729491923_hardware'; 

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
