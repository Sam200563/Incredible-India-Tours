<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Travel and Tourism</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="index.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<style>
    .logo {
        height: 50px !important;
        border-radius: 5px;
    }

    .logo img {
        height: 50px !important;
        border-radius: 50%;
        cursor: pointer;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    section .container {
        display: flex;
        flex-direction: column;
        width: 500px;
    }

    input {
        margin: 0.25em 0em 1em 0em;
        padding: 0.5em !important;
        border: none !important;
        background-color: rgb(225, 225, 225) !important;
        border-radius: 0.25em;
        color: black;
        display: block;
    }

    #email {
        border-radius: 5px;
    }

    textarea {
        resize: both;
    }

    .form-group input[type] {
        width: 400px;
    }

    textarea {
        display: block;
    }

    .form-group input[type]:focus {
        border-color: skyblue;
    }

    button {
        padding: 0.65em;
        font-weight: 400;
        outline: none;
        border: none;
        border-radius: 0.25em;
        color: white;
        font-weight: bolder;
        width: 400px;
        margin-bottom: 20px;
    }

    button:hover {
        cursor: pointer;
    }

    .navbar-toggler {
        border: 1px solid black !important;
        background-color: white !important;
    }

    @media(width<600px) {
        .navbar-toggler {
            width: 55px;
        }

        #contact-text {
            font-size: 5rem !important;
        }
    }
</style>

<body>
    <header>
        <div class="hotel position-relative">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-sm  navbar-dark fixed-top">
                <div class="container-fluid">
                    <div class="logo">
                        <img src="images/INCRIDEBLE INDIA TOURS.jpg" alt="">
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsenav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end h5 text-light" id="collapsenav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="home.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="about.html">About us</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-light" href="#" role="button"
                                    data-bs-toggle="dropdown">Places</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="package.php">Packages</a></li>
                                    <li><a class="dropdown-item" href="blog.html">Blogs</a></li>
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
                                <a class="nav-link text-light" href="map_features.html">Map Features</a>
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
            <img src="images/contact.jpg" alt="" class="img-fluid" style="height: 650px !important;" />
            <div class="card-img-overlay text-center" id="overlay">
                <h1 class="card-title text-light" id="hotel-text">Contact us</h1>
            </div>
        </div>
    </header>
    <div class="offcanvas offcanvas-end" id="demo">
        <div class="offcanvas-header">
            <h1 class="offcanvas-title"><?php echo $_SESSION['username']; ?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <a class="text-dark" href="my_bookings.php" id="book">My Bookings</a>
            <br><br>
            <a href="mywishlist.php" class="text-dark" id="wishlist">My Wishlist</a>
            <a class="nav-link text-dark" href="logout.php" id="logout">Logout</a>
        </div>
    </div>
    <section id="sectioncon">
        <div class="flex items-center bg-gray">
            <div class="container">
                <div class="bg-white shadow p-4 mb-4 bg-white my-10">
                    <div class="text-center">
                        <h1 class="my-3 text-3xl font-semibold">Contact Us</h1>
                        <p class="text-gray">
                            Fill up the below form to send us a message
                        </p>
                    </div>
                    <div class="m-7">
                        <form action="contact_info.php" method="POST" id="contact_form">
                            <div class="mb-6 form-group">
                                <label for="name">FullName <span>*</span></label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Full Name"
                                    required />
                            </div>
                            <div class="mb-6 form-group">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Enter Email" required />
                            </div>
                            <div class="mb-6 form-group">
                                <label for="number">Phone No. <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="number"
                                    placeholder="+1 (555) 1234-567" required />
                            </div>
                            <div class="mb-6 form-group">
                                <label for="message">Message</label>
                                <textarea name="message" class="form-control" id="msg" placeholder="Message"
                                    class="form-group"></textarea>
                            </div>
                            <div class="mt-2 form-group">
                                <button class="btn btn-danger" id="contactForm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mh-100 newsletter border-top">
        <br>
        <div class="container w-75 mb-5" id="newsletter">
            <h1 class="h1">Subscribe Now</h1>
            <p class="m-5 pb-4">Subscribe for our travel newsletter to receive exclusive deals, destination inspiration,
                and
                helpful tips for your next vacation. Stay informed and get the most out of your travels by subscribing
                to our
                email list today.</p>
            <form action="#" id="subscribe-form" class="w-100">
                <div class="form-group text-center d-flex gap-2">
                    <input type="email" class="form-control w-100 border border-dark" id="email"
                        placeholder="Enter your email">
                    <button type="submit" class="btn btn-dark" id="btn">Subscribe</button>
                </div>
            </form>
        </div>
    </section>
    <footer class="footer">
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
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light"><i class="fa-brands fa-twitter"
                                            style="color: #ffffff;"></i>Twitter</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light"><i class="fa-brands fa-facebook"
                                            style="color: #ffffff;"></i>Facebook</a></li>
                                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.html"
                                        class="nav-link text-light"><i class="fa-brands fa-instagram"
                                            style="color: #ffffff;"></i>Instagram</a></li>
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
    <a href="#top" class="to-top">
        <i class="fas fa-chevron-up"></i>
    </a>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('contactForm').onsubmit(function(e) {
            e.preventDefault();
            alert("From submitted successfully");
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="index.js"></script>
</body>

</html>