<?php

include 'db.php';


$query = "SELECT COUNT(*) AS total_hardware FROM hardware";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_hardware = $row['total_hardware'];


$query = "SELECT COUNT(*) AS available_assets FROM hardware WHERE status = 'available'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$available_assets = $row['available_assets'];

$query = "SELECT COUNT(*) AS pending_requests FROM maintenance_requests WHERE status = 'pending'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$pending_requests = $row['pending_requests'];


$query = "SELECT COUNT(*) AS critical_alerts FROM maintenance_requests WHERE status = 'pending'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$critical_alerts = $row['critical_alerts'];


$query = "SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 5";
$logs_result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Management Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard">
        <h1>Hardware Management System</h1>
        <div class="overview">
            <h2>Real-Time Overview</h2>
            <ul>
                <li>Total Hardware: <?php echo $total_hardware; ?></li>
                <li>Available Assets: <?php echo $available_assets; ?></li>
                <li>Pending Maintenance Requests: <?php echo $pending_requests; ?></li>
                <li>Critical Alerts: <?php echo $critical_alerts; ?></li>
            </ul>
        </div>

        <div class="recent-activity">
            <h2>Recent Activity Logs</h2>
            <ul>
                <?php while ($log = mysqli_fetch_assoc($logs_result)) { ?>
                    <li><?php echo $log['activity_type']; ?>: <?php echo $log['description']; ?> (<?php echo $log['created_at']; ?>)</li>
                <?php } ?>
            </ul>
        </div>

        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <ul>
                <li><a href="add_hardware.php">Add New Hardware</a></li>
                <li><a href="repair_request.php">Create Repair Request</a></li>
                <li><a href="generate_reports.php">Generate Reports</a></li>
            </ul>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
