<?php
session_start();
require_once '../includes/db_connect.php';

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../Signin_SignUp.php");
    exit();
}

// Fetch all flipbooks
$sql = "SELECT f.*, u.username FROM flipbooks f JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$flipbooks = $stmt->fetchAll();

// Fetch all users
$sql_users = "SELECT * FROM users ORDER BY username";
$stmt_users = $pdo->prepare($sql_users);
$stmt_users->execute();
$users = $stmt_users->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PDF Flipbook</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Admin Dashboard</h2>
        
        <h3 class="mt-4">All Flipbooks</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>User</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flipbooks as $flipbook): ?>
                <tr>
                    <td><?php echo htmlspecialchars($flipbook['title']); ?></td>
                    <td><?php echo htmlspecialchars($flipbook['username']); ?></td>
                    <td><?php echo $flipbook['created_at']; ?></td>
                    <td>
                        <a href="../view_flipbook.php?id=<?php echo $flipbook['id']; ?>" class="btn btn-sm btn-primary">View</a>
                        <a href="delete_flipbook.php?id=<?php echo $flipbook['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this flipbook?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="mt-4">All Users</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>