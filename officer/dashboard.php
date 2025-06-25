<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\officer\dashboard.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'officer') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

// Get the unit assigned to this officer
$officer_id = $_SESSION['user_id'];
$unit = $conn->query("SELECT id, name FROM units WHERE officer_id=$officer_id")->fetch_assoc();

if (!$unit) {
    echo "<p>You are not assigned to any unit.</p>";
    exit();
}

// Only fetch requests for the officer's unit
$requests = $conn->query("SELECT cr.*, s.full_name, s.reg_no, s.student_no, s.programme FROM clearance_requests cr
    JOIN students s ON cr.student_id = s.user_id
    ORDER BY cr.date_submitted DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Esace University</title>
    <style>
        .sidebar {
            width: 200px;
            float: left;
            background: #222;
            color: #fff;
            height: 100vh;
        }

        .sidebar a {
            color: #fff;
            display: block;
            padding: 15px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #444;
        }

        .main {
            margin-left: 210px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #2196f3;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3 style="padding:15px;"> <?= htmlspecialchars($_SESSION['name']) ?> </h3>
        <a href="dashboard.php">Home</a>
        <!-- <a href="cleared.php">Cleared Students</a> -->
        <!-- <a href="rejected.php">Rejected Requests</a> -->
        <a href="./logout.php">Logout</a>
    </div>
    <div class="main">
        <h2>Clearance Unit: <?= htmlspecialchars($unit['name']) ?></h2>
        <table>
            <tr>
                <th>Reg No</th>
                <th>Student No</th>
                <th>Student Name</th>
                <th>Program</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $requests->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['reg_no']) ?></td>
                    <td><?= htmlspecialchars($row['student_no']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['programme']) ?></td>
                    <td>
                        <?php if ($row['status'] === 'pending'): ?>
                            <form action="update_request.php" method="POST" style="display:inline;">
                                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="action" value="cleared">Approve</button>
                                <button type="submit" name="action" value="rejected">Reject</button>
                            </form>
                        <?php else: ?>
                            <?= ucfirst($row['status']) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>