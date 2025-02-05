<?php
include('db.php'); 
include('sidebar.php');

$successMessage = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hardware_name = $_POST['hardware_name'];
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];
    $purchase_date = $_POST['purchase_date'];
    $warranty_duration_months = $_POST['warranty_duration_months'];
    $serial_number = $_POST['serial_number'];
    $warranty_contact = $_POST['warranty_contact'];

    
    $warranty_expiry_date = date('Y-m-d', strtotime("$purchase_date +$warranty_duration_months months"));

    if (isset($_POST['id']) && $_POST['id'] > 0) {
       
        $id = $_POST['id'];
        $sql = "UPDATE hardware_warranties SET hardware_name = ?, manufacturer = ?, model = ?, purchase_date = ?, warranty_duration_months = ?, warranty_expiry_date = ?, serial_number = ?, warranty_contact = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssisssi', $hardware_name, $manufacturer, $model, $purchase_date, $warranty_duration_months, $warranty_expiry_date, $serial_number, $warranty_contact, $id);

        if ($stmt->execute()) {
            $successMessage = 'Hardware updated successfully.';
        } else {
            $successMessage = 'Error updating hardware: ' . $stmt->error;
        }
    } else {
        
        $sql = "INSERT INTO hardware_warranties (hardware_name, manufacturer, model, purchase_date, warranty_duration_months, warranty_expiry_date, serial_number, warranty_contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssisss', $hardware_name, $manufacturer, $model, $purchase_date, $warranty_duration_months, $warranty_expiry_date, $serial_number, $warranty_contact);

        if ($stmt->execute()) {
            $successMessage = 'Hardware added successfully.';
        } else {
            $successMessage = 'Error: ' . $stmt->error;
        }
    }
}


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    
    $sql = "DELETE FROM hardware_warranties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $delete_id);

    if ($stmt->execute()) {
        $successMessage = 'Hardware deleted successfully.';
    } else {
        $successMessage = 'Error deleting hardware: ' . $stmt->error;
    }

    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


$current_date = date('Y-m-d');


$sql = "SELECT * FROM hardware_warranties";
$result = $conn->query($sql);


$edit_data = [];
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM hardware_warranties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $edit_id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty & Expiry Tracker</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        
        body, h1, h2, table, form {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        
        body {
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            color: #333;
            line-height: 1.6;
            margin: 0px;
            margin-left: 270px;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #3c3c3c;
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }

        h2 {
            color: #2e3a8c;
            margin-top: 40px;
            margin-bottom: 20px;
            margin-left: 180px;
            font-size: 1.5em;
            text-align: center;
        }

        
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 0 auto;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #45a049;
        }

        
        table {
            width: 85%;
            margin-left: 250px;
            margin-top: 40px;
            border-collapse: collapse;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #3c3c3c;
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

       
            .alert {
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background-color: #28a745; 
                color: white;
                padding: 15px 30px;
                font-size: 18px;
                border-radius: 5px;
                z-index: 1000;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                width: auto;
                min-width: 250px;
                text-align: center;
                opacity: 0;
                animation: showAlert 3s forwards;
            }

            
            .alert.error {
                background-color: #f44336; 
            }

           
            @keyframes showAlert {
                0% {
                    opacity: 0;
                    transform: translateX(-50%) translateY(-20px);
                }
                50% {
                    opacity: 1;
                }
                100% {
                    opacity: 0;
                    transform: translateX(-50%) translateY(-20px);
                }
            }


        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #e02f2f;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>Hardware Warranty & Expiry Tracker</h1>

    
    <?php if ($successMessage): ?>
        <div class="alert"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo isset($edit_data['id']) ? $edit_data['id'] : ''; ?>">
        
        <label for="hardware_name">Hardware Name:</label>
        <input type="text" id="hardware_name" name="hardware_name" value="<?php echo isset($edit_data['hardware_name']) ? $edit_data['hardware_name'] : ''; ?>" required><br>

        <label for="manufacturer">Manufacturer:</label>
        <input type="text" id="manufacturer" name="manufacturer" value="<?php echo isset($edit_data['manufacturer']) ? $edit_data['manufacturer'] : ''; ?>"><br>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model" value="<?php echo isset($edit_data['model']) ? $edit_data['model'] : ''; ?>"><br>

        <label for="purchase_date">Purchase Date:</label>
        <input type="date" id="purchase_date" name="purchase_date" value="<?php echo isset($edit_data['purchase_date']) ? $edit_data['purchase_date'] : ''; ?>" required><br>

        <label for="warranty_duration_months">Warranty Duration (Months):</label>
        <input type="number" id="warranty_duration_months" name="warranty_duration_months" min="1" value="<?php echo isset($edit_data['warranty_duration_months']) ? $edit_data['warranty_duration_months'] : ''; ?>" required><br>

        <label for="serial_number">Serial Number:</label>
        <input type="text" id="serial_number" name="serial_number" value="<?php echo isset($edit_data['serial_number']) ? $edit_data['serial_number'] : ''; ?>"><br>

        <label for="warranty_contact">Warranty Contact:</label>
        <input type="text" id="warranty_contact" name="warranty_contact" value="<?php echo isset($edit_data['warranty_contact']) ? $edit_data['warranty_contact'] : ''; ?>"><br>

        <button type="submit"><?php echo isset($edit_data['id']) ? 'Update Hardware' : 'Add Hardware'; ?></button>
    </form>

    <h2>List of All Hardware with Warranty Expiry Dates</h2>

    
    <table>
        <thead>
            <tr>
                <th>Hardware Name</th>
                <th>Manufacturer</th>
                <th>Model</th>
                <th>Purchase Date</th>
                <th>Warranty Duration (Months)</th>
                <th>Warranty Expiry Date</th>
                <th>Serial Number</th>
                <th>Warranty Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            while ($row = $result->fetch_assoc()) {
                $expiry_date = $row['warranty_expiry_date'];
            ?>
                <tr>
                    <td><?php echo $row['hardware_name']; ?></td>
                    <td><?php echo $row['manufacturer']; ?></td>
                    <td><?php echo $row['model']; ?></td>
                    <td><?php echo $row['purchase_date']; ?></td>
                    <td><?php echo $row['warranty_duration_months']; ?></td>
                    <td><?php echo $expiry_date; ?></td>
                    <td><?php echo $row['serial_number']; ?></td>
                    <td><?php echo $row['warranty_contact']; ?></td>
                    <td>
                        <a href="?edit_id=<?php echo $row['id']; ?>">
                            <button class="edit-btn">Edit</button>
                        </a>
                        <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this hardware?');">
                            <button class="delete-btn">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</body>
</html>
