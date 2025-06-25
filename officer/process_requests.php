<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\officer\process_requests.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'officer') {
    header("Location: ../login.php");
    exit();
}
include '../includes/header.php';
include '../includes/db.php';

$officer_id = $_SESSION['user_id'];
$sql = "SELECT cr.id, u.name AS student_name, un.name AS unit_name, cr.remarks, cr.date_submitted, cr.status
        FROM clearance_requests cr
        JOIN users u ON cr.student_id = u.id
        JOIN units un ON cr.unit_id = un.id
        WHERE cr.officer_id = $officer_id AND cr.status = 'pending'
        ORDER BY cr.date_submitted DESC";
$result = $conn->query($sql);
?>
<h2>Pending Clearance Requests</h2>
<?php if ($result->num_rows > 0): ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Student</th>
            <th>Unit</th>
            <th>Remarks</th>
            <th>Date Submitted</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['unit_name']); ?></td>
            <td><?php echo htmlspecialchars($row['remarks']); ?></td>
            <td><?php echo htmlspecialchars($row['date_submitted']); ?></td>
            <td>
                <form action="update_request.php" method="POST" style="display:inline;">
                    <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="action" value="cleared">
                    <button type="submit">Approve</button>
                </form>
                <form action="update_request.php" method="POST" style="display:inline;">
                    <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="action" value="rejected">
                    <button type="submit" style="background:#dc3545;">Reject</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No pending requests.</p>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>