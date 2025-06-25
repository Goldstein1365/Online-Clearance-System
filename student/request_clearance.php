<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\student\request_clearance.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}
// include '../includes/header.php';
include '../includes/student_sidebar.php';
include '../includes/db.php';

// Fetch units for dropdown
$units = $conn->query("SELECT id, name FROM units");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esace University</title>
    <style>
        .container {
            width: 800px;
            max-width: 100%;
            margin: 50px auto;
            padding: 50px 30px;
            border-radius: 17px;
            background: rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        h2{
            color: #007bff;
        }
        label{
            font-size: 17px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .btn {
            background: #007bff;
            color: #fff;
            font-size: 16px;
            border: none;
            margin-top: 20px;
            padding: 10px 15px;
            border-radius: 20px;
            transition: 0.5s ease-in-out;
            cursor: pointer;
        }
        .btn:hover{
            padding: 12px 17px;
        }
        select option{
            color: #222;
            font-size: 13px;
        }
        textarea,
        select{
            outline: none;
            padding: 10px 20px;
            border:1px  #999 solid;
            border-radius: 8px;
        }
        textarea{
            resize: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Submit Clearance Request</h2>
        <form action="submit_request.php" method="POST">
            <label for="unit">Select Unit:</label><br>
            <select name="unit" id="unit" required>
                <option value="">--Select Unit--</option>
                <?php while ($row = $units->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            </select><br><br>
            <label for="remarks">Remarks:</label><br>
            <textarea name="remarks" id="remarks" cols="30" rows="9"></textarea><br><br>
            <button type="submit" class="btn">Submit Request</button>
        </form>
    </div>
</body>

</html>
<?php include '../includes/footer.php'; ?>