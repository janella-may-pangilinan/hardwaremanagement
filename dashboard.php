<?php
include 'db.php';
include 'sidebar.php'; // Include sidebar

// Function para sa pagkuha ng count sa database
function getCount($conn, $query) {
    $result = mysqli_query($conn, $query);
    if (!$result) {
        return 0;
    }
    $row = mysqli_fetch_assoc($result);
    return $row ? reset($row) : 0;
}

// Check kung may table bago mag-query
$tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'hardware'");
if (mysqli_num_rows($tableCheck) == 0) {
    die("Error: Table 'hardware' does not exist. Please check your database.");
}

$total_hardware = getCount($conn, "SELECT COUNT(*) FROM hardware");
$available_assets = getCount($conn, "SELECT COUNT(*) FROM hardware WHERE status = 'available'");
$pending_requests = getCount($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status = 'pending'");
$critical_alerts = getCount($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status = 'critical'");

// Pagkuha ng logs
$logs_result = mysqli_query($conn, "SELECT activity_type, description, created_at FROM activity_logs ORDER BY created_at DESC LIMIT 5");

if (!$logs_result) {
    die("Error retrieving logs: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    
    <div class="max-w-6xl mx-auto p-6">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Hardware Management System</h1>
        </header>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white shadow-md p-6 rounded-lg text-center">
                <h2 class="text-gray-500 text-lg">Total Hardware</h2>
                <p class="text-3xl font-bold text-blue-500"><?php echo $total_hardware; ?></p>
            </div>
            <div class="bg-white shadow-md p-6 rounded-lg text-center">
                <h2 class="text-gray-500 text-lg">Available Assets</h2>
                <p class="text-3xl font-bold text-green-500"><?php echo $available_assets; ?></p>
            </div>
            <div class="bg-white shadow-md p-6 rounded-lg text-center">
                <h2 class="text-gray-500 text-lg">Pending Requests</h2>
                <p class="text-3xl font-bold text-yellow-500"><?php echo $pending_requests; ?></p>
            </div>
            <div class="bg-white shadow-md p-6 rounded-lg text-center">
                <h2 class="text-gray-500 text-lg">Critical Alerts</h2>
                <p class="text-3xl font-bold text-red-500"><?php echo $critical_alerts; ?></p>
            </div>
        </div>

        <!-- Recent Activity Logs -->
        <div class="mt-10 bg-white shadow-md p-6 rounded-lg">
        <div class="activity-logs">
    <h3>Recent Activity Logs</h3>
    <ul>
        <?php
       if (!$logs_result) {
        // Handle query error
        echo "<p class='text-red-500'>Error retrieving logs: " . mysqli_error($conn) . "</p>";
    } else {
        // Check if there are any logs
        if (mysqli_num_rows($logs_result) > 0) { 
            echo '<ul class="divide-y divide-gray-200">';
            while ($log = mysqli_fetch_assoc($logs_result)) {
                echo '<li class="py-2 text-gray-600">';
                echo '<span class="font-semibold">' . htmlspecialchars($log['activity_type']) . '</span>: ';
                echo htmlspecialchars($log['description']);
                echo ' <span class="text-sm text-gray-400">(' . htmlspecialchars($log['created_at']) . ')</span>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            // No logs found
            echo "<p class='text-gray-500'>No recent activities found.</p>";
        }
    }
        ?>
    </ul>
</div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-10">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="add_hardware.php" class="bg-blue-500 text-white text-center py-3 rounded-lg shadow-md hover:bg-blue-600">
                    Add New Hardware
                </a>
                <a href="repair_request.php" class="bg-yellow-500 text-white text-center py-3 rounded-lg shadow-md hover:bg-yellow-600">
                    Create Repair Request
                </a>
                <a href="generate_reports.php" class="bg-green-500 text-white text-center py-3 rounded-lg shadow-md hover:bg-green-600">
                    Generate Reports
                </a>
            </div>
        </div>
    </div>

</body>
</html>

<?php
mysqli_free_result($logs_result);
mysqli_close($conn);
?>
