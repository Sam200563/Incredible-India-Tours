<?php
session_start();
// Include the database connection file
include 'setup_database.php';

// Get the flight ID from the URL query string
$train_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Connect to the database
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM trains WHERE train_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $train_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $train = $result->fetch_assoc();
} else {
    echo "<p>Train not found.</p>";
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
    <title>Train Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="index.css">
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
        .nav-link{
            color:darkblue !important;
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
                            <a href="#" class="nav-link text-light dropdown-toggle" role="button" data-bs-toggle="dropdown">Places</a>
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
        <h1>Train Detail</h1>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title"><?php echo htmlspecialchars($train['train_name']); ?></h2>
                <h4 class="card-text"><?php echo htmlspecialchars($train['source']) . " → " . htmlspecialchars($train['destination']); ?></h4>
                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($train['price']); ?></p>
                <p><strong>Departure Time:</strong> <?php echo htmlspecialchars(date("h:i A", strtotime($train['departure_time']))); ?></p>
                <p><strong>Arrival Time:</strong> <?php echo htmlspecialchars(date("h:i A", strtotime($train['arrival_time']))); ?></p>
                <p><strong>Seats Available:</strong> <?php echo htmlspecialchars($train['seats_available']); ?></p>
                <a href="train_book.php?id=<?php echo htmlspecialchars($train['train_id']); ?>" class="btn btn-primary">Book This Train</a>
                <button class="btn btn-secondary" onclick="saveToWishlist(<?php echo $train_id; ?>,'train')">Save to Wishlist</button>
                <a href="trains.php" class="btn btn-success">Back to Trains</a>
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