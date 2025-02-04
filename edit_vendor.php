<?php
include 'db.php';

if (isset($_GET['id'])) {
    $vendor_id = $_GET['id'];
    
    
    $query = "SELECT * FROM vendors WHERE id = $vendor_id";
    $result = mysqli_query($conn, $query);
    $vendor = mysqli_fetch_assoc($result);
    
    if (!$vendor) {
        die("Vendor not found.");
    }
} else {
    die("Vendor ID is required.");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendor_name = $_POST['vendor_name'];
    $contact = $_POST['contact'];
    $hardware_type = $_POST['hardware_type'];

    $update_query = "UPDATE vendors SET vendor_name = '$vendor_name', contact = '$contact', hardware_type = '$hardware_type' WHERE id = $vendor_id";
    if (mysqli_query($conn, $update_query)) {
        header("Location: vendor_list.php"); 
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vendor</title>
    <style>
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .container {
            width: 80%;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-left: 270px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 1rem;
            color: #333;
            margin-bottom: 8px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            color: #333;
            background-color: #f8f9fa;
            box-sizing: border-box;
        }
        button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 14px 22px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="container">
    <h2>Edit Vendor</h2>
    <form method="POST" action="edit_vendor.php?id=<?php echo $vendor_id; ?>">
        <div class="form-group">
            <label for="vendor_name">Vendor Name:</label>
            <input type="text" name="vendor_name" value="<?php echo $vendor['vendor_name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="contact">Contact:</label>
            <input type="text" name="contact" value="<?php echo $vendor['contact']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="hardware_type">Hardware Type:</label>
            <input type="text" name="hardware_type" value="<?php echo $vendor['hardware_type']; ?>" required>
        </div>
        
        <button type="submit">Update Vendor</button>
    </form>
</div>

</body>
</html>
