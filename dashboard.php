

<?php
include 'db.php';


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

// Get statistics
$total_hardware = getCount($conn, "SELECT COUNT(*) FROM hardware");
$available_assets = getCount($conn, "SELECT COUNT(*) FROM hardware WHERE status = 'available'");
$pending_requests = getCount($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status = 'pending'");
$critical_alerts = getCount($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status = 'critical'");

// Pagkuha ng logs
$logs_result = mysqli_query($conn, "SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #eef2f3, #8e9eab);
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #2c3e50;
            color: white;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
            border-radius: 8px;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

    </style>
</head>
<body class>
    <?php include 'sidebar.php'; ?>
   
    <div class="main-content">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Hardware Management System</h1>
            <h1>Dashboard Overview</h1>
        </header>

        <!-- Stats Overview -->
        <div class="card-container">
        <div class="card">
                <h2 class="text-gray-500 text-lg">Total Hardware</h2>
                <p class="text-3xl font-bold text-blue-500"><?php echo $total_hardware; ?></p>
            </div>
            <div class="card">
                <h2 class="text-gray-500 text-lg">Available Assets</h2>
                <p class="text-3xl font-bold text-green-500"><?php echo $available_assets; ?></p>
            </div>
            <div class="card">
                <h2 class="text-gray-500 text-lg">Pending Requests</h2>
                <p class="text-3xl font-bold text-yellow-500"><?php echo $pending_requests; ?></p>
            </div>
            <div class="card">
                <h2 class="text-gray-500 text-lg">Critical Alerts</h2>
                <p class="text-3xl font-bold text-red-500"><?php echo $critical_alerts; ?></p>
            </div>
        </div>

        <!-- Recent Activity Logs -->
        <div class="mt-10 bg-white shadow-md p-6 rounded-lg">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Recent Activity Logs</h2>
            <ul class="divide-y divide-gray-200">
                <?php while ($log = mysqli_fetch_assoc($logs_result)) { ?>
                    <li class="py-2 text-gray-600">
                        <span class="font-semibold"><?php echo htmlspecialchars($log['activity_type']); ?></span>: 
                        <?php echo htmlspecialchars($log['description']); ?> 
                        <span class="text-sm text-gray-400">(<?php echo htmlspecialchars($log['created_at']); ?>)</span>
                    </li>
                <?php } ?>
            </ul>
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
// Free result set kung may laman ang logs_result
if ($logs_result) {
    mysqli_free_result($logs_result);
}
mysqli_close($conn);
?>

