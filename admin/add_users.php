<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\admin\add_user.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/admin_sidebar.php';
include '../includes/db.php';
include '../includes/footer.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email exists
    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $msg = "<p style='color:red;'>Email already exists.</p>";
    } else {
        $sql = "INSERT INTO users (name, email, password, role, status) VALUES ('$name', '$email', '$password', '$role', 'active')";
        if ($conn->query($sql)) {
            // Get the new user's ID
            $new_user_id = $conn->insert_id;

            // Set session variables
            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role === 'student') {
                header("Location: ../student/dashboard.php");
            } elseif ($role === 'officer') {
                header("Location: ../officer/dashboard.php");
            } elseif ($role === 'admin') {
                header("Location: ../admin/dashboard.php");
            }
            exit();
        } else {
            $msg = "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esace University</title>
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
            margin-left: 50px;
        }


        form span label {
            flex: 1;
            font-weight: 600;
            font-size: 17px;
        }

        form span input, select {
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
         p>a {
            margin-top: 25px;
            text-decoration: none;
            color: #007bff;
            font-size: 17px;
        }
    </style>
</head>

<body>
   <div class="container">
     <h2>Add New User</h2>
    <form method="POST" action="">
        <span><label>Name:</label>
            <input type="text" name="name" required><br><br>
            </span>
        <span><label>Email:</label><input type="email" name="email" required><br><br>
            </span>
            <span><label>Password:</label>
        <input type="password" name="password" required><br><br></span>
        <span><label>Role:</label>
        <select name="role" required>
            <option value="student">Student</option>
            <option value="officer">Officer</option>
            <option value="admin">Admin</option>
        </select><br><br></span>
        <button type="submit" class="btn">Add User</button>
    </form>
    <?php echo $msg; ?>
<p><a href="manage_users.php">Back to Manage Users</a></p>
   </div>
</body>

</html>


<?php include '../includes/footer.php'; ?>