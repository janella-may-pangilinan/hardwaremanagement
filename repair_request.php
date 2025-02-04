    <?php
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $hardware_id = $_POST['hardware_id'];
        $issue = $_POST['issue'];

        $query = "INSERT INTO maintenance_requests (hardware_id, issue, status) VALUES ('$hardware_id', '$issue', 'pending')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Repair request submitted!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    $hardware_query = mysqli_query($conn, "SELECT * FROM hardware WHERE status != 'maintenance'");
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Repair Request</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body{
                background: linear-gradient(to right, #eef2f3, #8e9eab);
            }
        </style>
    </head>
    <body class="bg-gray-100 p-10">
        <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Create Repair Request</h2>
            <form action="" method="POST" class="space-y-4">
                <select name="hardware_id" class="w-full px-4 py-2 border rounded-md" required>
                    <option value="">Select Hardware</option>
                    <?php while ($hardware = mysqli_fetch_assoc($hardware_query)) { ?>
                        <option value="<?php echo $hardware['id']; ?>"><?php echo $hardware['name']; ?></option>
                    <?php } ?>
                </select>
                <textarea name="issue" placeholder="Describe the issue" class="w-full px-4 py-2 border rounded-md" required></textarea>
                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-lg shadow hover:bg-yellow-600">Submit Request</button>
            </form>
        </div>
    </body>
    </html>
