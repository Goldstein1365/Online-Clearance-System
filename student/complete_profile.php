<?php
session_start();
include '../includes/db.php';
include '../includes/body.php';
include '../includes/footer.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM students WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();
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
            margin-left: 50px;
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
        <h2>Complete Your Clearance Profile</h2>
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <span><label>Full Name:</label>
                <input type="text" name="full_name" required></span>

            <span><label>Registration Number:</label>
                <input type="text" name="reg_no" required></span>

            <span>
                <label>Student Number:</label>
                <input type="text" name="student_no" required>
            </span>

            <span><label>Programme:</label>
                <input type="text" name="programme" required>
            </span>
            <span>
                <label>Department:</label>
                <input type="text" name="department" required>
            </span>

            <span><label>Level:</label>
                <input type="text" name="level" required></span>

            <span><label>Hall of Residence:</label>
                <input type="text" name="hall" required></span>

            <span><label>Upload Signature (.png/.jpg):</label>
                <input type="file" name="signature" accept="image/png, image/jpeg" required></span>

            <span><label>Upload Passport (.png/.jpg):</label>
                <input type="file" name="passport" accept="image/png, image/jpeg" required></span>

            <button type="submit" name="save" class="btn">Submit</button>
        </form>
    </div>
</body>

</html>