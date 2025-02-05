

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
$tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'hardware_assets'");
if (mysqli_num_rows($tableCheck) == 0) {
    die("Error: Table 'hardware_assets' does not exist. Please check your database.");
}

// Get statistics
$total_hardware = getCount($conn, "SELECT COUNT(*) FROM hardware_assets");
$available_assets = getCount($conn, "SELECT COUNT(*) FROM hardware_assets WHERE status = 'Available'");
$under_maintenance = getCount($conn, "SELECT COUNT(*) FROM hardware_assets WHERE status = 'Under Maintenance'");
$out_service = getCount($conn, "SELECT COUNT(*) FROM hardware_assets WHERE status = 'Out of Service'");
$for_disposal = getCount($conn, "SELECT COUNT(*) FROM hardware_assets WHERE status = 'Under Disposal'");


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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #eef2f3, #8e9eab);
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
                <h2 class="text-gray-500 text-lg">Under Maintenance</h2>
                <p class="text-3xl font-bold text-yellow-500"><?php echo $under_maintenance; ?></p>
            </div>
            <div class="card">
                <h2 class="text-gray-500 text-lg">Out of Service</h2>
                <p class="text-3xl font-bold text-red-500"><?php echo $out_service; ?></p>
            </div>
            <div class="card">
                <h2 class="text-gray-500 text-lg">Under Disposal</h2>
                <p class="text-3xl font-bold text-orange-500"><?php echo $for_disposal; ?></p>
            </div>
        </div>


        <!-- Quick Actions -->
        <div class="mt-10">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="inventory.php" class="bg-blue-500 text-white text-center py-3 rounded-lg shadow-md hover:bg-blue-600">
                    Add New Hardware
                </a>
                <a href="maintenance.php" class="bg-yellow-500 text-white text-center py-3 rounded-lg shadow-md hover:bg-yellow-600">
                    Create Repair Request
                </a>
                <a href="inventory.php" class="bg-green-500 text-white text-center py-3 rounded-lg shadow-md hover:bg-green-600">
                    Total Hardware
                </a>
            </div>
        </div>

        <div style="width: 50%; margin: 20px auto;">
         <canvas id="hardwareChart"></canvas>
        </div>

    </div>
</body>
</html>
<script>
    const ctx = document.getElementById('hardwareChart').getContext('2d');
    const hardwareChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Total Hardware', 'Available Assets', 'Under Maintenance', 'Out of Service' , 'Under Disposal'],
            datasets: [{
                label: 'Hardware Statistics',
                data: [
                    <?php echo $total_hardware; ?>,
                    <?php echo $available_assets; ?>,
                    <?php echo $under_maintenance; ?>,
                    <?php echo $out_service; ?>
                    <?php echo $for_disposal; ?>
                ],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#ffa500'],
                borderColor: ['#ffffff'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Hardware Statistics Overview'
                }
            }
        }
    });
</script>

<?php
// Free result set kung may laman ang logs_result
if ($logs_result) {
    mysqli_free_result($logs_result);
}
mysqli_close($conn);
?>

