<?php
include 'db.php';

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
<body>
<?php include 'sidebar.php'; ?>
    <header>
        <h1>Maintenance & Repair Management</h1>
    </header>

    <!-- Submit Repair Request Form -->
    <section>
        <h2>Submit Repair Request</h2>
        <form method="post">
            <label for="hardware_id">Hardware ID:</label>
            <input type="text" id="hardware_id" name="hardware_id" required>
            <label for="issue">Issue:</label>
            <input type="text" id="issue" name="issue" required>
            <button type="submit" name="submit_request">Submit</button>
        </form>
    </section>

    <!-- Repair Requests Table -->
    <section>
        <h2>Repair Requests</h2>
        <table>
            <tr>
                <th>Hardware ID</th>
                <th>Issue</th>
                <th>Status</th>
                <th>Technician</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($requests)) { ?>
                <tr>
                    <td><?php echo $row['hardware_id']; ?></td>
                    <td><?php echo $row['issue']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['technician'] ?? 'Not Assigned'; ?></td>
                    <td class="actions">
                        <?php if ($row['status'] == 'Pending') { ?>
                            <form method="post" style="display:inline-block;">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="technician" placeholder="Assign Technician" required>
                                <button type="submit" name="assign_technician">Assign</button>
                            </form>
                        <?php } ?>
                        <a href="?complete=<?php echo $row['id']; ?>" class="status-btn complete-btn">Complete</a>
                        <a href="?reject=<?php echo $row['id']; ?>" class="status-btn reject-btn">Reject</a>
                        <button class="edit-btn" onclick="editRequest('<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['issue'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['technician'], ENT_QUOTES); ?>')">Edit</button>
                        <a class="delete-btn" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this request?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </section>

    <!-- Edit Form (Hidden by Default) -->
    <div id="editForm" style="display:none;">
        <h2>Edit Repair Request</h2>
        <form method="post">
            <input type="hidden" name="request_id" id="edit_request_id">
            <label>Issue:</label>
            <input type="text" name="issue" id="edit_issue" required>
            <label>Technician:</label>
            <input type="text" name="technician" id="edit_technician">
            <button type="submit" name="edit_request">Update</button>
            <button type="button" onclick="document.getElementById('editForm').style.display='none';">Cancel</button>
        </form>
    </div>

    <script>
        function editRequest(id, issue, technician) {
            document.getElementById('edit_request_id').value = id;
            document.getElementById('edit_issue').value = issue;
            document.getElementById('edit_technician').value = technician;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>
