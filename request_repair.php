<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hardware_id = $_POST['hardware_id'];
    $issue = $_POST['issue'];

    $sql = "INSERT INTO maintenance_requests (hardware_id, issue, status) VALUES ('$hardware_id', '$issue', 'pending')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Repair request submitted!'); window.location.href='repair_list.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
