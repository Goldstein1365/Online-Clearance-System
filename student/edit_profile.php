<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/student_sidebar.php';
include '../includes/footer.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM students WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

if (isset($_POST['save'])) {
    $full_name = $_POST['full_name'];
    $reg_no = $_POST['reg_no'];
    $student_no = $_POST['student_no'];
    $programme = $_POST['programme'];
    $department = $_POST['department'];
    $level = $_POST['level'];
    $hall = $_POST['hall'];

    // Handle optional file uploads
    $update_passport = "";
    if (!empty($_FILES["passport"]["name"])) {
        $passport_file = time() . "_" . basename($_FILES["passport"]["name"]);
        $target_dir = "../uploads/";
        $passport_target = $target_dir . $passport_file;
        move_uploaded_file($_FILES["passport"]["tmp_name"], $passport_target);
        $update_passport = ", passport='$passport_file'";
    }
    $update_signature = "";
    if (!empty($_FILES["signature"]["name"])) {
        $signature_file = time() . "_" . basename($_FILES["signature"]["name"]);
        $target_dir = "../uploads/";
        $signature_target = $target_dir . $signature_file;
        move_uploaded_file($_FILES["signature"]["tmp_name"], $signature_target);
        $update_signature = ", signature='$signature_file'";
    }

    $sql = "UPDATE students SET 
        full_name='$full_name', reg_no='$reg_no', student_no='$student_no',
        programme='$programme', department='$department', level='$level', hall='$hall'
        $update_passport $update_signature
        WHERE user_id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?msg=Profile updated");
        exit();
    } else {
        $error = "Error updating profile: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Esace University</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        h2 {
            color: #007bff;
            font-size: 25px;
        }

        .container {
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

        form {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            flex-direction: column;
            background: white;
            align-self: flex-start;
        }

        form span {
            padding: 8px;
            display: flex;
            align-items: center;
            font-size: 18px;
            width: 100%;
        }


        form span label {
            flex: 1;
            font-weight: 600;
            font-size: 17px;
        }

        form span input {
            outline: none;
            background: none;
            border: none;
            width: 200px;
            border-bottom: 1px solid #888;
            margin-bottom: 10px;
            font-size: 17px;
        }

        .btn {
            align-self: flex-end;
            background: #007bff;
            color: #fff;
            font-size: 16px;
            border: none;
            margin-top: 10px;
            padding: 10px 15px;
            border-radius: 20px;
            transition: 0.5s ease-in-out;
            cursor: pointer;
        }

        .btn:hover {
            padding: 12px 17px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Your Profile</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <span>
                <label>Full Name:</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required>
            </span>

            <span>
                <label>Registration Number:</label>
                <input type="text" name="reg_no" value="<?= htmlspecialchars($student['reg_no']) ?>" required>
            </span>

            <span>
                <label>Student Number:</label>
                <input type="text" name="student_no" value="<?= htmlspecialchars($student['student_no']) ?>" required>
            </span>

            <span><label>Programme:</label>
                <input type="text" name="programme" value="<?= htmlspecialchars($student['programme']) ?>" required></span>

            <span><label>Department:</label>
                <input type="text" name="department" value="<?= htmlspecialchars($student['department']) ?>" required>
            </span>

            <span><label>Level:</label>
                <input type="text" name="level" value="<?= htmlspecialchars($student['level']) ?>" required></span>

            <span><label>Hall of Residence:</label>
                <input type="text" name="hall" value="<?= htmlspecialchars($student['hall']) ?>" required></span>

            <span><label>Change Signature (.png/.jpg):</label>
                <input type="file" name="signature" accept="image/png, image/jpeg"><br></span>

            <span><label>Change Passport (.png/.jpg):</label>
                <input type="file" name="passport" accept="image/png, image/jpeg"><br></span>

            <button type="submit" name="save" class="btn">Save Changes</button>
        </form>
    </div>
</body>

</html>