<?php
include 'db.php';

// Asset Depreciation Tracking
function calculateDepreciation($purchase_price, $years) {
    $depreciation_rate = 0.2; // Example: 20% per year
    $current_value = $purchase_price * pow((1 - $depreciation_rate), $years);
    return $current_value;
}

// Disposal Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_disposal'])) {
    $asset_id = $_POST['asset_id'];
    $reason = $_POST['reason'];
    $sql = "INSERT INTO disposal_requests (asset_id, reason, status) VALUES ('$asset_id', '$reason', 'Pending')";
    $conn->query($sql);
}

// Approve Disposal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve_disposal'])) {
    $request_id = $_POST['request_id'];
    $sql = "UPDATE disposal_requests SET status='Approved' WHERE id='$request_id'";
    $conn->query($sql);
}

// Disposal Records
$sql = "SELECT * FROM disposal_requests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asset Depreciation & Disposal</title>
</head>
<body>
    <h2>Asset Depreciation Calculator</h2>
    <form method="post">
        Purchase Price: <input type="number" name="purchase_price" required>
        Years: <input type="number" name="years" required>
        <button type="submit" name="calculate">Calculate</button>
    </form>
    <?php
    if (isset($_POST['calculate'])) {
        echo "Current Value: " . calculateDepreciation($_POST['purchase_price'], $_POST['years']);
    }
    ?>

    <h2>Request Disposal</h2>
    <form method="post">
        Asset ID: <input type="text" name="asset_id" required>
        Reason: <input type="text" name="reason" required>
        <button type="submit" name="request_disposal">Request</button>
    </form>

    <h2>Disposal Requests</h2>
    <table border="1">
        <tr><th>Request ID</th><th>Asset ID</th><th>Reason</th><th>Status</th><th>Approve</th></tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['asset_id']; ?></td>
                <td><?php echo $row['reason']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php if ($row['status'] == 'Pending') { ?>
                        <form method="post">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="approve_disposal">Approve</button>
                        </form>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>