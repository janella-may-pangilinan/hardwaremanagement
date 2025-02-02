<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hardware";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['generate_report'])) {
    $report_type = $_POST['report_type'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];

    // Query based on report type
    switch ($report_type) {
        case 'inventory':
            $sql = "SELECT * FROM hardware_assets WHERE purchase_date BETWEEN '$date_from' AND '$date_to'";
            break;
        case 'procurement':
            $sql = "SELECT * FROM procurement WHERE order_date BETWEEN '$date_from' AND '$date_to'";
            break;
        case 'maintenance':
            $sql = "SELECT * FROM maintenance WHERE repair_date BETWEEN '$date_from' AND '$date_to'";
            break;
        case 'depreciation':
            $sql = "SELECT * FROM depreciation WHERE depreciation_date BETWEEN '$date_from' AND '$date_to'";
            break;
        default:
            echo "Invalid report type";
            exit;
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Placeholder for export options (Excel, PDF, CSV)
    } else {
        echo "No records found";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Sidebar (you can include this part in a separate file like sidebar.php) -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="ml-64 p-6">
    <h1 class="text-3xl font-semibold text-gray-800">Generate Reports</h1>
    <form method="POST" class="mt-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-semibold" for="report_type">Select Report Type</label>
                <select name="report_type" id="report_type" class="w-full p-2 mt-1 border rounded">
                    <option value="inventory">Inventory Report</option>
                    <option value="procurement">Procurement Report</option>
                    <option value="maintenance">Maintenance Report</option>
                    <option value="depreciation">Depreciation Report</option>
                </select>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-semibold" for="date_from">From Date</label>
                <input type="date" name="date_from" id="date_from" class="w-full p-2 mt-1 border rounded" required>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-semibold" for="date_to">To Date</label>
                <input type="date" name="date_to" id="date_to" class="w-full p-2 mt-1 border rounded" required>
            </div>
        </div>
        <button type="submit" name="generate_report" class="mt-4 bg-blue-500 text-white p-2 rounded">Generate Report</button>
    </form>

    <br>

    <!-- Placeholder for display results -->
    <?php if (isset($result)) : ?>
        <h2 class="text-2xl font-semibold mt-4">Report Results</h2>
        <table class="min-w-full mt-4 bg-white border border-gray-200">
            <thead>
                <tr>
                    <?php
                    $columns = $result->fetch_fields();
                    foreach ($columns as $column) {
                        echo "<th class='border px-4 py-2'>" . ucfirst($column->name) . "</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <?php foreach ($row as $value) : ?>
                            <td class='border px-4 py-2'><?php echo $value; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

</body>
</html>

<?php
$conn->close();
?>
