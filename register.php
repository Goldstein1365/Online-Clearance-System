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

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background: white;
            width: 500px;
            max-width: 100%;
            margin: 30px auto;
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
            margin-bottom: 3px;
            padding: 10px;

            font-size: 17px;
            transition: .5s;
        }

        button:hover {
            cursor: pointer;
            font-size: 20px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-size: 17px;
        }
    </style>
</head>

<body>
    <h2>Student Registration</h2>
    <form action="register.php" method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Role:</label>
        <input type="text" name="role" placeholder="student, admin, officer" required><br>
        <button type="submit" class="btn" name="register">Register</button>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
    <?php
    if (isset($_POST['register'])) {
        include 'includes/db.php';
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        // Check if email exists
        $check = $conn->query("SELECT id FROM users WHERE email='$email'");
        if ($check->num_rows > 0) {
            echo "<p style='color:red;'>Email already registered.</p>";
        } else {
            $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
            if ($conn->query($sql)) {
                echo "<p style='color:green;'>Registration successful. <a href='login.php'>Login here</a></p>";
            } else {
                echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
            }
        }
        $conn->close();
    }
    ?>
</body>

</html>