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

// Handling edit request (UPDATE)
if (isset($_POST['edit_request'])) {
    $request_id = $_POST['request_id'];
    $issue = $_POST['issue'];
    $technician = $_POST['technician'];
    mysqli_query($conn, "UPDATE maintenance_requests SET issue = '$issue', technician = '$technician' WHERE id = '$request_id'");
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
                <label class="block text-sm font-semibold">Hardware ID</label>
                <input type="text" name="hardware_id" class="w-full border rounded p-2 mb-2" required>
                <label class="block text-sm font-semibold">Issue</label>
                <input type="text" name="issue" class="w-full border rounded p-2 mb-2" required>
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
                            <td class="p-3"> <?php echo $row['hardware_id']; ?> </td>
                            <td class="p-3"> <?php echo $row['issue']; ?> </td>
                            <td class="p-3"> <?php echo $row['status']; ?> </td>
                            <td class="p-3"> <?php echo $row['technician'] ?? 'Not Assigned'; ?> </td>
                            <td class="p-3">
                                <button class="bg-yellow-500 text-white px-2 py-1 rounded" onclick="editRequest('<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['issue'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['technician'], ENT_QUOTES); ?>')">Edit</button>
                                <a href="?complete=<?php echo $row['id']; ?>" class="bg-green-500 text-white px-2 py-1 rounded">Complete</a>
                                <a href="?reject=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-2 py-1 rounded">Reject</a>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="bg-gray-500 text-white px-2 py-1 rounded">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div id="editForm" class="hidden mt-4 bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Repair Request</h2>
            <form method="POST">
                <input type="hidden" name="request_id" id="edit_request_id">
                <label class="block text-sm font-semibold">Issue</label>
                <input type="text" name="issue" id="edit_issue" class="w-full border rounded p-2 mb-2" required>
                <label class="block text-sm font-semibold">Technician</label>
                <input type="text" name="technician" id="edit_technician" class="w-full border rounded p-2 mb-2">
                <button type="submit" name="edit_request" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                <button type="button" onclick="toggleEditForm()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function toggleAddForm() {
            document.getElementById('addRequestForm').classList.toggle('hidden');
        }

        function editRequest(id, issue, technician) {
            document.getElementById('edit_request_id').value = id;
            document.getElementById('edit_issue').value = issue;
            document.getElementById('edit_technician').value = technician;
            document.getElementById('editForm').classList.remove('hidden');
        }

        function toggleEditForm() {
            document.getElementById('editForm').classList.add('hidden');
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>
