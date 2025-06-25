<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';
include '../includes/body.php';
include '../includes/student_sidebar.php';

$user_id = $_SESSION['user_id'];

// Check if student profile is completed
$profile = $conn->query("SELECT * FROM students WHERE user_id='$user_id'");
if ($profile->num_rows == 0) {
    header("Location: complete_profile.php");
    exit();
}
$student = $profile->fetch_assoc();

// Calculate clearance progress
$total_units = $conn->query("SELECT COUNT(*) AS total FROM units")->fetch_assoc()['total'];
$cleared_units = $conn->query("SELECT COUNT(*) AS cleared FROM clearance_requests WHERE student_id=$user_id AND status='cleared'")->fetch_assoc()['cleared'];
$progress = $total_units > 0 ? round(($cleared_units / $total_units) * 100) : 0;
$bar_color = $progress == 100 ? '#4caf50' : ($progress >= 50 ? '#ffc107' : '#f44336');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esace University</title>
    <style>
        .progress-container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto 10px auto;
            background: #eee;
            border-radius: 20px;
            height: 30px;
            box-shadow: 0 1px 4px #ccc;
        }
        .progress-bar {
            height: 30px;
            border-radius: 20px;
            text-align: center;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
            line-height: 30px;
            transition: width 0.5s;
        }
        h2{
            color: #04ad50;
            font-size: 25px;
        }
        .clearance{
            display: flex;
            align-items: center;
            gap: 30px;
        }
        .clearance-card{
            border: 1px solid #999;
            padding: 10px 20px;
            flex: .7;
        }
        .clearance-card h3{
            color: #007bff;
            font-size: 23px;
        }
        .clearance-card img{
            border-radius: 50%;
        }
        .clearance-card p{
            border-bottom: 1px solid #808285;
            padding: 8px;
            display: flex;
            align-items: center;
            font-size: 18px;
        }
        .clearance-card p strong{
            flex: .7;
        }
        .clearance-card p span{
            flex: .7;
            font-weight: 600;
        }
        .clearance-table{
            padding: 10px 20px;
            flex: 1;
            margin-right: 60px;
            background:#b9b9cc;
        }
        .clearance-table h3{
            color: #007bff;
            font-size: 23px;
        }
        .clearance-table table{
            text-align: left;
            width: 100%;
            max-width: 100%;
        }
        .clearance-table table th{
            text-align: left;
            font-weight: 700;
            font-size: 20px;
        }
        .clearance-table table td{
            font-weight: 600;
            text-align: left;
            border-bottom: 1px solid #808285;
        }
    </style>
</head>
<body>
    <!-- Progress Bar -->
    <div class="progress-container">
        <div class="progress-bar" style="width:<?= $progress ?>%; background:<?= $bar_color ?>;">
            <?= $progress ?>% Cleared
        </div>
    </div>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h2>

<!-- Student Clearance Card -->
<div class="clearance">
    <div class="clearance-card">
        <h3>🎓 Student Clearance Card</h3>
        <img src="../uploads/<?= $student['passport'] ?>" alt="Passport" height="100" width="100"><br><br>
        <!-- <img src="../uploads/<?= $student['signature'] ?>" alt="Signature" height="40"><br><br> -->
        <p><strong>Name:</strong> <span><?= htmlspecialchars($student['full_name']) ?></span></p>
        <p><strong>Registration No:</strong> <span><?= htmlspecialchars($student['reg_no']) ?></span></p>
        <p><strong>Student No:</strong> <span><?= htmlspecialchars($student['student_no']) ?></span></p>
        <p><strong>Programme:</strong> <span><?= htmlspecialchars($student['programme']) ?></span></p>
        <p><strong>Department:</strong> <span><?= htmlspecialchars($student['department']) ?></span></p>
        <p><strong>Level:</strong> <span><?= htmlspecialchars($student['level']) ?></span></p>
        <p><strong>Hall:</strong> <span><?= htmlspecialchars($student['hall']) ?></span></p>
    </div>
    <div class="clearance-table">
        <h3>STUDENT CLEARANCE STATUS</h3>
        <table cellpadding="12" cellspacing="0">
            <tr>
                <th>CLEARANCE UNIT</th>
                <th>STATUS</th>
            </tr>
            <?php
            $units = $conn->query("SELECT id, name FROM units");
            while ($unit = $units->fetch_assoc()) {
                $unit_id = $unit['id'];
                $status = $conn->query("SELECT status FROM clearance_requests WHERE student_id=$user_id AND unit_id=$unit_id ORDER BY id DESC LIMIT 1");
                $stat = $status->fetch_assoc();
                echo "<tr>";
                echo "<td>" . htmlspecialchars($unit['name']) . "</td>";
                echo "<td style='text-align:center;'>";
                if ($stat && $stat['status'] === 'cleared') {
                    echo "&#10003;"; // check mark
                } else {
                    echo "-";
                }
                echo "</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<!-- Notifications and other content remain unchanged -->
<?php
$notis = $conn->query("SELECT id, message, created_at FROM notifications WHERE user_id=$user_id AND is_read=0 ORDER BY created_at DESC");
if ($notis->num_rows > 0): ?>
    <div style="background:#e9f7ef; border:1px solid #28a745; padding:10px; margin-bottom:15px;">
        <strong>Notifications:</strong>
        <ul>
            <?php while ($n = $notis->fetch_assoc()): ?>
                <li><?php echo htmlspecialchars($n['message']); ?> <small>(<?php echo $n['created_at']; ?>)</small></li>
            <?php endwhile; ?>
        </ul>
    </div>
<?php endif;

// Mark notifications as read
$conn->query("UPDATE notifications SET is_read=1 WHERE user_id=$user_id AND is_read=0");
?>

<?php
if (isset($_SESSION['notif_msg'])):
    $type = $_SESSION['notif_type'] ?? 'success';
    $msg = $_SESSION['notif_msg'];
    unset($_SESSION['notif_msg'], $_SESSION['notif_type']);
?>
<div id="notif-toast" class="notif-toast <?= $type ?>">
    <?= htmlspecialchars($msg) ?>
</div>
<script>
    setTimeout(function() {
        document.getElementById('notif-toast').style.display = 'none';
    }, <?= $type === 'error' ? 10000 : 5000 ?>);
</script>
<style>
    .notif-toast {
        position: fixed;
        top: 30px;
        right: 30px;
        min-width: 320px;
        max-width: 400px;
        padding: 18px 28px;
        border-radius: 8px;
        color: #fff;
        font-size: 18px;
        z-index: 9999;
        box-shadow: 0 2px 12px rgba(0,0,0,0.15);
        animation: fadeIn 0.5s;
    }
    .notif-toast.success { background: #28a745; }
    .notif-toast.error { background: #d32f2f; }
    @keyframes fadeIn {
        from { opacity: 0; top: 0; }
        to { opacity: 1; top: 30px; }
    }
</style>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>