<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Signin_SignUp.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $public = isset($_POST['public']) ? 1 : 0;

    $target_dir = "assets/uploads/";
    $target_file = $target_dir . basename($_FILES["pdfFile"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if($fileType != "pdf") {
        $error = "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO flipbooks (user_id, filename, title, password, public) VALUES (:user_id, :filename, :title, :password, :public)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'user_id' => $_SESSION['user_id'],
                'filename' => basename($_FILES["pdfFile"]["name"]),
                'title' => $title,
                'password' => $password,
                'public' => $public
            ]);
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF - PDF Flipbook</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Upload PDF</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Flipbook Title" required>
            <input type="file" name="pdfFile" accept=".pdf" required>
            <input type="password" name="password" placeholder="Password (optional)">
            <label><input type="checkbox" name="public" value="1"> Make public</label>
            <button type="submit">Upload</button>
        </form>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>