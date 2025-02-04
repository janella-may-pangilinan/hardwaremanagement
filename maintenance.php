<?php
include 'db.php';

// Handling repair request submission (CREATE)
if (isset($_POST['submit_request'])) {
    $hardware_id = $_POST['hardware_id'];
    $issue = $_POST['issue'];
    $insert_query = "INSERT INTO maintenance_requests (hardware_id, issue, status) VALUES ('$hardware_id', '$issue', 'Pending')";
    mysqli_query($conn, $insert_query);
}

// Handling technician assignment (UPDATE)
if (isset($_POST['assign_technician'])) {
    $request_id = $_POST['request_id'];
    $technician = $_POST['technician'];
    $update_query = "UPDATE maintenance_requests SET technician = '$technician', status = 'In Progress' WHERE id = '$request_id'";
    mysqli_query($conn, $update_query);
}

// Handling status updates (UPDATE)
if (isset($_GET['complete'])) {
    $request_id = $_GET['complete'];
    mysqli_query($conn, "UPDATE maintenance_requests SET status = 'Completed' WHERE id = '$request_id'");
}

if (isset($_GET['reject'])) {
    $request_id = $_GET['reject'];
    mysqli_query($conn, "UPDATE maintenance_requests SET status = 'Rejected' WHERE id = '$request_id'");
}

// Handling delete request (DELETE)
if (isset($_GET['delete'])) {
    $request_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM maintenance_requests WHERE id = '$request_id'");
}

// Fetching requests (READ)
$requests = mysqli_query($conn, "SELECT * FROM maintenance_requests ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance & Repairs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    
    <?php include 'sidebar.php'; ?>
    
    <div class="container mx-auto p-6 ml-64">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Maintenance & Repair</h1>
        
        <button onclick="toggleAddForm()" class="bg-teal-500 text-white px-4 py-2 rounded">Submit Repair Request</button>
        
        <div id="addRequestForm" class="hidden mt-4 bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">New Repair Request</h2>
            <form method="POST">
                <label class="block text-sm font-semibold" for="hardware_id">Hardware ID</label>
                <input type="text" name="hardware_id" id="hardware_id" class="w-full border rounded p-2 mb-2" required>
                <label class="block text-sm font-semibold" for="issue">Issue</label>
                <input type="text" name="issue" id="issue" class="w-full border rounded p-2 mb-2" required>
                <button type="submit" name="submit_request" class="bg-teal-500 text-white px-4 py-2 rounded">Submit</button>
            </form>
        </div>

        <div class="mt-8">
            <table class="w-full bg-white shadow-md rounded border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3">Hardware ID</th>
                        <th class="p-3">Issue</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Technician</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($requests)) { ?>
                        <tr class="border-b">
                            <td class="p-3"><?php echo $row['hardware_id']; ?></td>
                            <td class="p-3"><?php echo $row['issue']; ?></td>
                            <td class="p-3"><?php echo $row['status']; ?></td>
                            <td class="p-3"><?php echo $row['technician'] ?? 'Not Assigned'; ?></td>
                            <td class="p-3">
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <form method="post" class="inline-block">
                                        <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                        <input type="text" name="technician" placeholder="Assign Technician" class="border rounded p-2" required>
                                        <button type="submit" name="assign_technician" class="bg-blue-500 text-white px-2 py-1 rounded">Assign</button>
                                    </form>
                                <?php } ?>
                                <a href="?complete=<?php echo $row['id']; ?>" class="bg-green-500 text-white px-2 py-1 rounded">Complete</a>
                                <a href="?reject=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-2 py-1 rounded">Reject</a>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="bg-gray-500 text-white px-2 py-1 rounded">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleAddForm() {
            var form = document.getElementById('addRequestForm');
            form.classList.toggle('hidden');
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>
