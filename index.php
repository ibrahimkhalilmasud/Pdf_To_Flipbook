<?php
session_start();
require_once 'includes/db_connect.php';

// Comment out the public flipbooks query for now
/*
// Fetch public flipbooks (assuming we add a 'public' column to the flipbooks table)
$sql = "SELECT f.id, f.title, u.username FROM flipbooks f JOIN users u ON f.user_id = u.id WHERE f.public = 1 ORDER BY f.created_at DESC LIMIT 5";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$public_flipbooks = $stmt->fetchAll();
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VisinoAg</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top custom-nav sticky">
        <div class="container">
            <a class='navbar-brand logo' href='index.php'>
                <h1>VisinoAg</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item active">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="about.php" class="nav-link">About</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Achievements</a>
                    </li> -->
                    <li class="nav-item">
                        <a href="Signin_SignUp.php" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="Signin_SignUp.php" class="nav-link">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="home-bg section h-100vh" id="home">
        <video class="bg-vid" autoplay loop muted>
            <source src="assets/video/video-bg.mp4" type="video/mp4">
        </video>
        <div class="bg-overlay"></div>
        <div class="container z-index">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="text-white text-center">
                        <h4>Hello & Welcome</h4>
                        <h1 class="header_title mb-0 mt-3">We have a lot of Luxurious <span class="element fw-bold" data-elements="Silk , Lace, and Embroidery."></span></h1>
                        <ul class="social_home list-unstyled text-center pt-4">
                            <li class="list-inline-item"><a href="javascript:void(0)"><i class="mdi mdi-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><i class="mdi mdi-linkedin"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><i class="mdi mdi-dribbble"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><i class="mdi mdi-google-plus"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><i class="mdi mdi-twitter"></i></a></li>
                        </ul>
                        <!-- <div class="header_btn">
                            <a href="javascript:void(0)" class="btn btn-outline-custom btn-rounded mt-4">Download CV</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="scroll_down">
            <a href="#about" class="scroll">
                <i class="mbri-arrow-down text-white"></i>
            </a>
        </div> -->
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/typed.js"></script>
    <script>
        $(".element").each(function() {
            var $this = $(this);
            $this.typed({
                strings: $this.attr('data-elements').split(','),
                typeSpeed: 100,
                backDelay: 3000
            });
        });
    </script>
</body>
</html>