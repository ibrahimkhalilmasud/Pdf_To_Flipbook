<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'PDF-to-Flipbook'; ?></title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/upload.php">Upload PDF</a></li>
                <li><a href="/library.php">My Library</a></li>
                <li><a href="/support.php">Support</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/profile.php">Profile</a></li>
                    <li><a href="/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="/Signin_SignUp.php">Sign In/Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>