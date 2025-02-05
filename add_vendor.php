<?php
$servername = "localhost";
$username = "u729491923_hardware";
$password = "Hardware@0527";
$database = "u729491923_hardware";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendor_name = $_POST['vendor_name'];
    $contact = $_POST['contact'];
    $hardware_type = $_POST['hardware_type'];

    $sql = "INSERT INTO vendors (vendor_name, contact, hardware_type) VALUES ('$vendor_name', '$contact', '$hardware_type')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New vendor added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Vendor</title>
    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            font-family: 'Arial', sans-serif;
            display: flex;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="container p-6 ml-64">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Add Vendor</h1>
        <div class="bg-white p-8 rounded-lg shadow-md max-w-lg w-full">
            <form method="POST" action="">
                <div>
                    <label class="block text-sm font-semibold text-gray-700" for="vendor_name">Vendor Name</label>
                    <input type="text" name="vendor_name" class="w-full py-2.5 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700" for="contact">Contact</label>
                    <input type="text" name="contact" class="w-full py-2.5 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700" for="hardware_type">Hardware Type</label>
                    <input type="text" name="hardware_type" class="w-full py-2.5 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg text-lg hover:bg-blue-600 mt-6">Add Vendor</button>
            </form>
            <div class="text-center mt-6">
                <a href="vendor_list.php" class="bg-green-500 text-white py-3 px-6 rounded-lg text-lg hover:bg-green-600">View List of Vendors</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>
