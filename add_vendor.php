<?php
session_start(); 
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendor_name = $_POST['vendor_name'];
    $contact = $_POST['contact'];
    $hardware_type = $_POST['hardware_type'];

    $query = "INSERT INTO vendors (vendor_name, contact, hardware_type) VALUES ('$vendor_name', '$contact', '$hardware_type')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Vendor added successfully."; 
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn); 
    }

    header("Location: vendor_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Vendor</title>
</head>
<body class="bg-gray-100 flex">
    
    <?php include 'sidebar.php'; ?>
    
    <div class="container mx-auto p-6 ml-64">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Add Vendor</h1>
        
        <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
            <form method="POST" action="add_vendor.php" class="space-y-4">
                <div>
                    <label for="vendor_name" class="block text-sm font-semibold text-gray-700">Vendor Name</label>
                    <input type="text" name="vendor_name" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label for="contact" class="block text-sm font-semibold text-gray-700">Contact</label>
                    <input type="text" name="contact" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label for="hardware_type" class="block text-sm font-semibold text-gray-700">Hardware Type</label>
                    <input type="text" name="hardware_type" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-md">Add Vendor</button>
            </form>
            <a href="vendor_list.php" class="block text-center text-white bg-green-500 hover:bg-green-600 mt-4 py-2 rounded-md">View List of Vendors</a>
        </div>
    </div>
    
</body>
</html>
