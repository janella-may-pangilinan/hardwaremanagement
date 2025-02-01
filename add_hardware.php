<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $status = $_POST['status'];

    $query = "INSERT INTO hardware (name, type, status) VALUES ('$name', '$type', '$status')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Hardware added successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Add New Hardware</h2>
        <form action="" method="POST" class="space-y-4">
            <input type="text" name="name" placeholder="Hardware Name" class="w-full px-4 py-2 border rounded-md" required>
            <input type="text" name="type" placeholder="Type (e.g., Laptop, Printer)" class="w-full px-4 py-2 border rounded-md" required>
            <select name="status" class="w-full px-4 py-2 border rounded-md" required>
                <option value="available">Available</option>
                <option value="in-use">In Use</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600">Add Hardware</button>
        </form>
    </div>
</body>
</html>
