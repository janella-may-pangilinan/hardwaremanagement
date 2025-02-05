<?php
include 'db.php';

// Fetching list of technicians
$technicians = mysqli_query($conn, "SELECT id, name FROM technicians");

// Handling repair request submission (CREATE)
if (isset($_POST['submit_request'])) {
    $hardware_id = $_POST['hardware_id'];
    $issue = $_POST['issue'];
    $technician = $_POST['technician'];
    
    $insert_query = "INSERT INTO maintenance_requests (hardware_id, issue, technician, status) 
                     VALUES ('$hardware_id', '$issue', '$technician', 'Pending')";
    
    if (!mysqli_query($conn, $insert_query)) {
        die("Error: " . mysqli_error($conn)); // Error checking
    }
}

// Handling technician assignment (UPDATE)
if (isset($_POST['assign_technician'])) {
    $request_id = $_POST['request_id'];
    $technician = $_POST['technician'];
    
    $update_query = "UPDATE maintenance_requests SET technician = '$technician', status = 'In Progress' WHERE id = '$request_id'";
    
    if (!mysqli_query($conn, $update_query)) {
        die("Error: " . mysqli_error($conn));
    }
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
                            <form method="post" style="display:inline-block;">
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

<script>
    function toggleForm() {
        var form = document.getElementById('requestForm');
        form.classList.toggle('hidden');
    }
</script>

</body>
</html>

<?php mysqli_close($conn); ?>
