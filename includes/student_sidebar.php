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

        .sidebar h1 {
            /* padding: 20px 15px 10px 15px; */
            margin-left: 20px;
            /* font-size: 1.1em; */
        }

        .sidebar a {
            color: #fff;
            display: block;
            margin-top: 30px;
            /* margin-left: 10px; */
            padding: 10px;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #444;
            border-radius: 0;
        }

        body {
            margin-left: 250px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h1>ECS</h1>
        <a href="/OCS1/student/dashboard.php" class="active">Home</a>
        <a href="request_clearance.php">Submit Clearance Request</a>
        <a href="status.php">View Clearance Status</a>
        <a href="edit_profile.php">Edit Profile</a>
        <a href="change_password.php">Change Password</a>
        <a href="./logout.php">Logout</a>
    </div>

</body>

</html>