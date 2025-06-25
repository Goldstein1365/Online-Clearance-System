<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/footer.php';

// Fetch all students
$students = $conn->query("SELECT s.user_id, s.full_name, s.reg_no FROM students s JOIN users u ON s.user_id = u.id WHERE u.role='student'");

// Get total number of units
$total_units = $conn->query("SELECT COUNT(*) AS c FROM units")->fetch_assoc()['c'];
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
            /* background: white; */
            flex-wrap: wrap;
            flex: 1;
            /* width: 60%; */
            margin: 30px;
           
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            font-size: 25px;
        }
        .progress-bar {
            /* width: 100%; */
            height: 20px;
            border-radius: 5px;
            background: #eee;
            width: 100%;
        }
        table{
            text-align: left;
        }

        .progress {
            height: 100%;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            font-weight: bold;
        }

        .progress.green {
            background: #4caf50;
        }

        .progress.yellow {
            background: #ffc107;
            color: #222;
        }

        .progress.red {
            background: #f44336;
        }

        .edit-btn {
            margin-left: 15px;
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 5px 15px;
            font-weight: bold;
            cursor: pointer;
        }
        table{
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <div class="main">
        <h2>Student Clearance List</h2>
        <table cellpadding="5" cellspacing="0">
            <tr>
                <th>Name</th>
                <th>Registration Number</th>
                <th>Clearance status</th>
                <th>Action</th>
            </tr>
            <?php while ($student = $students->fetch_assoc()):
                $student_id = $student['user_id'];
                // Count cleared units for this student
                $cleared = $conn->query("SELECT COUNT(*) AS c FROM clearance_requests WHERE student_id=$student_id AND status='cleared'")->fetch_assoc()['c'];
                $percent = $total_units > 0 ? round(($cleared / $total_units) * 100) : 0;
                $bar_class = $percent == 100 ? 'green' : ($percent >= 50 ? 'yellow' : 'red');
            ?>
                <tr>
                    <td><?= htmlspecialchars($student['full_name']) ?></td>
                    <td><?= htmlspecialchars($student['reg_no']) ?></td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress <?= $bar_class ?>" style="width:<?= $percent ?>%;">
                                <?= $percent ?>% cleared
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="../404.php" class="edit-btn">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>