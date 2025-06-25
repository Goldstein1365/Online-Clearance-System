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
        button {
            outline: none;
            display: block;
            border: 1px solid #333;
            border-radius: 20px;
            width: 70%;
            margin-bottom: 15px;
            padding: 10px; 
            cursor: pointer; 
            font-size: 17px;
            transition: .5s;
        }
        button:hover{
            font-size: 20px;
        }
        p > a{
            text-decoration: none;
            color: #007bff;
            font-size: 17px;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Student Login</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red; text-align:center;'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>

    <form action="login.php" method="POST">
        <input type="hidden" name="role" value="student">
        <label>Reg Number or Student Number:</label>
        <input type="text" name="student_identifier" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit" class="btn" name="login">Login</button>
        <p style="text-align:center;">Don't have an account? <a href="register.php">Register</a></p>
    </form>

</body>

</html>