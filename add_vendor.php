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
    <title>Add Vendor</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2f3b52;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
            top: 0;
            left: 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #3e4c69;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #556a91;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-left: 270px; 
            transition: margin-left 0.3s;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
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
            transition: border-color 0.3s;
        }
        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
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
        #result-message {
            margin-top: 20px;
            text-align: center;
        }
        #result-message p {
            padding: 12px;
            border-radius: 6px;
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        .view-vendors-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            text-align: center;
            color: #fff;
            background-color: #28a745;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        .view-vendors-link:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>


<?php include 'sidebar.php'; ?>

<div class="container">
    
    <h1>Add Vendor</h1>
    
   
    <form method="POST" action="add_vendor.php">
        <div class="form-group">
            <label for="vendor_name">Vendor Name:</label>
            <input type="text" name="vendor_name" required>
        </div>
        
        <div class="form-group">
            <label for="contact">Contact:</label>
            <input type="text" name="contact" required>
        </div>
        
        <div class="form-group">
            <label for="hardware_type">Hardware Type:</label>
            <input type="text" name="hardware_type" required>
        </div>
        
        <button type="submit">Add Vendor</button>
        
        
    </form>
    <a href="vendor_list.php" class="view-vendors-link">View List of Vendors</a>

    
</div>

</body>
</html>
