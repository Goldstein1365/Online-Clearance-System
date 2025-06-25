<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\admin\reports.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/footer.php';

// Total requests
$total = $conn->query("SELECT COUNT(*) AS c FROM clearance_requests")->fetch_assoc()['c'];
$cleared = $conn->query("SELECT COUNT(*) AS c FROM clearance_requests WHERE status='cleared'")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) AS c FROM clearance_requests WHERE status='pending'")->fetch_assoc()['c'];
$rejected = $conn->query("SELECT COUNT(*) AS c FROM clearance_requests WHERE status='rejected'")->fetch_assoc()['c'];

// Requests per unit
$units = $conn->query("SELECT u.name, 
    SUM(cr.status='cleared') AS cleared, 
    SUM(cr.status='pending') AS pending, 
    SUM(cr.status='rejected') AS rejected
    FROM units u
    LEFT JOIN clearance_requests cr ON cr.unit_id = u.id
    GROUP BY u.id
    ORDER BY u.name");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Esace University</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .main {
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
        h2 {
            color: #007bff;
            font-size: 25px;
        }
        .main ul{
            margin-left: 100px;
            align-self: flex-start;
        }
        .main ul li{
            font-size: 19px;
        }
        .main ul li.total{
            font-size: 22px;
            color:#2d2d2e;
        }
        .main ul li.cleared{
            color: #04ad50;
        }
        .main ul li.pending{
            color:#ee9521;
        }
        .main ul li.rejected{
            color: #dc3545;
        }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <div class="main">
        <h2>Clearance Requests Report</h2>
        <ul>
            <li class="total"><strong>Total Requests:</strong> <?php echo $total; ?></li>
            <li class="cleared"><strong>Cleared:</strong> <?php echo $cleared; ?></li>
            <li class="pending"><strong>Pending:</strong> <?php echo $pending; ?></li>
            <li class="rejected"><strong>Rejected:</strong> <?php echo $rejected; ?></li>
        </ul>
        <h3>Requests Per Unit</h3>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Unit</th>
                <th>Cleared</th>
                <th>Pending</th>
                <th>Rejected</th>
            </tr>
            <?php while ($row = $units->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['cleared']; ?></td>
                    <td><?php echo $row['pending']; ?></td>
                    <td><?php echo $row['rejected']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>