<?php
include 'db.php';

$query = "SELECT m.id, h.name AS hardware_name, m.issue, m.status, m.created_at 
          FROM maintenance_requests m
          JOIN hardware h ON m.hardware_id = h.id
          WHERE m.status = 'pending'";

$requests = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Repair Requests</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Pending Repair Requests</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Hardware</th>
                    <th class="border px-4 py-2">Issue</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Date Requested</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($requests)) { ?>
                <tr class="text-center">
                    <td class="border px-4 py-2"><?php echo $row['hardware_name']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['issue']; ?></td>
                    <td class="border px-4 py-2 text-yellow-500 font-bold"><?php echo ucfirst($row['status']); ?></td>
                    <td class="border px-4 py-2"><?php echo $row['created_at']; ?></td>
                    <td class="border px-4 py-2">
                        <a href="update_request.php?id=<?php echo $row['id']; ?>&status=completed" class="bg-green-500 text-white px-3 py-1 rounded-md shadow hover:bg-green-600">Mark as Completed</a>
                        <a href="delete_request.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-3 py-1 rounded-md shadow hover:bg-red-600">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
