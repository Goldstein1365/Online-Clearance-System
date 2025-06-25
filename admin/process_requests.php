<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/footer.php';

// Fetch all clearance requests with student and unit info
$sql = "SELECT cr.id, s.full_name, s.reg_no, s.student_no, s.programme, u.name AS unit_name, cr.status
        FROM clearance_requests cr
        JOIN students s ON cr.student_id = s.user_id
        JOIN units u ON cr.unit_id = u.id
        ORDER BY cr.date_submitted DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Esace University</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f7f7;
        }

        .sidebar {
            width: 220px;
            float: left;
            background: #222;
            color: #fff;
            height: 100vh;
        }

        .sidebar h3 {
            padding: 20px 15px 10px 15px;
            margin: 0;
            font-size: 1.1em;
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
            margin-left: 30px;
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #2196f3;
            color: #fff;
        }

        td {
            font-size: 0.98em;
        }

        .action {
            font-size: 18px;
            color: #2196f3;
            font-weight: bold;
            border: none;
            background: transparent;
            cursor: pointer;
            margin-right: 8px;
        }

        .action.reject {
            color: #d32f2f;
        }

        .status {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <div class="main">
        <h2 style="margin-bottom:20px;">Clearance Requests</h2>
        <table>
            <tr>
                <th>Reg No</th>
                <th>Student No</th>
                <th>Student Name</th>
                <th>Program</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['reg_no']) ?></td>
                    <td><?= htmlspecialchars($row['student_no']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['programme']) ?></td>
                    <td>
                        <?php if ($row['status'] === 'pending'): ?>
                            <form action="update_request.php" method="POST" style="display:inline;">
                                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="action" value="cleared" class="action">Approve</button>
                                <button type="submit" name="action" value="rejected" class="action reject">Reject</button>
                            </form>
                        <?php else: ?>
                            <span class="status"><?= ucfirst($row['status']) ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>