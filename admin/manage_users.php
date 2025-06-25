<?php
// filepath: c:\Users\Goldstein\Desktop\OCS1\admin\manage_users.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/footer.php';

// Handle hard delete (remove from DB)
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM students WHERE user_id=$id");
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: manage_users.php");
    exit();
}

// Handle activation/deactivation toggle
if (isset($_GET['toggle']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $toggle = ($_GET['toggle'] === 'activate') ? 'active' : 'inactive';
    $conn->query("UPDATE users SET status='$toggle' WHERE id=$id");
    header("Location: manage_users.php");
    exit();
}

// Fetch all users (active and inactive)
$users = $conn->query("SELECT id, name, email, role, status FROM users ORDER BY role, name");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Esace University</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .main {
            margin-left: 100px;
            padding: 20px;
        }

        .main h2 {
            color: #007bff;
            font-size: 27px;
        }

        .main a {
            text-decoration: none;
            color: #28a745;
            font-weight: 600;
            font-size: 19px;
        }

        .main table td a {
            color: #a8541c;
        }

        .inactive {
            color: #aaa;
        }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <div class="main">
        <h2>Manage Users</h2>
        <a href="add_users.php" style="margin-bottom:10px;display:inline-block;">Add New User</a>
        <table border="1" cellpadding="20" cellspacing="0">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $users->fetch_assoc()): ?>
                <tr class="<?php echo $row['status'] === 'inactive' ? 'inactive' : ''; ?>">
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo ucfirst($row['role']); ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] === 'active'): ?>
                            <a href="?toggle=deactivate&id=<?php echo $row['id']; ?>" style="color:#d17205;">Deactivate</a>
                        <?php else: ?>
                            <a href="?toggle=activate&id=<?php echo $row['id']; ?>" style="color:#28a745;">Activate</a>
                        <?php endif; ?>
                        | <a href="?delete=1&id=<?php echo $row['id']; ?>" style="color:#f00;" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>

<?php include '../includes/footer.php'; ?>