<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'officer') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$request_id = intval($_POST['request_id']);
$action = ($_POST['action'] === 'cleared') ? 'cleared' : 'rejected';
$officer_id = $_SESSION['user_id'];

// Ensure the request belongs to this officer's unit
$unit = $conn->query("SELECT id FROM units WHERE officer_id=$officer_id")->fetch_assoc();
if (!$unit) {
    echo "You are not assigned to any unit.";
    exit();
}

// Check if the request is for this unit
$req = $conn->query("SELECT * FROM clearance_requests WHERE id=$request_id AND unit_id={$unit['id']}");
if ($req->num_rows === 0) {
    echo "You are not authorized to update this request.";
    exit();
}

// Update status
$conn->query("UPDATE clearance_requests SET status='$action' WHERE id=$request_id");

// Optionally, notify the student
$student_id = $req->fetch_assoc()['student_id'];
$msg = ($action === 'cleared') ? "Your clearance request has been cleared." : "Your clearance request has been rejected.";
$conn->query("INSERT INTO notifications (user_id, message) VALUES ($student_id, '$msg')");

header("Location: dashboard.php");
exit();
?>