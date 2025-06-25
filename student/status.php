<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\student\status.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}
// include '../includes/header.php';
include '../includes/db.php';
include '../includes/student_sidebar.php';

$student_id = $_SESSION['user_id'];
$sql = "SELECT cr.id, un.name AS unit_name, cr.status, cr.remarks, cr.date_submitted, cr.date_processed
        FROM clearance_requests cr
        JOIN units un ON cr.unit_id = un.id
        WHERE cr.student_id = $student_id
        ORDER BY cr.date_submitted DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esace University</title>
    <style>
        .container {
            margin: 100px;
        }

        .print {
            margin-top: 55px;
            background: #007bff;
            color: #fff;
            padding: 8px 16px;
            border-radius: 3px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Your Clearance Requests</h2>
        <?php if ($result->num_rows > 0): ?>
            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>Unit</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Date Submitted</th>
                    <th>Date Processed</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['unit_name']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                        <td><?php echo htmlspecialchars($row['remarks']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_submitted']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_processed']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>You have not submitted any clearance requests yet.</p>
        <?php endif; ?>
        <?php
        // Check if all requests are cleared
        $allCleared = true;
        $check = $conn->query("SELECT status FROM clearance_requests WHERE student_id = $student_id");
        if ($check->num_rows > 0) {
            while ($row = $check->fetch_assoc()) {
                if ($row['status'] !== 'cleared') {
                    $allCleared = true;
                    break;
                }
            }
            if ($allCleared) {
                echo '<a href="print_clearance.php" target="_blank" class="print">Print Clearance Form</a>';
            }
        }
        ?>
    </div>
</body>

</html>