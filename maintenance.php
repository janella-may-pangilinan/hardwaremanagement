<?php
include 'db.php';

// Handling repair request submission (CREATE)
if (isset($_POST['submit_request'])) {
    $hardware_id = $_POST['hardware_id'];
    $issue = $_POST['issue'];
    $technician = $_POST['technician'];
    $insert_query = "INSERT INTO maintenance_requests (hardware_id, issue, technician, status) VALUES ('$hardware_id', '$issue', '$technician', 'Pending')";
    mysqli_query($conn, $insert_query);
    echo "<script>alert('Repair request submitted successfully!');</script>";
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
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Maintenance & Repairs</title>
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
        .form-input {
            border-radius: 8px;
            border: 1px solid #cbd5e0;
            padding: 10px;
            font-size: 1rem;
            width: 100%;
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
        .sidebar {
            width: 250px;
            background-color: #2d3748;
            padding: 20px;
            color: white;
            position: fixed;
            height: 100vh;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="container p-6 ml-64">
    <h1 class="text-2xl font-bold text-gray-800">Maintenance & Repair Requests</h1>
    
    <button onclick="toggleForm()" class="form-submit">Submit New Repair Request</button>
    
    <div id="requestForm" class="mt-4 hidden">
        <form method="post">
            <label>Hardware ID</label>
            <input type="text" name="hardware_id" class="form-input" required>
            <label>Issue</label>
            <input type="text" name="issue" class="form-input" required>
            <label>Technician</label>
            <input type="text" name="technician" class="form-input" required>
            <button type="submit" name="submit_request" class="form-submit">Submit</button>
        </form>
    </div>
    
    <table class="table mt-8">
        <thead>
            <tr>
                <th>Hardware ID</th>
                <th>Issue</th>
                <th>Status</th>
                <th>Technician</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($requests)) { ?>
                <tr>
                    <td><?php echo $row['hardware_id']; ?></td>
                    <td><?php echo $row['issue']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo !empty($row['technician']) ? $row['technician'] : 'Not Assigned'; ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <form method="post" style="display:inline-block;">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="technician" class="form-input" placeholder="Assign Technician" required>
                                <button type="submit" name="assign_technician" class="form-submit">Assign</button>
                            </form>
                        <?php } ?>
                        <a href="?complete=<?php echo $row['id']; ?>" class="text-green-500">Complete</a>
                        <a href="?reject=<?php echo $row['id']; ?>" class="text-red-500">Reject</a>
                        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="text-gray-500">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    function toggleForm() {
        var form = document.getElementById('requestForm');
        form.classList.toggle('hidden');
    }
</script>

</body>
</html>


<?php mysqli_close($conn); ?>
