<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\admin\dashboard.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/footer.php';


// Fetch stats
$units = $conn->query("SELECT COUNT(*) AS c FROM units")->fetch_assoc()['c'];
$students = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role='student'")->fetch_assoc()['c'];
$requests = $conn->query("SELECT COUNT(*) AS c FROM clearance_requests")->fetch_assoc()['c'];
$cleared = $conn->query("SELECT COUNT(DISTINCT student_id) AS c FROM clearance_requests WHERE status='cleared'")->fetch_assoc()['c'];

// Cleared students per unit for chart/table
$stats = $conn->query("SELECT u.name, COUNT(DISTINCT cr.student_id) AS cleared_count
    FROM units u
    LEFT JOIN clearance_requests cr ON u.id = cr.unit_id AND cr.status='cleared'
    GROUP BY u.id, u.name
    ORDER BY u.name");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Esace University</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .main {
            margin-left: 40px;
            padding: 20px;
        }

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            background: #2196f3;
            color: #fff;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
        }

        .card:nth-child(2) {
            background: #ffc107;
            color: #222;
        }

        .card:nth-child(3) {
            background: #4caf50;
        }

        .card:nth-child(4) {
            background: #f44336;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <div class="main">
        <h2>Dashboard / System Administrator Overview</h2>
        <div class="cards">
            <div class="card">
                <div style="font-size:2em;">🏛️</div>
                <div style="font-size:2em;"><?= $units ?></div>
                <div>Clearance Units</div>
            </div>
            <div class="card">
                <div style="font-size:2em;">👥</div>
                <div style="font-size:2em;"><?= $students ?></div>
                <div>Students in Total</div>
            </div>
            <div class="card">
                <div style="font-size:2em;">📄</div>
                <div style="font-size:2em;"><?= $requests ?></div>
                <div>Submitted Requests</div>
            </div>
            <div class="card">
                <div style="font-size:2em;">✅</div>
                <div style="font-size:2em;"><?= $cleared ?></div>
                <div>Fully Cleared Students</div>
            </div>
        </div>
        <h3>Cleared Student Statistics</h3>
        <table>
            <tr>
                <th>Clearance Unit</th>
                <th>Cleared Students</th>
            </tr>
            <?php while ($row = $stats->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['cleared_count'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>