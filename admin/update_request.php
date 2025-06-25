<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/footer.php';

$request_id = intval($_POST['request_id']);
$action = ($_POST['action'] === 'cleared') ? 'cleared' : 'rejected';

// Check if the request exists
$req = $conn->query("SELECT * FROM clearance_requests WHERE id=$request_id");
if ($req->num_rows === 0) {
    echo "Request not found.";
    exit();
}

// Update status
$conn->query("UPDATE clearance_requests SET status='$action' WHERE id=$request_id");

// Notify the student
$student_id = $req->fetch_assoc()['student_id'];
$msg = ($action === 'cleared') ? "Your clearance request has been cleared." : "Your clearance request has been rejected.";
$conn->query("INSERT INTO notifications (user_id, message) VALUES ($student_id, '$msg')");

header("Location: process_requests.php");
exit();
?>