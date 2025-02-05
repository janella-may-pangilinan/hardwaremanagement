<?php
include 'db.php';
include 'sidebar.php';
// Asset Depreciation Tracking
function calculateDepreciation($purchase_price, $years) {
    $depreciation_rate = 0.2; // Example: 20% per year
    $current_value = $purchase_price * pow((1 - $depreciation_rate), $years);
    return round($current_value, 2);
}

// Add Asset Function
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_asset'])) {
    $asset_name = $_POST['asset_name'];
    $purchase_price = $_POST['purchase_price'];
    $purchase_date = $_POST['purchase_date'];

    // Sanitize inputs
    $asset_name = $conn->real_escape_string($asset_name);
    $purchase_price = $conn->real_escape_string($purchase_price);
    $purchase_date = $conn->real_escape_string($purchase_date);

    // Insert asset into the database
    $sql = "INSERT INTO assets (asset_name, purchase_price, purchase_date) VALUES ('$asset_name', '$purchase_price', '$purchase_date')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Asset added successfully.";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Disposal Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_disposal'])) {
    $asset_id = $_POST['asset_id'];
    $reason = $_POST['reason'];

    // Sanitize inputs
    $asset_id = $conn->real_escape_string($asset_id);
    $reason = $conn->real_escape_string($reason);

    // Insert disposal request
    $sql = "INSERT INTO disposal_requests (asset_id, reason, status) VALUES ('$asset_id', '$reason', 'Pending')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Disposal request submitted successfully.";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Approve Disposal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve_disposal'])) {
    $request_id = $_POST['request_id'];

    // Sanitize input
    $request_id = $conn->real_escape_string($request_id);

    // Update disposal request status to 'Approved'
    $sql = "UPDATE disposal_requests SET status='Approved' WHERE id='$request_id'";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Disposal request approved.";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Fetch Assets for Depreciation and Disposal
$sql_assets = "SELECT * FROM assets";
$result_assets = $conn->query($sql_assets);

// Fetch Disposal Requests
$sql_disposals = "SELECT * FROM disposal_requests";
$result_disposals = $conn->query($sql_disposals);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Management System</title>
    <style>
        body {
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

        h2, h3 {
            text-align: center;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        input, button {
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        input[type="number"], input[type="text"], input[type="date"] {
            width: 100%;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        .alert {
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .alert.success {
            background-color: #4CAF50;
            color: white;
        }

        .alert.error {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
   
    <div class="container">
        <h2>Asset Depreciation & Disposal Management</h2>

        <!-- Display Success/Failure Messages -->
        <?php if (isset($success_message)) { ?>
            <div class="alert success"><?php echo $success_message; ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="alert error"><?php echo $error_message; ?></div>
        <?php } ?>

        <!-- Asset Depreciation Calculator -->
        <div>
            <h3>Asset Depreciation Calculator</h3>
            <form method="post">
                Purchase Price: <input type="number" name="purchase_price" required>
                Years: <input type="number" name="years" required>
                <button type="submit" name="calculate">Calculate Depreciation</button>
            </form>
            <?php
            if (isset($_POST['calculate'])) {
                $purchase_price = $_POST['purchase_price'];
                $years = $_POST['years'];
                echo "<p><strong>Current Value: </strong>" . calculateDepreciation($purchase_price, $years) . "</p>";
            }
            ?>
        </div>

        <!-- Add New Asset Form -->
        <div>
            <h3>Add New Asset</h3>
            <form method="post">
                Asset Name: <input type="text" name="asset_name" required><br>
                Purchase Price: <input type="number" name="purchase_price" required><br>
                Purchase Date: <input type="date" name="purchase_date" required><br>
                <button type="submit" name="add_asset">Add Asset</button>
            </form>
        </div>

        <!-- Assets List -->
        <div>
            <h3>Assets List</h3>
            <table>
                <tr><th>Asset ID</th><th>Asset Name</th><th>Purchase Price</th><th>Purchase Date</th><th>Depreciation</th><th>Request Disposal</th></tr>
                <?php while ($row = $result_assets->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['asset_name']; ?></td>
                        <td><?php echo $row['purchase_price']; ?></td>
                        <td><?php echo $row['purchase_date']; ?></td>
                        <td><?php echo calculateDepreciation($row['purchase_price'], (date('Y') - date('Y', strtotime($row['purchase_date'])))); ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="asset_id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="reason" placeholder="Reason for disposal" required>
                                <button type="submit" name="request_disposal">Request Disposal</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Disposal Requests -->
        <div>
            <h3>Disposal Requests</h3>
            <table>
                <tr><th>Request ID</th><th>Asset ID</th><th>Reason</th><th>Status</th><th>Approve</th></tr>
                <?php while ($row = $result_disposals->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['asset_id']; ?></td>
                        <td><?php echo $row['reason']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <?php if ($row['status'] == 'Pending') { ?>
                                <form method="post">
                                    <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="approve_disposal">Approve</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>