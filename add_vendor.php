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
<style>
    body 
    {
        font-family: Arial, sans-serif;
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
            padding-top: 30px;
    }
    
</style> 
<body>
    
    <?php include 'sidebar.php'; ?>
    
    <div class="container mx-auto p-8 ml-64">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Add Vendor</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form method="POST" action="add_vendor.php" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700" for="vendor_name">Vendor Name</label>
                    <input type="text" name="vendor_name" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700" for="contact">Contact</label>
                    <input type="text" name="contact" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700" for="hardware_type">Hardware Type</label>
                    <input type="text" name="hardware_type" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>
                
                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg text-lg hover:bg-blue-600">Add Vendor</button>
            </form>
        </div>
        
        <a href="vendor_list.php" class="mt-6 inline-block bg-green-500 text-white py-3 px-6 rounded-lg text-lg hover:bg-green-600">View List of Vendors</a>
    </div>
    
</body>
</html>
