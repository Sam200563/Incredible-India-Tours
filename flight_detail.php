<?php
session_start();
// Include the database connection file
include 'setup_database.php';

// Get the flight ID from the URL query string
$flight_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Connect to the database
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch flight details from the database
$sql = "SELECT * FROM flights WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $flight_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if flight exists
if ($result->num_rows > 0) {
    $flight = $result->fetch_assoc();
} else {
    echo "<p>Flight not found.</p>";
    exit;
}

// Close the connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Detail</title>
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

        .nav-item {
            padding-right: 30px;
            font-family: "Times New Roman", Times, serif;
        }

        .nav-link {
            color: darkblue !important;
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
                            <a class="nav-link text-light" href="map_feature.php">Map Features</a>
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
                            <li class="nav-item">
                                <a class="nav-link text-light" href="register.html"><i class="fa-solid fa-circle-user fa-lg"></i>Create Account</a>
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
        <h1>Flight Detail</h1>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?php echo htmlspecialchars($flight['origin']) . " → " . htmlspecialchars($flight['destination']); ?></h3>
                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($flight['price']); ?></p>
                <p><strong>Departure Time:</strong> <?php echo htmlspecialchars(date("d M Y, h:i A", strtotime($flight['departure_time']))); ?></p>
                <p><strong>Arrival Time:</strong> <?php echo htmlspecialchars(date("d M Y, h:i A", strtotime($flight['arrival_time']))); ?></p>
                <p><strong>Class:</strong> <?php echo htmlspecialchars($flight['class']); ?></p>
                <p><strong>Seats Available:</strong> <?php echo htmlspecialchars($flight['seats_available']); ?></p>
                <a href="flight_book.php?id=<?php echo htmlspecialchars($flight['id']); ?>" class="btn btn-primary">Book This Flight</a>
                <button class="btn btn-secondary" onclick="saveToWishlist(<?php echo $flight_id; ?>,'flight')">Save to Wishlist</button>
                <a href="flights.php" class="btn btn-success">Back to Flights</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function saveToWishlist(itemId, itemType) {
            fetch('save_to_wishlist.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `item_id=${itemId}&item_type=${itemType}`
                })
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => console.error('Error:', error));
        }
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