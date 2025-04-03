<?php
session_start();
require_once 'setup_database.php';
$user = null;
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $conn = new mysqli($servername, $username, $password, $db);
  $query = "SELECT username, email, profile_picture, offcanvas_color FROM users WHERE user_id = '$user_id'";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $user = mysqli_fetch_assoc($result);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - IncredibleIndia Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <style>
        /* Icon Boxes */
        .icon-box {
            text-align: center;
            padding: 20px;
            opacity: 0;
            animation: fadeInUp 1.5s forwards;
        }

        .icon-box i {
            font-size: 40px;
            color: #ff9800;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }

        .icon-box:hover i {
            transform: scale(1.2);
        }

        /* Why Choose Us Section */
        .why-choose-us-section h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
            animation: fadeInUp 2s ease-out;
        }

        .why-choose-us-section p {
            font-size: 1.1rem;
            animation: fadeInUp 2s ease-out 0.5s;
        }

        /* Footer */
        footer {
            opacity: 0;
            animation: fadeInUp 2s forwards;
        }

        .footer {
            background-repeat: no-repeat;
            background-position: center center;
            background-color: #040E27;
            position: relative;
            margin-top: 50px;
            z-index: 0;
            top: 0px;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="hotel position-relative">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-sm  navbar-dark fixed-top">
            <div class="container-fluid">
                <div class="logo">
                    <img src="images/INCRIDEBLE INDIA TOURS.jpg" alt="">
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsenav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end h5 text-light" id="collapsenav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-light" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="about.php">About us</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-light" href="#" role="button" data-bs-toggle="dropdown">Places</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="package.php">Packages</a></li>
                                <li><a class="dropdown-item" href="blog.php">Blogs</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="hotel.php">Hotels</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-light" href="#" role="button" data-bs-toggle="dropdown">Transport</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="flights.php">Flight</a></li>
                                <li><a class="dropdown-item" href="trains.php">Train</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="map_features.php">Map Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="contact.php">Contact</a>
                        </li>
                        <?php
                        if (isset($_SESSION['username'])): ?>
                            <li class="nav-item">
                                <a class="nav-link text-light" data-bs-target="#demo" data-bs-toggle="offcanvas">Welcome, <?php echo $_SESSION['username']; ?></a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-light " href="#" data-bs-toggle="dropdown"><i class="fa-solid fa-circle-user fa-lg"></i>Create Account</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="register.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Sign Up</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Login</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Image -->
        <img src="images/about-bg.jpg" alt="" class="img-fluid w-100" data-aos="fade-up" style="height:600px;" />
        <div class="card-img-overlay text-center" id="overlay">
            <h2 class="card-title text-light" style="font-size:3rem;">🌍 Welcome to IncredibleIndia Tours! 🌍</h2>
            <p class="card-text text-light">Your ultimate travel companion for exploring the beauty of India. Whether you're an adventure seeker, a culture enthusiast, or someone looking for a peaceful retreat, we bring you the best of India with carefully curated travel packages.</p>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" id="demo"
        style="background-color: <?php echo htmlspecialchars($user['offcanvas_color'] ?? '#ffffff'); ?>;">

        <div class="offcanvas-header d-flex align-items-center">
            <a href="profile.php" class="d-flex align-items-center text-decoration-none text-dark w-100">
                <div class="profile-icon bg-dark text-white d-flex align-items-center justify-content-center rounded-circle">
                    <?php if (!empty($user['profile_pic'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($user['profile_pic']); ?>"
                            class="rounded-circle" width="40" height="40" alt="Profile">
                    <?php else: ?>
                        <span class="initials">
                            <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="ms-3">
                    <h5 class="offcanvas-title m-0"><?php echo htmlspecialchars($user['username']); ?></h5>
                    <p class="text-muted small mb-0"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </a>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="offcanvas"></button>
        </div>

        <hr>

        <div class="offcanvas-body">
            <a class="text-dark" href="my_bookings.php" id="book">My Bookings</a>
            <br><br>
            <a href="mywishlist.php" class="text-dark" id="wishlist">My Wishlist</a>
            <br><br>
            <a href="myblog.php" id="blogs" class="text-dark">My Blogs</a>
            <br><br>
            <a class="nav-link text-dark" href="logout.php" id="logout">Logout</a>
        </div>
    </div>

    <section class="container py-5 text-center">
        <h2>✨ Our Mission ✨</h2>
        <p>We are committed to making travel effortless, enjoyable, and immersive. From the snowy peaks of the Himalayas to the golden sands of Rajasthan, we provide a gateway to India's rich heritage and natural beauty.</p>
    </section>

    <!-- What We Offer Section -->
    <section class="container py-5">
        <h2 class="text-center">🚀 What We Offer 🚀</h2>
        <div class="row text-center">
            <div class="col-md-4 icon-box" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-map-marked-alt"></i>
                <h4>Customized Travel Packages</h4>
                <p>Tailored itineraries that suit your preferences and budget.</p>
            </div>
            <div class="col-md-4 icon-box" data-aos="fade-up" data-aos-delay="600">
                <i class="fas fa-hotel"></i>
                <h4>Hotel & Flight Bookings</h4>
                <p>Secure and seamless reservations for a smooth journey.</p>
            </div>
            <div class="col-md-4 icon-box" data-aos="fade-up" data-aos-delay="900">
                <i class="fas fa-users"></i>
                <h4>Authentic Local Experiences</h4>
                <p>Explore India like a local with expert guides.</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4 icon-box" data-aos="fade-up" data-aos-delay="1200">
                <i class="fas fa-map-signs"></i>
                <h4>Smart Travel Planning</h4>
                <p>Dynamic route optimization and real-time navigation.</p>
            </div>
            <div class="col-md-4 icon-box" data-aos="fade-up" data-aos-delay="1500">
                <i class="fas fa-users-cog"></i>
                <h4>Community & Travel Stories</h4>
                <p>Connect with fellow travelers and share your journey.</p>
            </div>
            <div class="col-md-4 icon-box" data-aos="fade-up" data-aos-delay="1800">
                <i class="fas fa-credit-card"></i>
                <h4>Secure & Easy Payments</h4>
                <p>Book with confidence through our secure platform.</p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="container py-5 text-center why-choose-us-section">
        <h2>💡 Why Choose Us? 💡</h2>
        <p>We provide the best travel solutions with a hassle-free experience.</p>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li><i class="fas fa-check-circle text-success"></i> User-friendly interface for effortless booking.</li>
                    <li><i class="fas fa-check-circle text-success"></i> Wide range of travel options, from budget-friendly to luxury tours.</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li><i class="fas fa-check-circle text-success"></i> 24/7 customer support for a hassle-free experience.</li>
                    <li><i class="fas fa-check-circle text-success"></i> AI-powered chatbot for instant assistance.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Start Your Journey Section -->
    <section class="container py-5 text-center">
        <h2>🌟 Start your journey today with IncredibleIndia Tours and create memories that last a lifetime! 🌟</h2>
    </section>

    <footer class="footer" data-aos="fade-up" data-aos-delay="2000">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="footer-widget">
                            <div class="footer-name text-white">Travel&Tourism</div>
                            <p class="text-white">198 west 21th street xyz road ,
                                <br>
                                mumbai 400001
                                <br><br>
                                <a href="#" style="text-decoration: none;" class="text-white"><i
                                        class="fa-solid fa-phone"></i>+911144558844</a>
                                <br><br>
                                <a href="#" style="text-decoration: none;" class="text-white"><i
                                        class="fa-solid fa-envelope"></i>travelandtourism@gmail.com</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer-widget">
                            <h3 class="text-white">Quick Access</h3>
                            <ul class="navbar-nav">
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light">Home</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light">About</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light">Services</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light">FAQs</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer-widget">
                            <h3 class="text-white">Company</h3>
                            <ul class="navbar-nav">
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light">Blog</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light">Pricing</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light">contact</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light">FAQs</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 col-lg-2">
                        <div class="footer-widget">
                            <h3 class="text-white">Follow Us</h3>
                            <ul class="navbar-nav">
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html" class="nav-link text-light"><i
                                            class="fa-brands fa-twitter" style="color: #ffffff;"></i>Twitter</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html" class="nav-link text-light"><i
                                            class="fa-brands fa-facebook" style="color: #ffffff;"></i>Facebook</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html" class="nav-link text-light"><i
                                            class="fa-brands fa-instagram" style="color: #ffffff;"></i>Instagram</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right-text">
            <div class="container">
                <div class="footer-border"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy-text text-center">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <a class="to-top" id="toTop">
        <i class="fas fa-chevron-up"></i>
    </a>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="index.js"></script>
    <script>
        AOS.init({
            duration: 1200,
            easing: 'ease-in-out',
        });
    </script>

</body>

</html>







<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - IncredibleIndia Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .about-section {
            background: url('images/about-bg.jpg') no-repeat center center/cover;
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        .icon-box {
            text-align: center;
            padding: 20px;
        }
        .icon-box i {
            font-size: 40px;
            color: #ff9800;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    
    <section class="about-section">
        <div class="container">
            <h1 class="fw-bold">Welcome to IncredibleIndia Tours</h1>
            <p>Your ultimate travel companion for exploring the beauty of India.</p>
        </div>
    </section>

    <section class="container py-5">
        <div class="row text-center">
            <div class="col-md-4 icon-box">
                <i class="fas fa-map-marked-alt"></i>
                <h4>Customized Travel Packages</h4>
                <p>Tailored itineraries to match your preferences.</p>
            </div>
            <div class="col-md-4 icon-box">
                <i class="fas fa-hotel"></i>
                <h4>Hotel & Flight Bookings</h4>
                <p>Seamless and secure booking process.</p>
            </div>
            <div class="col-md-4 icon-box">
                <i class="fas fa-users"></i>
                <h4>Local Guides & Experiences</h4>
                <p>Authentic travel experiences with expert guides.</p>
            </div>
        </div>
    </section>

    <section class="container py-5 text-center">
        <h2>Why Choose Us?</h2>
        <p>We provide the best travel solutions with a hassle-free experience.</p>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li><i class="fas fa-check-circle text-success"></i> User-friendly interface</li>
                    <li><i class="fas fa-check-circle text-success"></i> Wide range of travel options</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li><i class="fas fa-check-circle text-success"></i> 24/7 customer support</li>
                    <li><i class="fas fa-check-circle text-success"></i> AI-powered chatbot assistance</li>
                </ul>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-3">
        <p>Contact us: <i class="fas fa-envelope"></i> your@email.com | <i class="fas fa-phone"></i> +91 9876543210</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> -->