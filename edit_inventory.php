<?php
// edit_inventory.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hardware";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get asset ID
$id = $_GET['id'];

// Fetch asset details for editing
$sql = "SELECT * FROM hardware_assets WHERE id = $id";
$result = $conn->query($sql);
$asset = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_asset'])) {
    // Update asset details
    $asset_name = $_POST['asset_name'];
    $serial_number = $_POST['serial_number'];
    $model = $_POST['model'];
    $brand = $_POST['brand'];
    $status = $_POST['status'];
    $location = $_POST['location'];
    $assigned_user = $_POST['assigned_user'];
    $warranty_info = $_POST['warranty_info'];

    $sql_update = "UPDATE hardware_assets SET asset_name='$asset_name', serial_number='$serial_number', model='$model', 
                  brand='$brand', status='$status', location='$location', assigned_user='$assigned_user', 
                  warranty_info='$warranty_info' WHERE id=$id";
    
    if ($conn->query($sql_update) === TRUE) {
        echo "Hardware asset updated successfully!";
        header("Location: inventory.php"); // Redirect back to inventory list
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KIT.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Inventory</title>
</head>
<body class="bg-gray-50 font-sans">

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="ml-64 p-6">
    <h1 class="text-4xl font-bold text-gray-900 mb-6">Edit Hardware Asset</h1>

    <!-- Edit Asset Form -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <form method="POST">
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700" for="asset_name">Asset Name</label>
                    <input type="text" name="asset_name" id="asset_name" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="<?php echo $asset['asset_name']; ?>" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700" for="serial_number">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="<?php echo $asset['serial_number']; ?>" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700" for="model">Model</label>
                    <input type="text" name="model" id="model" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="<?php echo $asset['model']; ?>" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700" for="brand">Brand</label>
                    <input type="text" name="brand" id="brand" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="<?php echo $asset['brand']; ?>" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700" for="status">Status</label>
                    <select name="status" id="status" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="1" <?php echo ($asset['status'] == 1) ? 'selected' : ''; ?>>✔ Available</option>
                        <option value="2" <?php echo ($asset['status'] == 2) ? 'selected' : ''; ?>>🔧 Under Maintenance</option>
                        <option value="3" <?php echo ($asset['status'] == 3) ? 'selected' : ''; ?>>❌ Out of Service</option>
                        <option value="4" <?php echo ($asset['status'] == 4) ? 'selected' : ''; ?>>🔄 Under Disposal</option>
                    </select>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700" for="location">Location</label>
                    <input type="text" name="location" id="location" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="<?php echo $asset['location']; ?>" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700" for="assigned_user">Assigned User</label>
                    <input type="text" name="assigned_user" id="assigned_user" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="<?php echo $asset['assigned_user']; ?>" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700" for="warranty_info">Warranty Information</label>
                    <input type="text" name="warranty_info" id="warranty_info" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="<?php echo $asset['warranty_info']; ?>" required>
                </div>
            </div>
            <button type="submit" name="update_asset" class="mt-6 w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition">Update Asset</button>
        </form>
    </div>
</div>

</body>
</html>
