<?php
session_start();
$home = "/OCS1/index.php";
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $home = "/OCS1/admin/dashboard.php";
    } elseif ($_SESSION['role'] === 'student') {
        $home = "/OCS1/student/dashboard.php";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>404 Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            text-align: center;
            margin-top: 100px;
        }

        h1 {
            color: #dc3545;
            font-size: 60px;
        }

        p {
            font-size: 22px;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <h1>404</h1>
    <p>Sorry, the page you are looking for does not exist.</p>
    <a href="<?= $home ?>">Go to Home</a>
</body>

</html>
