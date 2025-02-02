<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
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

       
        .register-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 70px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 450px;
            backdrop-filter: blur(10px);
        }

        .register-box h2 {
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

        .register-btn {
            background: #28a745;
            color: white;
        }
        .register-btn:hover {
            background: #218838;
        }

        
        .message {
            font-size: 14px;
        }

        .error {
            color: #ff4d4d;
            margin-bottom: 10px;
        }

        .success {
            color: #28a745;
            margin-bottom: 10px;
        }

        
        a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            margin-top: 15px;
            display: inline-block;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-box">
    <h2>Register</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="message error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <p class="message success"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>

    <form action="register_handler.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit" class="register-btn">Register</button>
    </form>

    <a href="index.php">Back to Login</a>
</div>

</body>
</html>
