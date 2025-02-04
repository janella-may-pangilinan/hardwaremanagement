<?php
include 'db.php';
include 'sidebar.php';

// Handling delete action for hardware
if (isset($_GET['delete_hardware'])) {
    $hardware_id = $_GET['delete_hardware'];
    $delete_query = "DELETE FROM hardware WHERE id = '$hardware_id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Hardware deleted successfully!'); window.location.href='generate_reports.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handling delete action for maintenance requests
if (isset($_GET['delete_request'])) {
    $request_id = $_GET['delete_request'];
    $delete_query = "DELETE FROM maintenance_requests WHERE id = '$request_id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Maintenance request deleted successfully!'); window.location.href='generate_reports.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handling accept request
if (isset($_GET['accept_request'])) {
    $request_id = $_GET['accept_request'];
    $accept_query = "UPDATE maintenance_requests SET status = 'approved' WHERE id = '$request_id'";
    if (mysqli_query($conn, $accept_query)) {
        echo "<script>alert('Request approved successfully!'); window.location.href='generate_reports.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handling decline request
if (isset($_GET['decline_request'])) {
    $request_id = $_GET['decline_request'];
    $decline_query = "UPDATE maintenance_requests SET status = 'declined' WHERE id = '$request_id'";
    if (mysqli_query($conn, $decline_query)) {
        echo "<script>alert('Request declined successfully!'); window.location.href='generate_reports.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Get hardware list
$hardware_query = mysqli_query($conn, "SELECT * FROM hardware");

// Get maintenance requests, but only show pending requests
$maintenance_query = mysqli_query($conn, "SELECT * FROM maintenance_requests WHERE status = 'pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body{
            background: linear-gradient(to right, #eef2f3, #8e9eab);
        }
    </style>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Hardware Report</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Type</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($hardware = mysqli_fetch_assoc($hardware_query)) { ?>
                <tr class="text-center">
                    <td class="border px-4 py-2"><?php echo $hardware['name']; ?></td>
                    <td class="border px-4 py-2"><?php echo $hardware['type']; ?></td>
                    <td class="border px-4 py-2"><?php echo ucfirst($hardware['status']); ?></td>
                    <td class="border px-4 py-2">
                        <a href="edit_hardware.php?id=<?php echo $hardware['id']; ?>" class="text-blue-500 hover:text-blue-700">Edit</a> |
                        <a href="?delete_hardware=<?php echo $hardware['id']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this hardware?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Maintenance Request Report</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Hardware ID</th>
                    <th class="border px-4 py-2">Issue</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($maintenance = mysqli_fetch_assoc($maintenance_query)) { ?>
                <tr class="text-center">
                    <td class="border px-4 py-2"><?php echo $maintenance['hardware_id']; ?></td>
                    <td class="border px-4 py-2"><?php echo $maintenance['issue']; ?></td>
                    <td class="border px-4 py-2"><?php echo ucfirst($maintenance['status']); ?></td>
                    <td class="border px-4 py-2">
                        <a href="?accept_request=<?php echo $maintenance['id']; ?>" class="text-green-500 hover:text-green-700">Accept</a> |
                        <a href="?decline_request=<?php echo $maintenance['id']; ?>" class="text-red-500 hover:text-red-700">Decline</a> |
                        <a href="?delete_request=<?php echo $maintenance['id']; ?>" class="text-gray-500 hover:text-gray-700" onclick="return confirm('Are you sure you want to delete this request?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if (mysqli_num_rows($maintenance_query) == 0) { ?>
            <p class="text-center text-gray-500 mt-4">No pending maintenance requests.</p>
        <?php } ?>
    </div>
</body>
</html>

<?php
mysqli_free_result($hardware_query);
mysqli_free_result($maintenance_query);
mysqli_close($conn);
?>
