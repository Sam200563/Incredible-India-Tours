<?php
session_start();
include 'setup_database.php';
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
    <title>Train Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="index.css">

    <style>
        aside {
            height: 450px;
            width: 300px;
            display: inline-block;
        }

        .sidebar-wrap {
            margin: 16px;
            padding: 16px;
            border: 1px solid black;
            justify-content: center;
            width: 250px;
            display: grid;
        }

        section {
            width: 1100px;
            height: 450px;
            display: inline-block;
        }


        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 15px;
            border-radius: 10px;
        }

        #filter-btn {
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>
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
                            <a href="#" class="nav-link text-light" role="button" data-bs-toggle="dropdown">Places</a>
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
        <img src="images/train.avif" alt="package" class="img-fluid" style="height: 650px !important; width:100%" />
        <div class="card-img-overlay text-center" id="overlay">
            <h1 class="card-title text-light" id="hotel-text">Train</h1>
        </div>
    </header>
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
    <div id="trainResults" class="container my-4 d-none">
        <h2 class="text-center">Available Trains</h2>
        <div class="row" id="trainList"></div>
    </div>
    <main style="display: flex;padding-top:20px;padding-bottom: 40px;margin-bottom:20px;height:600px;">
        <aside>
            <div class="sidebar sidebar-wrap">
                <h4>Search Trains</h4>
                <form id="flightSearchForm" method="POST">
                    <div class="mb-3">
                        <label for="source" class="form-label">Source</label>
                        <input type="text" class="form-control" id="source" name="source" placeholder="Enter source city" required>
                    </div>
                    <div class="mb-3">
                        <label for="destination" class="form-label">Destination</label>
                        <input type="text" class="form-control" id="destination" name="destination" placeholder="Enter destination city" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date of Journey</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="passengers" class="form-label">Number of Passengers</label>
                        <input type="number" class="form-control" id="passengers" name="passengers" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="min-price-range" style="margin-top:20px">Min Price: <span id="min-price-label">1000</span></label>
                        <input type="range" id="min-price-range" name="min_price" min="0" max="50000" step="500" value="1000" onchange="updatePriceLabels()">
                    </div>
                    <div class="mb-3">
                        <label for="max-price-range" style="margin-top:20px;">Max Price: <span id="max-price-label">10000</span></label>
                        <input type="range" id="max-price-range" name="max_price" min="0" max="50000" step="500" value="10000" onchange="updatePriceLabels()">
                    </div>
                </form>
            </div>
        </aside>
        <section>
            <div class="container mt-5" style="margin-top: 2rem !important;">
                <div class="row">
                    <?php
                    include 'setup_database.php';
                    $conn = new mysqli($servername, $username, $password, $db);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    // SQL query to fetch flights
                    $sql = "SELECT DISTINCT * FROM trains WHERE destination in ('Bangalore', 'Pune' ,'Mysore','Varanasi','Hyderabad','Delhi')  LIMIT 9";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        // Fetch all flights into an array
                        $trains = $result->fetch_all(MYSQLI_ASSOC);
                        echo '<div class="container mt-5"><div class="row">';
                        // Loop through the flights with a for loop
                        for ($i = 0; $i < count($trains); $i++) {
                            $train = $trains[$i];
                    ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($train['train_name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($train['source'] . " → " . $train['destination']); ?></p>
                                        <p class="card-text">Price: ₹<?php echo htmlspecialchars($train['price']); ?></p>
                                        <p class="card-text">Departure: <?php echo htmlspecialchars(date("d M Y, h:i A", strtotime($train['departure_time']))); ?></p>
                                        <p class="card-text">Arrival: <?php echo htmlspecialchars(date("d M Y, h:i A", strtotime($train['arrival_time']))); ?></p>
                                        <p class="card-text">Date: <?php echo htmlspecialchars($train['date_of_journey']); ?></p>
                                        <a href="train_detail.php?id=<?php echo htmlspecialchars($train['train_id']); ?>" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                        echo '</div></div>';
                    } else {
                        echo "<p>No trains found.</p>";
                    }

                    // Close the connection
                    $conn->close();
                    ?>
                </div>
            </div>
        </section>
    </main>
    
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
    <script>
        function updatePriceLabels() {
            document.getElementById('min-price-label').textContent = document.getElementById('min-price-range').value;
            document.getElementById('max-price-label').textContent = document.getElementById('max-price-range').value;
            fetchTrains(); // Fetch trains whenever price changes
        }

        function fetchTrains() {
            // Get form data
            const source = document.getElementById('source').value.trim();
            const destination = document.getElementById('destination').value.trim();
            const date = document.getElementById('date').value;
            const numberOfPassenger = document.getElementById('passengers').value;
            const minPrice = document.getElementById('min-price-range').value;
            const maxPrice = document.getElementById('max-price-range').value;

            // Validate that all fields are filled
            if (!source || !destination || !date || !passengers || !minPrice || !maxPrice) {
                document.getElementById('trainList').innerHTML = '<p class="text-center text-danger">Please fill all the required fields.</p>';
                return;
            }

            // Prepare POST request
            fetch('train_search.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `source=${encodeURIComponent(source)}&destination=${encodeURIComponent(destination)}&date=${encodeURIComponent(date)}&min_price=${encodeURIComponent(minPrice)}&max_price=${encodeURIComponent(maxPrice)}`
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(trains => {
                    let html = '';
                    if (trains.length > 0) {
                        trains.forEach(train => {
                            html += `
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Train Name: ${train.train_name}</h5>
                            <p>Source: ${train.source} | Destination: ${train.destination}</p>
                            <p>Date: ${train.date_of_journey}</p>
                            <p>Time: ${train.departure_time} - ${train.arrival_time}</p>
                            <p>Seats Available: ${train.seats_available}</p>
                            <p>Price: ₹${train.price}</p>
                            <a class="btn btn-primary bookTrain" href="train_detail.php?id=${train.train_id}">View Details</a>
                        </div>
                    </div>
                </div>`;
                        });
                    } else {
                        html = '<p class="text-center text-warning">No trains available for the selected criteria.</p>';
                    }
                    document.getElementById('trainList').innerHTML = html;
                    document.getElementById('trainResults').classList.remove('d-none');
                })
                .catch(error => console.log('Error fetching train data:', error));
        }

        // Add event listeners to form fields
        document.getElementById('source').addEventListener('input', fetchTrains);
        document.getElementById('destination').addEventListener('input', fetchTrains);
        document.getElementById('date').addEventListener('change', fetchTrains);
        document.getElementById('min-price-range').addEventListener('change', updatePriceLabels);
        document.getElementById('max-price-range').addEventListener('change', updatePriceLabels);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="index.js"></script>
</body>

</html>