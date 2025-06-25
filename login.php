<?php
session_start();
include 'includes/db.php'; // Make sure this file sets up $conn

// Check if form was submitted
if (isset($_POST['login'])) {
    $role = $_POST['role'];
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $entered_passkey = $_POST['admin_passkey'];

    if ($role === 'admin') {
        $fixed_passkey = 'ECS5439'; // Use your real passkey
        $entered_passkey = $_POST['admin_passkey'] ?? '';
        if ($entered_passkey !== $fixed_passkey) {
            $_SESSION['error'] = "Invalid admin passkey.";
            header("Location: admin_login.php");
            exit();
        }
    }

    if ($role === 'student') {
        $identifier = $conn->real_escape_string(trim($_POST['student_identifier']));
        $password = $_POST['password'];

        // Find user by reg_no or student_no
        // $sql = "SELECT u.* FROM users u
        //         JOIN students s ON u.id = s.user_id
        //         WHERE (s.reg_no='$identifier' OR s.student_no='$identifier' OR s.email='$identifier') AND u.status='active'";
        
        $sql = "SELECT * FROM users WHERE email='$identifier' AND status='active'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];
                header("Location: student/dashboard.php");
                exit();
            } else {
                $_SESSION['error'] = "Invalid password.";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid reg number/student number or inactive account.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    } else {
        // Fetch user with matching email and active status
        $sql = "SELECT * FROM users WHERE email='$email' AND status='active'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Check if role matches and password is correct
            if ($user['role'] === $role && password_verify($password, $user['password'])) {
                // Start session and store user info
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];

                // Redirect based on role
                if ($user['role'] === 'student') {
                    header("Location: student/dashboard.php");
                } elseif ($user['role'] === 'officer') {
                    header("Location: officer/dashboard.php");
                } elseif ($user['role'] === 'admin') {
                    header("Location: admin/admin_roles.php"); // <-- REDIRECT TO ROLES PAGE
                } else {
                    // Unknown role, fallback
                    header("Location: index.php");
                }
                exit();
            } else {
                // Invalid credentials
                $_SESSION['error'] = "Invalid password or role mismatch.";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        } else {
            // Email not found or inactive
            $_SESSION['error'] = "Invalid credentials or inactive account.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    }
} else {
    // If accessed directly, redirect to index
    header("Location: index.php");
    exit();
}
?>
