<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Vendor</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #eef2f3, #8e9eab);
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
</style> 
<body>
    
    <?php include 'sidebar.php'; ?>
    
    <div class="flex justify-center w-full mt-10">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-lg w-full">
            <h1 class="text-2xl font-bold text-gray-700 mb-6 text-center">Add Vendor</h1>
            
            <form method="POST" action="add_vendor.php" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700" for="vendor_name">Vendor Name</label>
                    <input type="text" name="vendor_name" class="w-full py-2.5 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700" for="contact">Contact</label>
                    <input type="text" name="contact" class="w-full py-2.5 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700" for="hardware_type">Hardware Type</label>
                    <input type="text" name="hardware_type" class="w-full py-2.5 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                </div>
                
                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg text-lg hover:bg-blue-600">Add Vendor</button>
            </form>

            <div class="text-center mt-6">
                <a href="vendor_list.php" class="bg-green-500 text-white py-3 px-6 rounded-lg text-lg hover:bg-green-600">View List of Vendors</a>
            </div>
        </div>
    </div>

</body>
</html>
