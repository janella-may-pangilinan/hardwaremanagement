<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KIT.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #1a202c;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 4px 0px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .logo img {
            width: 100px;
            height: auto;
            transition: transform 0.3s ease;
        }
        .logo h1 {
            color: #e2e8f0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .logo h1 {
            opacity: 0;
        }

        /* Sidebar Menu */
        .sidebar ul {
            width: 100%;
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            color: #e2e8f0;
            font-size: 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-bottom: 10px;
            position: relative;
        }

        .sidebar.collapsed a span {
            display: none;
        }

        .sidebar a:hover, .sidebar a.active {
            background: #2b6cb0;
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar a::after {
            content: '';
            position: absolute;
            height: 2px;
            width: 0;
            left: 0;
            bottom: 0;
            background-color: #3182ce;
            transition: width 0.3s ease;
        }

        .sidebar a:hover::after, .sidebar a.active::after {
            width: 100%;
        }

        .sidebar i {
            font-size: 20px;
        }

        /* Hover Effect on Logo */
        .logo:hover img {
            transform: rotate(15deg);
        }

        /* Toggle Button */
        .toggle-btn {
            position: absolute;
            top: 20px;
            right: -20px;
            background: #2b6cb0;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()">☰</div>
    <!-- Logo Section -->
    <div class="logo">
        <h1>Hardware Management</h1>
    </div>

    <!-- Sidebar Menu -->
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
        <li><a href="inventory.php"><i class="fas fa-boxes"></i> <span>Inventory</span></a></li>
        <li><a href="procurement.php"><i class="fas fa-shopping-cart"></i> <span>Procurement</span></a></li>
        <li><a href="maintenance.php"><i class="fas fa-tools"></i> <span>Maintenance</span></a></li>
        <li><a href="disposal.php"><i class="fas fa-trash-alt"></i> <span>Disposal</span></a></li>
        <li><a href="reports.php"><i class="fas fa-chart-bar"></i> <span>Reports</span></a></li>
        <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
    </ul>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }
</script>

</body>
</html>
