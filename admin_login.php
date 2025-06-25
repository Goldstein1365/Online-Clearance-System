<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Esace University</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background: white;
            width: 500px;
            max-width: 100%;
            margin: 70px auto;
            padding: 50px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input,
        button,
        select {
            outline: none;
            display: block;
            border: 1px solid #333;
            border-radius: 20px;
            width: 70%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 17px;
            transition: .5s;
        }

        button:hover {
            cursor: pointer;
            font-size: 20px;
        }

        p>a {
            text-decoration: none;
            color: #007bff;
            font-size: 17px;
        }
    </style>
</head>

<body>

    <h2 style="text-align: center;">Admin Login</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red; text-align:center;'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>

    <form action="login.php" method="POST">
        <label>Role:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="officer">Officer</option>
        </select>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <input type="password" name="admin_passkey" placeholder="Admin Passkey" required>
        <button type="submit" class="btn" name="login">Login</button>
        <p>Go to Homepage <a href="login.php">Login</a></p>
    </form>

</html>