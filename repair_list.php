<?php
include 'db.php';

$sql = "SELECT * FROM maintenance_requests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Repair Requests</title>
</head>
<body>
    <h2>Repair Requests</h2>
    <table border="1">
        <tr>
            <th>Hardware ID</th>
            <th>Issue</th>
            <th>Status</th>
            <th>Technician</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['hardware_id']; ?></td>
            <td><?php echo $row['issue']; ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td><?php echo $row['technician'] ?: 'Not Assigned'; ?></td>
            <td>
                <a href="assign_technician.php?id=<?php echo $row['id']; ?>">Assign Technician</a> | 
                <a href="update_status.php?id=<?php echo $row['id']; ?>">Update Status</a> | 
                <a href="delete_request.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
            