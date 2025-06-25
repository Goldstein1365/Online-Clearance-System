<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_login.php");
    exit();
}
include '../includes/footer.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Esace University</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: url('../assets/img/campus.jpg') no-repeat center center fixed; background-size: cover; }
        .roles-container {
            background: rgba(255,255,255,0.85);
            margin: 40px auto;
            padding: 30px 40px;
            max-width: 700px;
            border-radius: 10px;
            text-align: center;
        }
        .role-btn {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            background: #2196f3;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            text-decoration: none;
        }
        .role-btn:hover { background: #1769aa; }
    </style>
</head>
<body>
    <div class="roles-container">
        <h2>Automated Clearance System</h2>
        <!-- <p>Kindly select the unit you belong to. Use your user-name and user-code / user id to log in</p> -->
        <div>
            <!-- <a href="dashboard.php?role=college_bursar" class="role-btn">College Bursar</a>
            <a href="dashboard.php?role=college_registrar" class="role-btn">College Registrar</a>
            <a href="dashboard.php?role=hall_residence" class="role-btn">Hall of Residence</a>
            <a href="dashboard.php?role=university_librarian" class="role-btn">University Librarian</a>
            <a href="dashboard.php?role=student_guild" class="role-btn">Student Guild</a>
            <a href="dashboard.php?role=police_post" class="role-btn">Police Post</a>
            <a href="dashboard.php?role=games_union" class="role-btn">Games Union</a>
            <a href="dashboard.php?role=university_hospital" class="role-btn">University Hospital</a>
            <a href="dashboard.php?role=dean_students" class="role-btn">Dean of Students</a>
            <a href="dashboard.php?role=university_bursar" class="role-btn">University Bursar</a> -->
            <a href="dashboard.php?role=system_admin" class="role-btn">System Admin</a>
        </div>
    </div>
</body>
</html>
