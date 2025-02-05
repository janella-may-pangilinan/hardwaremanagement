<?php
include 'db.php';

// Fetching list of technicians
$technicians = mysqli_query($conn, "SELECT id, name FROM technicians");

// Handling repair request submission (CREATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_request'])) {
    $hardware_id = $_POST['hardware_id'];
    $issue = $_POST['issue'];
    $technician = $_POST['technician'];
    
    $insert_query = "INSERT INTO maintenance_requests (hardware_id, issue, technician, status) 
                     VALUES ('$hardware_id', '$issue', '$technician', 'Pending')";
    
    if (!mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Handling technician assignment (UPDATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_technician'])) {
    $request_id = $_POST['request_id'];
    $technician = $_POST['technician'];
    
    $update_query = "UPDATE maintenance_requests SET technician = '$technician', status = 'In Progress' WHERE id = '$request_id'";
    
    if (!mysqli_query($conn, $update_query)) {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Handling status updates (UPDATE)
if (isset($_GET['complete'])) {
    mysqli_query($conn, "UPDATE maintenance_requests SET status = 'Completed' WHERE id = '{$_GET['complete']}'");
}

if (isset($_GET['reject'])) {
    mysqli_query($conn, "UPDATE maintenance_requests SET status = 'Rejected' WHERE id = '{$_GET['reject']}'");
}

// Handling delete request (DELETE)
if (isset($_GET['delete'])) {
    mysqli_query($conn, "DELETE FROM maintenance_requests WHERE id = '{$_GET['delete']}'");
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
        .container { max-width: 1200px; margin: 0 auto; flex-grow: 1; }
        .heading { font-size: 2rem; font-weight: bold; color: #2d3748; }
        .form-input, .form-submit { border-radius: 8px; padding: 10px; width: 100%; }
        .form-submit { background-color: #38b2ac; color: white; cursor: pointer; }
        .form-submit:hover { background-color: #319795; }
        .table { width: 100%; border-collapse: collapse; background-color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .table th, .table td { padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .table th { background-color: #edf2f7; font-weight: bold; }
        .table tbody tr:hover { background-color: #f7fafc; }
        .action-links a { margin-right: 10px; font-weight: 600; }
    </style>
    <script>
        function toggleForm() { document.getElementById('requestForm').classList.toggle('hidden'); }
    </script>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="container p-6 ml-64">
    <h1 class="heading">Maintenance & Repair Requests</h1>
    <button onclick="toggleForm()" class="form-submit">Submit New Repair Request</button>
    
    <div id="requestForm" class="mt-4 hidden">
        <h2 class="text-xl font-semibold">Submit Repair Request</h2>
        <form method="post">
            <label>Hardware ID</label>
            <input type="text" name="hardware_id" class="form-input" required>
            <label>Issue</label>
            <input type="text" name="issue" class="form-input" required>
            <label>Technician</label>
            <select name="technician" class="form-input" required>
                <option value="">Select Technician</option>
                <?php while ($tech = mysqli_fetch_assoc($technicians)) { ?>
                    <option value="<?php echo $tech['id']; ?>"><?php echo $tech['name']; ?></option>
                <?php } ?>
            </select>
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
                    <td>
                        <?php
                        $tech_id = $row['technician'];
                        $tech_query = mysqli_query($conn, "SELECT name FROM technicians WHERE id = '$tech_id'");
                        $tech_data = mysqli_fetch_assoc($tech_query);
                        echo !empty($tech_data['name']) ? $tech_data['name'] : 'Not Assigned';
                        ?>
                    </td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <form method="post" class="inline-block">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <select name="technician" class="form-input" required>
                                    <option value="">Assign Technician</option>
                                    <?php
                                    $technicians = mysqli_query($conn, "SELECT id, name FROM technicians");
                                    while ($tech = mysqli_fetch_assoc($technicians)) {
                                        echo "<option value='{$tech['id']}'>{$tech['name']}</option>";
                                    }
                                    ?>
                                </select>
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

</body>
</html>

<?php mysqli_close($conn); ?>
