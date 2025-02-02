<?php
session_start();
include 'db.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 100px; }
        .login-box { width: 300px; padding: 20px; margin: auto; border: 1px solid #ddd; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 5px 0; }
        button { width: 100%; padding: 10px; background: #007BFF; color: white; border: none; }
        .register { background: #28a745; margin-top: 10px; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <form action="authenticate.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <form action="register.php" method="GET">
        <button type="submit" class="register">Register</button>
    </form>
</div>

</body>
</html>
