<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - VisinoAg</title>
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
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a href="about.php" class="nav-link">About</a>
                    </li>
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
                        <h4>Welcome to VisinoAg</h4>
                        <h1 class="header_title mb-0 mt-3">Discover Our Passion for <span class="element fw-bold" data-elements="Innovation, Design, and Luxury."></span></h1>
                        <p class="pt-3">At VisinoAg, we are dedicated to providing you with the finest experience through our products and services. We believe in quality, care, and creating unique products that everyone can enjoy. Colorful, creative, and inspired by what we see every day, each product represents what we love about the world we live in. We hope they’ll inspire you too.</p>
                        <div class="header_btn">
                            <a href="javascript:void(0)" class="btn btn-outline-custom btn-rounded mt-4">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
