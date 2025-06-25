<?php
session_start();
include '../includes/db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['save'])) {
    $user_id = $_SESSION['user_id'];
    $full_name = $_POST['full_name'];
    $reg_no = $_POST['reg_no'];
    $student_no = $_POST['student_no'];
    $programme = $_POST['programme'];
    $department = $_POST['department'];
    $level = $_POST['level'];
    $hall = $_POST['hall'];

    // Check file uploads
    if (!isset($_FILES['signature']) || $_FILES['signature']['error'] !== UPLOAD_ERR_OK) {
        echo "Signature upload failed.";
        exit();
    }
    if (!isset($_FILES['passport']) || $_FILES['passport']['error'] !== UPLOAD_ERR_OK) {
        echo "Passport upload failed.";
        exit();
    }

    // Signature upload
    $target_dir = "../uploads/";
    $file_name = time() . "_" . basename($_FILES["signature"]["name"]);
    $target_file = $target_dir . $file_name;
    if (!move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file)) {
        echo "Failed to upload signature file.";
        exit();
    }

    // Passport upload
    $passport_file = time() . "_" . basename($_FILES["passport"]["name"]);
    $passport_target = $target_dir . $passport_file;
    if (!move_uploaded_file($_FILES["passport"]["tmp_name"], $passport_target)) {
        echo "Failed to upload passport file.";
        exit();
    }

    // Save to DB
    $sql = "INSERT INTO students (user_id, full_name, reg_no, student_no, programme, department, level, hall, passport, signature) 
            VALUES ('$user_id', '$full_name', '$reg_no', '$student_no', '$programme', '$department', '$level', '$hall', '$passport_file', '$file_name')
            ON DUPLICATE KEY UPDATE 
                full_name='$full_name', reg_no='$reg_no', student_no='$student_no',
                programme='$programme', department='$department', level='$level',
                hall='$hall', passport='$passport_file', signature='$file_name'";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
        exit();
    }
    $conn->close();
}
