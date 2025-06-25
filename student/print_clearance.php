<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\students\print_clearance.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$student_id = $_SESSION['user_id'];
$student = $conn->query("SELECT name, email FROM users WHERE id=$student_id")->fetch_assoc();
$requests = $conn->query("SELECT un.name AS unit_name, cr.status, cr.date_processed
    FROM clearance_requests cr
    JOIN units un ON cr.unit_id = un.id
    WHERE cr.student_id = $student_id");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Esace University</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fff; color: #222; }
        .print-btn { margin: 20px 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Student Clearance Form</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
    <table>
        <tr>
            <th>Unit</th>
            <th>Status</th>
            <th>Date Cleared</th>
        </tr>
        <?php while($row = $requests->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['unit_name']); ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['date_processed']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <button class="print-btn" onclick="window.print()">Print</button>
</body>
</html>