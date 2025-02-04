<?php
// inventory.php

$servername = "localhost"; // Palitan kung ibang server gamit mo
$username = "u729491923_hardware"; // Default sa XAMPP
$password = "Hardware@0527"; // Default sa XAMPP (walang password)
$database = "u729491923_hardware"; // Siguraduhin na ito ang tamang database name


// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add new hardware asset
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_asset'])) {
    $asset_name = $_POST['asset_name'];
    $serial_number = $_POST['serial_number'];
    $model = $_POST['model'];
    $brand = $_POST['brand'];
    $status = $_POST['status'];
    $location = $_POST['location'];
    $assigned_user = $_POST['assigned_user'];
    $warranty_info = $_POST['warranty_info'];

    // Check if the asset already exists based on Serial Number
    $check_sql = "SELECT * FROM hardware_assets WHERE serial_number = '$serial_number'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('This serial number already exists and cannot be added again.');</script>";
    } else {
        $sql = "INSERT INTO hardware_assets (asset_name, serial_number, model, brand, status, location, assigned_user, warranty_info) 
                VALUES ('$asset_name', '$serial_number', '$model', '$brand', '$status', '$location', '$assigned_user', '$warranty_info')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New hardware asset added successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Fetch hardware assets
$sql = "SELECT * FROM hardware_assets";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KIT.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Inventory Management</title>
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
        .heading {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2d3748;
        }
        .form-input {
            border-radius: 8px;
            border: 1px solid #cbd5e0;
            padding: 10px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }
        .form-submit {
            background-color: #38b2ac;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1.2rem;
            margin-top: 20px;
            cursor: pointer;
        }
        .form-submit:hover {
            background-color: #319795;
        }
        .table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .table th {
            background-color: #edf2f7;
            font-weight: bold;
            color: #2d3748;
        }
        .table tbody tr:hover {
            background-color: #f7fafc;
        }
        .action-links a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: 600;
        }
        .edit-btn {
            background-color: #38b2ac;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .edit-btn:hover {
            background-color: #319795;
        }
        .delete-btn {
            background-color: #e53e3e;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c53030;
        }
        .action-links a:hover {
            color: #2b6cb0;
        }

        /* Sidebar styling */
        .sidebar {
            width: 250px;
            background-color: #2d3748;
            padding: 20px;
            color: white;
            position: fixed;
            height: 100vh;
        }

        /* Hide add asset form by default */
        .add-form {
            display: none;
        }
    </style>
    <script>
        function toggleAddForm() {
            var form = document.getElementById('addAssetForm');
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="container p-6 ml-64">
    <h1 class="heading">Inventory Management</h1>
    
    <!-- Button to Toggle Add New Asset Form -->
    <button onclick="toggleAddForm()" class="form-submit">Add New Hardware Asset</button>

    <!-- Add New Asset Form -->
    <div id="addAssetForm" class="add-form mt-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Add New Hardware Asset</h2>
        <form method="POST">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold" for="asset_name">Asset Name</label>
                    <input type="text" name="asset_name" id="asset_name" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold" for="serial_number">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold" for="model">Model</label>
                    <input type="text" name="model" id="model" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold" for="brand">Brand</label>
                    <input type="text" name="brand" id="brand" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold" for="status">Status</label>
                    <select name="status" id="status" class="form-input" required>
                        <option value="1">✔ Available</option>
                        <option value="2">🔧 Under Maintenance</option>
                        <option value="3">❌ Out of Service</option>
                        <option value="4">🔄 Under Disposal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold" for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold" for="assigned_user">Assigned User</label>
                    <input type="text" name="assigned_user" id="assigned_user" class="form-input" required>
                </div>
                <div>
    <label class="block text-sm font-semibold" for="warranty_info">Warranty Information</label>
    <input type="date" name="warranty_info" id="warranty_info" class="form-input" required>
</div>

            </div>
            <button type="submit" name="add_asset" class="form-submit">Add Asset</button>
        </form>
    </div>

    <!-- Display Hardware Assets -->
    <div class="mt-8">
        <table class="table">
            <thead>
                <tr>
                    <th>Asset Name</th>
                    <th>Serial Number</th>
                    <th>Model</th>
                    <th>Brand</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Assigned User</th>
                    <th>Warranty</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['asset_name']; ?></td>
                    <td><?php echo $row['serial_number']; ?></td>
                    <td><?php echo $row['model']; ?></td>
                    <td><?php echo $row['brand']; ?></td>
                    <td>
                        <?php
                        switch ($row['status']) {
                            case 1: echo "✔ Available"; break;
                            case 2: echo "🔧 Nasa Maintenance"; break;
                            case 3: echo "❌ Out of Service"; break;
                            case 4: echo "🔄 Under Disposal"; break;
                        }
                        ?>
                    </td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['assigned_user']; ?></td>
                    <td><?php echo $row['warranty_info']; ?></td>
                    <td class="action-links">
                        <a href="edit_inventory.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a> |
                        <a href="delete_inventory.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this asset?')" class="delete-btn">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
