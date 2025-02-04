<?php
include 'db.php';

// Asset Depreciation Tracking
function calculateDepreciation($purchase_price, $years) {
    $depreciation_rate = 0.2; // 20% per year
    return $purchase_price * pow((1 - $depreciation_rate), $years);
}

// Handle Disposal Request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['request_disposal'])) {
        $asset_id = $conn->real_escape_string($_POST['asset_id']);
        $reason = $conn->real_escape_string($_POST['reason']);
        $sql = "INSERT INTO disposal_requests (asset_id, reason, status) VALUES ('$asset_id', '$reason', 'Pending')";
        $conn->query($sql);
    } elseif (isset($_POST['approve_disposal'])) {
        $request_id = intval($_POST['request_id']);
        $sql = "UPDATE disposal_requests SET status='Approved' WHERE id='$request_id'";
        $conn->query($sql);
    }
}

// Fetch Disposal Records
$result = $conn->query("SELECT * FROM disposal_requests");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2 class="mb-3">Asset Depreciation Calculator</h2>
    <form method="post" class="mb-3">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="number" name="purchase_price" class="form-control" placeholder="Purchase Price" required>
            </div>
            <div class="col-md-4">
                <input type="number" name="years" class="form-control" placeholder="Years" required>
            </div>
            <div class="col-md-4">
                <button type="submit" name="calculate" class="btn btn-primary">Calculate</button>
            </div>
        </div>
    </form>
    <?php
    if (isset($_POST['calculate'])) {
        echo "<div class='alert alert-info'>Current Value: $" . number_format(calculateDepreciation($_POST['purchase_price'], $_POST['years']), 2) . "</div>";
    }
    ?>

    <h2 class="mb-3">Request Asset Disposal</h2>
    <form method="post" class="mb-3">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="asset_id" class="form-control" placeholder="Asset ID" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="reason" class="form-control" placeholder="Reason for Disposal" required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="request_disposal" class="btn btn-danger">Request</button>
            </div>
        </div>
    </form>

    <h2>Disposal Requests</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Request ID</th>
                <th>Asset ID</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['asset_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['reason']); ?></td>
                    <td><span class="badge bg-<?php echo ($row['status'] == 'Pending') ? 'warning' : 'success'; ?>"> <?php echo $row['status']; ?></span></td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <form method="post">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="approve_disposal" class="btn btn-success btn-sm">Approve</button>
                            </form>
                        <?php } else { ?>
                            <button class="btn btn-secondary btn-sm" disabled>Approved</button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
