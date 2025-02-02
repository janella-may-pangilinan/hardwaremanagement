<?php
include 'db.php';

// Handling repair request submission
if (isset($_POST['submit_request'])) {
    $hardware_id = $_POST['hardware_id'];
    $issue = $_POST['issue'];
    $insert_query = "INSERT INTO maintenance_requests (hardware_id, issue, status) VALUES ('$hardware_id', '$issue', 'Pending')";
    mysqli_query($conn, $insert_query);
}

// Handling technician assignment
if (isset($_POST['assign_technician'])) {
    $request_id = $_POST['request_id'];
    $technician = $_POST['technician'];
    $update_query = "UPDATE maintenance_requests SET technician = '$technician', status = 'In Progress' WHERE id = '$request_id'";
    mysqli_query($conn, $update_query);
}

// Handling status updates
if (isset($_GET['complete'])) {
    $request_id = $_GET['complete'];
    mysqli_query($conn, "UPDATE maintenance_requests SET status = 'Completed' WHERE id = '$request_id'");
}

if (isset($_GET['reject'])) {
    $request_id = $_GET['reject'];
    mysqli_query($conn, "UPDATE maintenance_requests SET status = 'Rejected' WHERE id = '$request_id'");
}

// Fetching requests
$requests = mysqli_query($conn, "SELECT * FROM maintenance_requests ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance & Repairs</title>
</head>
<body>
    <h2>Submit Repair Request</h2>
    <form method="post">
        <label>Hardware ID:</label>
        <input type="text" name="hardware_id" required>
        <label>Issue:</label>
        <input type="text" name="issue" required>
        <button type="submit" name="submit_request">Submit</button>
    </form>

    <h2>Repair Requests</h2>
    <table border="1">
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
                <td>
                    <?php if ($row['status'] == 'Pending') { ?>
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="technician" placeholder="Assign Technician">
                            <button type="submit" name="assign_technician">Assign</button>
                        </form>
                    <?php } ?>
                    <?php if ($row['status'] == 'In Progress') { ?>
                        <a href="?complete=<?php echo $row['id']; ?>">Complete</a>
                        <a href="?reject=<?php echo $row['id']; ?>">Reject</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php mysqli_close($conn); ?>
