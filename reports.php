<?php
// Include the sidebar
include('sidebar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 250px;
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
            border-bottom: 2px solid #ccc;
        }
        .report-tabs button {
            padding: 10px;
            cursor: pointer;
            border: none;
            background-color: #f1f1f1;
            font-size: 16px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .report-tabs button:hover {
            background-color: #ddd;
        }
        .report-tabs button.active {
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
    </style>
</head>
<body>

    <!-- Sidebar with report options -->
    <div class="sidebar">
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
            <li><a href="procurement.php"><i class="fas fa-shopping-cart"></i> Procurement</a></li>
            <li><a href="maintenance.php"><i class="fas fa-tools"></i> Maintenance</a></li>
            <li><a href="disposal.php"><i class="fas fa-trash-alt"></i> Disposal</a></li>
            <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

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
            <div id="inventory" class="report-section active">
                <h2>Inventory Reports</h2>
                <p>Summary of all hardware assets.</p>
                <!-- Add your actual data fetching and display here -->
            </div>
            <div id="procurement" class="report-section">
                <h2>Procurement Reports</h2>
                <p>Details of purchased and pending purchase orders.</p>
                <!-- Add your actual data fetching and display here -->
            </div>
            <div id="maintenance" class="report-section">
                <h2>Maintenance Reports</h2>
                <p>Record of all repairs and maintenance activities.</p>
                <!-- Add your actual data fetching and display here -->
            </div>
            <div id="depreciation" class="report-section">
                <h2>Depreciation Reports</h2>
                <p>Financial tracking of asset depreciation.</p>
                <!-- Add your actual data fetching and display here -->
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
