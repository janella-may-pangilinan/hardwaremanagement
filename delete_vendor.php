<?php
include 'db.php';

if (isset($_GET['id'])) {
    $vendor_id = $_GET['id'];

    
    $delete_query = "DELETE FROM vendors WHERE id = $vendor_id";
    if (mysqli_query($conn, $delete_query)) {
        header("Location: vendor_list.php"); 
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    die("Vendor ID is required.");
}
?>
