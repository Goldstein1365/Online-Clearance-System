<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$student_id = $_SESSION['user_id'];
$unit_id = intval($_POST['unit']);
$remarks = $conn->real_escape_string($_POST['remarks']);

// Check for existing pending or cleared request for this unit
$exists = $conn->query("SELECT id, status FROM clearance_requests WHERE student_id=$student_id AND unit_id=$unit_id AND status IN ('pending','cleared')");
if ($exists->num_rows > 0) {
    $_SESSION['notif_type'] = 'error';
    $_SESSION['notif_msg'] = 'You have already submitted a request for this unit. Please wait for it to be processed before submitting again.';
    header("Location: dashboard.php");
    exit();
}

// Insert new request
$conn->query("INSERT INTO clearance_requests (student_id, unit_id, remarks, status, date_submitted) VALUES ($student_id, $unit_id, '$remarks', 'pending', NOW())");

$_SESSION['notif_type'] = 'success';
$_SESSION['notif_msg'] = 'Your clearance request has been submitted successfully!';
header("Location: dashboard.php");
exit();
?>