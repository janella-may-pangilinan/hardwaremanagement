<?php
$servername = "localhost"; // Palitan kung ibang server gamit mo
$username = "u729491923_hardware"; // Default sa XAMPP
$password = "Hardware@0527"; // Default sa XAMPP (walang password)
$database = "u729491923_hardware"; // Siguraduhin na ito ang tamang database name


// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch data from hardware_assets table
$sql = "SELECT asset_name, serial_number, model, brand, status, location, assigned_user, warranty_info FROM hardware_assets";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 250px;
            background-color: #f0f0f5;
            color: #333;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background: #333;
            color: white;
            padding-top: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px;
            text-align: left;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
        }
        .sidebar ul li a:hover {
            background-color: #444;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .report-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 3px solid #ff4081;
        }
        .report-tabs button {
            padding: 12px 20px;
            cursor: pointer;
            border: none;
            background-color: #fff;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-right: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .report-tabs button:hover {
            background-color: #ff4081;
            color: white;
        }
        .report-tabs button.active {
            background-color: #ff4081;
            color: white;
        }
        .report-content {
            margin-top: 20px;
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f7f7f7;
            color: #333;
        }
        td {
            color: #555;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-data {
            text-align: center;
            font-size: 18px;
            color: #ff4081;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

    <!-- Main content area -->
    <div class="content">
        <h1>Reports & Analytics</h1>

        <!-- Report Tabs -->
        <div class="report-tabs">
            <button class="active" onclick="showReport('inventory')">Inventory Reports</button>
            <button onclick="showReport('procurement')">Procurement Reports</button>
            <button onclick="showReport('maintenance')">Maintenance Reports</button>
            <button onclick="showReport('depreciation')">Depreciation Reports</button>
        </div>

        <!-- Report Content -->
        <div class="report-content">
            <!-- Inventory Reports Section -->
            <div id="inventory" class="report-section active">
                <h2>Inventory Reports</h2>
                <p>Summary of all hardware assets.</p>
                <!-- Display the table with the requested columns -->
                <table>
                    <thead>
                        <tr>
                            <th>Asset Name</th>
                            <th>Serial Number</th>
                            <th>Model</th>
                            <th>Brand</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Assigned User</th>
                            <th>Warranty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check if there are rows returned from the database
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $row["asset_name"] . "</td>
                                        <td>" . $row["serial_number"] . "</td>
                                        <td>" . $row["model"] . "</td>
                                        <td>" . $row["brand"] . "</td>
                                        <td>" . $row["status"] . "</td>
                                        <td>" . $row["location"] . "</td>
                                        <td>" . $row["assigned_user"] . "</td>
                                        <td>" . $row["warranty_info"] . "</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='no-data'>No data found</td></tr>";
                        }

                        // Close the connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Other Report Sections (Procurement, Maintenance, Depreciation) -->
            <div id="procurement" class="report-section">
                <h2>Procurement Reports</h2>
                <p>Details of purchased and pending purchase orders.</p>
            </div>
            <div id="maintenance" class="report-section">
                <h2>Maintenance Reports</h2>
                <p>Record of all repairs and maintenance activities.</p>
            </div>
            <div id="depreciation" class="report-section">
                <h2>Depreciation Reports</h2>
                <p>Financial tracking of asset depreciation.</p>
            </div>
        </div>
    </div>

    <script>
        // Function to display the selected report
        function showReport(reportType) {
            // Hide all report sections
            const sections = document.querySelectorAll('.report-section');
            sections.forEach(section => section.classList.remove('active'));

            // Remove active class from all buttons
            const buttons = document.querySelectorAll('.report-tabs button');
            buttons.forEach(button => button.classList.remove('active'));

            // Show the selected report section and add active class to the clicked button
            document.getElementById(reportType).classList.add('active');
            document.querySelector(`[onclick="showReport('${reportType}')"]`).classList.add('active');
        }
    </script>

</body>
</html>
