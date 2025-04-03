<?php
session_start();
include 'setup_database.php';
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $package_id = intval($_GET['id']);

    // Fetch package details
    $sql = "SELECT * FROM packages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $package = $result->fetch_assoc();
} else {
    echo "<p>Package ID not provided in the URL.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Details</title>
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #book,
        #wishlist {
            text-decoration: none;
        }

        #logout {
            margin: 5px;
            background-color: lightgrey;
            padding: 8px;
            border-radius: 5px;
            bottom: 10px;
            left: 0;
            position: absolute;
            text-decoration: none;
            color: black;
            font-size: larger;
            font-weight: 500;
        }

        * {
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
        }

        .hotel {
            position: relative;
            overflow: hidden;
        }

        .navbar-scrolled {
            background-color: white;
            transition: background-color 0.3s ease;
        }

        .navbar-scrolled .nav-link,
        .navbar-scrolled .navbar-text {
            color: black !important;
        }

        .navbar {
            z-index: 1;
            /* Ensure navbar appears above the image */
            color: #fff;
        }

        .navbar-text {
            font-family: "Times New Roman", Times, serif;
            font-size: 2rem;
            left: 20px;
            position: relative;
        }

        .nav-link {
            color: darkblue !important;
        }

        .nav-item {
            padding-right: 30px;
            font-family: "Times New Roman", Times, serif;
        }

        .nav-item .nav-link:hover {
            color: skyblue !important;
            cursor: pointer !important;
        }

        .logo {
            height: 50px !important;
            border-radius: 5px;
        }

        .logo img {
            height: 50px !important;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>

<body style="background-color: aliceblue;">
    <header id="hotel">
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
                            <a class="nav-link text-light" href="about.html">About us</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link text-light " role="button" data-bs-toggle="dropdown">Places</a>
                            <ul class="dropdown-menu">
                                <li><a href="package.php" class="dropdown-item">Packages</a></li>
                                <li><a href="blog.html" class="dropdown-item">Blog</a></li>
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
                            <a class="nav-link text-light" href="contact.html">Contact</a>
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
    <div class="container mt-5">
        <?php if ($package): ?>
            <div class="card">
                <div class="card-header text-center">
                    <h2><?php echo htmlspecialchars($package['name']); ?></h2>
                    <p class="lead">Price: ₹<?php echo htmlspecialchars($package['price']); ?></p>
                </div>
                <div class="card-body">
                    <!-- Carousel -->
                    <div id="packageCarousel" class="carousel slide mb-4" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php
                            $images = explode(',', $package['images']);
                            foreach ($images as $index => $image) : ?>
                                <li data-target="#packageCarousel" data-slide-to="<?php echo $index; ?>" class="<?php echo $index == 0 ? 'active' : ''; ?>"></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php foreach ($images as $index => $image) : ?>
                                <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                                    <img class="d-block w-100" src="<?php echo htmlspecialchars($image); ?>" alt="Slide <?php echo $index + 1; ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#packageCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#packageCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                    <!-- Details -->
                    <p><?php echo nl2br(htmlspecialchars($package['description'])); ?></p>
                    <h5>Duration:</h5>
                    <p><?php echo htmlspecialchars($package['duration']); ?></p>
                    <h5>Destinations Covered:</h5>
                    <p><?php echo htmlspecialchars($package['destinations']); ?></p>
                    <h5>Inclusions:</h5>
                    <ul>
                        <?php foreach (explode(',', $package['inclusions']) as $item) : ?>
                            <li><?php echo htmlspecialchars($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <h5>Exclusions:</h5>
                    <ul>
                        <?php foreach (explode(',', $package['exclusions']) as $item) : ?>
                            <li><?php echo htmlspecialchars($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <h5>Itinerary:</h5>
                    <ul>
                        <?php foreach (explode('.', $package['itinerary']) as $item) : ?>
                            <?php if (trim($item) != '') : ?>
                                <li><?php echo htmlspecialchars(trim($item)); ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="package_book.php?id=<?php echo htmlspecialchars($package['id']); ?>" class="btn btn-primary">Book Now</a>
                    <button class="btn btn-secondary" onclick="saveToWishlist(<?php echo $package_id; ?>,'package')">Save to Wishlist</button>
                </div>

            </div>
        <?php else : ?>
            <p>Package not found.</p>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 200) {
                $('.navbar').addClass('navbar-scrolled');
            } else {
                $('.navbar').removeClass('navbar-scrolled');
            }
        });

        function saveToWishlist(itemId, itemType) {
            fetch('save_to_wishlist.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `item_id=${encodeURIComponent(itemId)}&item_type=${encodeURIComponent(itemType)}`
                })
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => console.error('Error:', error));
        }

        // function bookpackage(packageId) {
        //     console.log("Booking package id:", packageId);
        //     fetch('book_package.php', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/x-www-form-urlencoded'
        //             },
        //             body: 'id=' + encodeURIComponent(packageId)
        //         })
        //         .then(response => response.text())
        //         .then(data => alert(data))
        //         .catch(error => console.error('Error:', error));
        // }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>