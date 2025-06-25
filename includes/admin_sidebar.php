<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esace University</title>
    <style>
        .sidebar {
            width: 220px;
            float: left;
            background: #222;
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h3 {
            padding: 20px 15px 10px 15px;
            margin: 0;
            font-size: 1.5em;
        }

        .sidebar a {
            color: #fff;
            display: block;
            padding: 15px;
            font-size: 16px;
            text-decoration: none;
            transition: .5s ease-in-out;
        }

        .sidebar a:hover{
            font-size: 17px;
            background: #444;
            padding: 17px;
        }

        body {
            margin-left: 220px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3 style="padding:15px;">ECS</h3>
        <a href="/OCS1/admin/dashboard.php">Dashboard</a>
        <a href="/OCS1/admin/process_requests.php">Clearance Units</a>
        <a href="/OCS1/admin/manage_users.php">Student Accounts</a>
        <a href="/OCS1/admin/reports.php">Clearance Statistics</a>
        <a href="/OCS1/admin/student_clearance_list.php">Student Clearance List</a>
        <a href="./logout.php">Logout</a>
    </div>

</body>

</html>