<?php
include 'db.php';
include 'sidebar.php';
// Handling repair request submission (CREATE)
if (isset($_POST['submit_request'])) {
    $hardware_id = $_POST['hardware_id'];
    $issue = $_POST['issue'];
    $insert_query = "INSERT INTO maintenance_requests (hardware_id, issue, status) VALUES ('$hardware_id', '$issue', 'Pending')";
    mysqli_query($conn, $insert_query);
}

// Handling technician assignment (UPDATE)
if (isset($_POST['assign_technician'])) {
    $request_id = $_POST['request_id'];
    $technician = $_POST['technician'];
    $update_query = "UPDATE maintenance_requests SET technician = '$technician', status = 'In Progress' WHERE id = '$request_id'";
    mysqli_query($conn, $update_query);
}

// Handling status updates (UPDATE)
if (isset($_GET['complete'])) {
    $request_id = $_GET['complete'];
    mysqli_query($conn, "UPDATE maintenance_requests SET status = 'Completed' WHERE id = '$request_id'");
}

if (isset($_GET['reject'])) {
    $request_id = $_GET['reject'];
    mysqli_query($conn, "UPDATE maintenance_requests SET status = 'Rejected' WHERE id = '$request_id'");
}

// Handling delete request (DELETE)
if (isset($_GET['delete'])) {
    $request_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM maintenance_requests WHERE id = '$request_id'");
}

// Fetching requests (READ)
$requests = mysqli_query($conn, "SELECT * FROM maintenance_requests ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance & Repairs</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h2 {
            font-size: 1.6em;
            margin-bottom: 10px;
        }

        /* Forms */
        form {
            background-color: white;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Table */
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .actions button, .actions a {
            padding: 5px 10px;
            margin: 2px;
            text-decoration: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-btn {
            background-color: #f0ad4e;
            color: white;
        }

        .delete-btn {
            background-color: #d9534f;
            color: white;
        }

        .status-btn {
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-size: 14px;
        }

        .complete-btn {
            background-color: #28a745;
        }

        .reject-btn {
            background-color: #dc3545;
        }

    </style>
</head>
<body class="bg-gray-100 flex">
    
    <?php include 'sidebar.php'; ?>
    
    <div class="container mx-auto p-6 ml-64">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Maintenance & Repair</h1>
        
        <button onclick="toggleAddForm()" class="bg-teal-500 text-white px-4 py-2 rounded">Submit Repair Request</button>
        
        <div id="addRequestForm" class="hidden mt-4 bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">New Repair Request</h2>
            <form method="POST">
                <label class="block text-sm font-semibold" for="hardware_id">Hardware ID</label>
                <input type="text" name="hardware_id" id="hardware_id" class="w-full border rounded p-2 mb-2" required>
                <label class="block text-sm font-semibold" for="issue">Issue</label>
                <input type="text" name="issue" id="issue" class="w-full border rounded p-2 mb-2" required>
                <button type="submit" name="submit_request" class="bg-teal-500 text-white px-4 py-2 rounded">Submit</button>
            </form>
        </div>

        <div class="mt-8">
            <table class="w-full bg-white shadow-md rounded border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3">Hardware ID</th>
                        <th class="p-3">Issue</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Technician</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($requests)) { ?>
                        <tr class="border-b">
                            <td class="p-3"><?php echo $row['hardware_id']; ?></td>
                            <td class="p-3"><?php echo $row['issue']; ?></td>
                            <td class="p-3"><?php echo $row['status']; ?></td>
                            <td class="p-3"><?php echo $row['technician'] ?? 'Not Assigned'; ?></td>
                            <td class="p-3">
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <form method="post" class="inline-block">
                                        <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                        <input type="text" name="technician" placeholder="Assign Technician" class="border rounded p-2" required>
                                        <button type="submit" name="assign_technician" class="bg-blue-500 text-white px-2 py-1 rounded">Assign</button>
                                    </form>
                                <?php } ?>
                                <a href="?complete=<?php echo $row['id']; ?>" class="bg-green-500 text-white px-2 py-1 rounded">Complete</a>
                                <a href="?reject=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-2 py-1 rounded">Reject</a>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="bg-gray-500 text-white px-2 py-1 rounded">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleAddForm() {
            var form = document.getElementById('addRequestForm');
            form.classList.toggle('hidden');
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>
