<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\includes\header.php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Esace University</title>
    <link rel="stylesheet" href="<?php echo (isset($is_admin) && $is_admin) ? '../assets/css/style.css' : 'assets/css/style.css'; ?>">
    <style>
        body{
            background:#a8a7a7;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        a {
            font-size: 19px;
            transition: .5s ease-in-out;
        }

        a:hover {
            font-size: 20px;
            padding: 10px 25px;
            color: #007bff;
            border-radius: 23px;
            background: #fff;
        }
    </style>
</head>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[data-confirm]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (!confirm(link.getAttribute('data-confirm'))) {
                    e.preventDefault();
                }
            });
        });
    });
</script>

<body>
    <header>
        <h1>Esace Clearance System</h1>
        <nav>
            <a href="<?php echo (isset($is_admin) && $is_admin) ? '../register.php' : 'register.php'; ?>">Register</a>
        </nav>
    </header>