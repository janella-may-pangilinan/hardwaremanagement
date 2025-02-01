<?php
// Example of add hardware form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Hardware</title>
</head>
<body>
    <h1>Add New Hardware</h1>
    <form action="process_add_hardware.php" method="POST">
        <label for="name">Hardware Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        
        <label for="location">Location:</label><br>
        <input type="text" id="location" name="location" required><br>
        
        <label for="status">Status:</label><br>
        <select id="status" name="status">
            <option value="available">Available</option>
            <option value="maintenance">In Maintenance</option>
        </select><br>

        <input type="submit" value="Add Hardware">
    </form>
</body>
</html>
