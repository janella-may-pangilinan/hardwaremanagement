<?php
include 'db.php'; 

$query = "SELECT * FROM vendors";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor List</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #eef2f3, #8e9eab);
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
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #007bff;
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 5px;
            background-color: #f8f9fa;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #d1e7ff;
        }
        .actions {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>


<?php include 'sidebar.php'; ?>

<div class="container">
    <h2>Vendor List</h2>
    
    <table>
        <tr>
            <th>Vendor Name</th>
            <th>Contact</th>
            <th>Hardware Type</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['vendor_name']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['hardware_type']; ?></td>
                <td class="actions">
                    <a href="edit_vendor.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="delete_vendor.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
