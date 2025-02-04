<?php
include 'db.php';

// Handling repair request submission (CREATE)
if (isset($_POST['submit_request'])) {
    $hardware_id = $_POST['hardware_id'];
    $issue = $_POST['issue'];
    $insert_query = "INSERT INTO maintenance_requests (hardware_id, issue, status) VALUES ('$hardware_id', '$issue', 'Pending')";
    mysqli_query($conn, $insert_query);
}

// Handling edit request (UPDATE)
if (isset($_POST['edit_request'])) {
    $request_id = $_POST['request_id'];
    $hardware_id = $_POST['hardware_id'];
    $issue = $_POST['issue'];
    $update_query = "UPDATE maintenance_requests SET hardware_id = '$hardware_id', issue = '$issue' WHERE id = '$request_id'";
    mysqli_query($conn, $update_query);
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
        
        <div class="mt-8">
            <table class="w-full bg-white shadow-md rounded border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3">Hardware ID</th>
                        <th class="p-3">Issue</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($requests)) { ?>
                        <tr class="border-b">
                            <td class="p-3"><?php echo $row['hardware_id']; ?></td>
                            <td class="p-3"><?php echo $row['issue']; ?></td>
                            <td class="p-3">
                                <button onclick="editRequest(<?php echo $row['id']; ?>, '<?php echo $row['hardware_id']; ?>', '<?php echo $row['issue']; ?>')" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="editForm" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Edit Repair Request</h2>
            <form method="POST">
                <input type="hidden" name="request_id" id="edit_request_id">
                <label class="block text-sm font-semibold">Hardware ID</label>
                <input type="text" name="hardware_id" id="edit_hardware_id" class="w-full border rounded p-2 mb-2" required>
                <label class="block text-sm font-semibold">Issue</label>
                <input type="text" name="issue" id="edit_issue" class="w-full border rounded p-2 mb-2" required>
                <button type="submit" name="edit_request" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                <button type="button" onclick="closeEditForm()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function editRequest(id, hardware_id, issue) {
            document.getElementById('edit_request_id').value = id;
            document.getElementById('edit_hardware_id').value = hardware_id;
            document.getElementById('edit_issue').value = issue;
            document.getElementById('editForm').classList.remove('hidden');
        }

        function closeEditForm() {
            document.getElementById('editForm').classList.add('hidden');
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>
