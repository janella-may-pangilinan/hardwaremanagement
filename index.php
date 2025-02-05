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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

       
        .login-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 75px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 450px;
            backdrop-filter: blur(10px);
        }

        .login-box h2 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 24px;
        }

       
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: none;
            border-radius: 8px;
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 16px;
            text-align: center;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        
        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn {
            background: #007BFF;
            color: white;
        }
        .login-btn:hover {
            background: #0056b3;
        }

        .register-btn {
            background: #28a745;
            color: white;
        }
        .register-btn:hover {
            background: #1e7e34;
        }

       
        .error {
            color: #ff4d4d;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Hardware Management System</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <form action="authenticate.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="login-btn">Login</button>
    </form>
    
    <form action="register.php" method="GET">
        <button type="submit" class="register-btn">Register</button>
    </form>
</div>

</body>
</html>
