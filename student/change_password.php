<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/body.php';
include '../includes/student_sidebar.php';
include '../includes/footer.php';

$user_id = $_SESSION['user_id'];
if (isset($_POST['change'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $user = $conn->query("SELECT password FROM users WHERE id=$user_id")->fetch_assoc();
    if (!password_verify($current, $user['password'])) {
        $error = "Current password is incorrect.";
    } elseif ($new !== $confirm) {
        $error = "New passwords do not match.";
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET password='$hash' WHERE id=$user_id");
        $success = "Password changed successfully.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Esace University</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        h2 {
            color: #007bff;
            font-size: 25px;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background: white;
            flex-wrap: wrap;
            width: 60%;
            margin: 30px auto;
            padding: 50px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            flex-direction: column;
            background: white;
            align-self: flex-start;
        }

        form span {
            padding: 8px;
            display: flex;
            align-items: center;
            font-size: 18px;
            width: 100%;
        }


        form span label {
            flex: 1;
            font-weight: 600;
            font-size: 17px;
        }

        form span input {
            outline: none;
            background: none;
            border: none;
            width: 200px;
            border-bottom: 1px solid #888;
            margin-bottom: 10px;
            font-size: 17px;
        }

        .btn {
            align-self: flex-end;
            background: #007bff;
            color: #fff;
            font-size: 16px;
            border: none;
            margin-top: 10px;
            padding: 10px 15px;
            border-radius: 20px;
            transition: 0.5s ease-in-out;
            cursor: pointer;
        }

        .btn:hover {
            padding: 12px 17px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <form action="" method="POST">
        <span><label>Current Password:</label>
        <input type="password" name="current_password" required></span>
        <span><label>New Password:</label>
        <input type="password" name="new_password" required></span>
       <span> <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required></span>
        <button type="submit" name="change" class="btn">Change Password</button>
    </form>
    </div>
</body>
</html>