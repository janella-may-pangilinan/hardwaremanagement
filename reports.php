<?php
$host = 'localhost';
$username = 'root'; 
$password = ''; 
$dbname = 'hardware'; 

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query for Inventory Reports
$sql_inventory = "SELECT asset_name, serial_number, model, brand, status, location, assigned_user, warranty_info FROM hardware_assets";
$result_inventory = $conn->query($sql_inventory);

// Query for Maintenance Reports
$sql_maintenance = "SELECT hardware_id, issue, status, technician FROM hardware";
$result_maintenance = $conn->query($sql_maintenance);
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
        .content {
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
        .report-tabs button:hover, .report-tabs button.active {
            background-color: #ff4081;
            color: white;
        }
        .report-content {
            margin-top: 20px;
        }
        .report-section {
            display: none;
        }
        .report-section.active {
            display: block;
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

<div class="content">
    <h1>Reports & Analytics</h1>

    <!-- Report Tabs -->
    <div class="report-tabs">
        <button class="tab-btn active" onclick="showReport('inventory')">Inventory Reports</button>
        <button class="tab-btn" onclick="showReport('procurement')">Procurement Reports</button>
        <button class="tab-btn" onclick="showReport('maintenance')">Maintenance Reports</button>
        <button class="tab-btn" onclick="showReport('depreciation')">Depreciation Reports</button>
    </div>

    <!-- Report Content -->
    <div class="report-content">
        <!-- Inventory Reports Section -->
        <div id="inventory" class="report-section active">
            <h2>Inventory Reports</h2>
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
                    if ($result_inventory->num_rows > 0) {
                        while ($row = $result_inventory->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row["asset_name"]}</td>
                                    <td>{$row["serial_number"]}</td>
                                    <td>{$row["model"]}</td>
                                    <td>{$row["brand"]}</td>
                                    <td>{$row["status"]}</td>
                                    <td>{$row["location"]}</td>
                                    <td>{$row["assigned_user"]}</td>
                                    <td>{$row["warranty_info"]}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='no-data'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Maintenance Reports Section -->
        <div id="maintenance" class="report-section">
            <h2>Maintenance Reports</h2>
            <table>
                <thead>
                    <tr>
                        <th>Hardware ID</th>
                        <th>Issue</th>
                        <th>Status</th>
                        <th>Technician</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_maintenance->num_rows > 0) {
                        while ($row = $result_maintenance->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row["hardware_id"]}</td>
                                    <td>{$row["issue"]}</td>
                                    <td>{$row["status"]}</td>
                                    <td>{$row["technician"]}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='no-data'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Procurement Reports Placeholder -->
        <div id="procurement" class="report-section">
            <h2>Procurement Reports</h2>
            <p>Details of purchased and pending purchase orders.</p>
        </div>

        <!-- Depreciation Reports Placeholder -->
        <div id="depreciation" class="report-section">
            <h2>Depreciation Reports</h2>
            <p>Financial tracking of asset depreciation.</p>
        </div>
    </div>
</div>

<script>
    function showReport(reportType) {
        // Hide all report sections
        document.querySelectorAll('.report-section').forEach(section => {
            section.classList.remove('active');
        });

        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.classList.remove('active');
        });

        // Show the selected report section
        document.getElementById(reportType).classList.add('active');

        // Set the clicked button as active
        event.currentTarget.classList.add('active');
    }
</script>

</body>
</html>
