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
  <title>Travel And Tourism</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="stylesheet" href="index.css" />
  <!-- Bootstrap CSS v5.2.1 -->
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
    .image {
      height: 306px;
    }

    .image-h {
      height: 306px;
    }

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

    .carousel-container {
      display: flex !important;
      align-items: center !important;
      width: 100% !important;
      max-width: 100% !important;
      /* margin: auto !important; */
      overflow: hidden !important;
      position: relative !important;
      top: 500px;
      margin-top: 85px;
    }

    .carousel {
      display: flex !important;
      overflow-x: hidden !important;
      scroll-behavior: smooth !important;
      flex-grow: 1 !important;
      white-space: nowrap !important;
    }

    .carouselinner {
      display: inline-flex !important;
    }

    .carouselitem {
      border: 1px solid #ccc;
      display: inline-block !important;
      flex: 0 0 auto !important;
      width: calc(100% / 3) !important;
      /* Change this based on how many items you want visible */
      box-sizing: border-box !important;
      margin-left: 2px;
      margin-bottom: 10px;
      cursor: pointer;
      padding: 10px !important;
      border-radius: 10px;
    }

    .carousel img {
      width: 100% !important;
      display: block !important;
    }

    .desc {
      border-top: 1px solid #ccc;
      margin-top: 10px;
      padding: 10px;
      text-align: center;
    }

    .desc h1 {
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
      font-size: xx-large;
    }

    .control {
      font-size: 50px;
      padding: 10px;
      cursor: pointer;
      z-index: 1;
    }

    .control-prev {
      position: absolute;
      left: 0;
    }

    .control-next {
      position: absolute;
      right: 0;
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
      background-color: crimson;
      width: 100%;
      text-align: center;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      margin-top: 20px;
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
    <img src="images/footer.jpg" alt="" class="img-fluid" />
    <div class="card-img-overlay text-center" id="overlay">
      <h1 class="card-title text-light" id="hotel-text">Hotel</h1>
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
  <div id="results" style="padding:10px;display:flex;">
    </div>

  <main style="display: flex;padding-top:20px;padding-bottom: 40px;margin-bottom:20px;height:600px;">
    <aside>
      <div class="sidebar-wrap bg-light" id="sidebar1">
        <h3 class="heading text-center">Find Hotel</h3>
        <hr>
        <form action="#" id="search">
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
          <div class="form-group ">
            <select class="form-select" placeholder="Select State" id="searchstate" onchange="onStateChange()" required>
              <option value="">Select State</option>
            </select>
          </div>
          <div class="form-group pt-3">
            <select class="form-select" placeholder="Select City" id="searchcity" onchange="searchHotels()" required>
              <option value="">Select City</option>
            </select>
          </div>
          <div class="form-group pt-3">
            <input type="text" id="checkin_date" class="form-control" placeholder="Check-in Date"
              onfocus="(this.type='date')" onblur="(this.type='text')" onchange="searchHotels()" required />
          </div>
          <div class="form-group pt-3">
            <input type="text" id="checkout_date" class="form-control" placeholder="Check-out Date"
              onfocus="(this.type='date')" onblur="(this.type='text')" onchange="searchHotels()" required />
          </div>
        </form>
      </div>
      <div class="sidebar-wrap bg-light" id="sidebar1">
        <form action="#" id="search">
          <div class="price-filter">
            <label for="min-price-range" style="margin-top:20px">Min Price: <span id="min-price-label">1000</span></label>
            <input type="range" id="min-price-range" name="min_price" min="0" max="50000" step="500" value="1000" onchange="updatePriceLabels()">

            <label for="max-price-range" style="margin-top:20px;">Max Price: <span id="max-price-label">10000</span></label>
            <input type="range" id="max-price-range" name="max_price" min="0" max="50000" step="500" value="10000" onchange="updatePriceLabels()">

            <button type="button" id="filter-btn">Apply Filter</button>
          </div>

        </form>
      </div>
    </aside>
    <section>
      <div class="container">
        <div class="row">
          <?php
          include 'setup_database.php';
          $conn = new mysqli($servername, $username, $password, $db);
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
          $sql = "SELECT DISTINCT * FROM hotels LIMIT 9";
          $result = $conn->query($sql);
          if ($result && $result->num_rows > 0) {
            // Fetch all packages into an array
            $hotels = $result->fetch_all(MYSQLI_ASSOC);
            echo '<div class="container mt-5"><div class="row">';
            // Loop through the packages with a for loop
            for ($i = 0; $i < count($hotels); $i++) {
              $hotel = $hotels[$i];         ?>
              <div class="col-md-4 mb-4">
                <div class="card">
                  <img class="card-img-top" src="<?php echo htmlspecialchars(explode(',', $hotel['images'])[0]); ?>" alt="Hotel Image" height="160">
                  <div class="card-body">
                    <h5 class="card-title" style="font-size:30px !important;"><?= $hotel['name']; ?></h5>
                    <p class="card-text"><?= $hotel['description']; ?></p>
                    <p class="card-text"><strong>Price:</strong> ₹<?= $hotel['price_range']; ?> per night</p>
                    <!-- <p class="card-text"><strong>Rating:</strong> <?= $hotel['rating']; ?>-Star</p> -->
                    <a href="hotel_details.php?id=<?= $hotel['id']; ?>" class="btn btn-primary">View Details</a>
                  </div>
                </div>
              </div>
          <?php
            }
            echo '</div></div>';
          } else {
            echo "<p>No hotel found.</p>";
          }

          // Close the connection
          $conn->close();
          ?>
        </div>
      </div>
    </section>
  </main>
  <div class="carousel-container">
    <span class="control control-prev"><i class="fa-solid fa-angle-left" style="color: #ffffff;"></i></span>
    <div class="carousel">
      <div class="carouselinner">
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/co1.jpg" alt="Image 1" style="height: 280px !important;width:500px !important;" class="img-fluid">
          <div class="desc">
            <h1>Conrad Pune</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/tajhotel.jpg" alt="Image 2" style="height: 280px !important;"
            class="img-fluid">
          <div class="desc">
            <h1>Taj Mahal Palace</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/Hilton-Mumbai-International-Airport-Hotel.jpg" alt="Image 3"
            style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>Hilton International Airport Hotel</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/kolhapur.png" alt="Image 4" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>Fazlani Nature's Nest</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/gujarat.jpg" alt="Image 5" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>Regenta Place Raysons, Kolhapur</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/delhihotel/hyatt.jpg" alt="Image 6" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>JW Marriott Hotel Pune</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/delhihotel/Imperial-Hotel.jpg" alt="Image 7" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>ITC Maratha Hotel</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/delhihotel/peerless_kolkata.jpg" alt="Image 8" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>The Oberoi</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/delhihotel/Taj-Palace-Delhi.jpg" alt="Image 9" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>Grand Hyatt Mumbai Hotel </h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/delhihotel/The-Leela-Palace-Delhi.jpg" alt="Image 10" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>Novotel Mumbai Juhu Beach</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/suncity.jpg" alt="Image 11" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>Sun city Hotel,Goa</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/goa.jpg" alt="Image 12" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>Le meridien,Goa</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/punjab.jpg" alt="Image 13" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>Taj Swarna Amritsar</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/nirvana.jpg" alt="Image 14" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>NIRVANA Luxury Hotel , Ludhiana</h1>
          </div>
        </div>
        <div class="carouselitem" style="width:500px !important;">
          <img src="images/hotel/hydrabad.jpg" alt="Image 15" style="height: 280px !important;" class="img-fluid">
          <div class="desc">
            <h1>Taj Krishna,Hyderabad</h1>
          </div>
        </div>
      </div>
    </div>
    <span class="control control-next"><i class="fa-solid fa-angle-right" style="color: #ffffff;"></i></span>
  </div>
  <div class="container mt-5" style="position: relative;top: 500px;">
    <h2 class="text-center mb-4">Special Offers</h2>
    <div id="offersCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/offer1.jpg" class="d-block w-100" alt="Offer 1">
          <div class="carousel-caption">
            <h5>Explore the Beaches</h5>
            <p>Get up to 30% off on Goa packages!</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/offer2.jpg" class="d-block w-100" alt="Offer 2">
          <div class="carousel-caption">
            <h5>Adventure Awaits</h5>
            <p>Save 20% on trekking tours in Himachal Pradesh.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/offer3.jpg" class="d-block w-100" alt="Offer 3">
          <div class="carousel-caption">
            <h5>Romantic Getaway</h5>
            <p>Enjoy a special discount on Kerala houseboat tours.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#offersCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#offersCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
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
    document.addEventListener("DOMContentLoaded", function() {
      // Load states when the page loads
      console.log("DOM fully loaded and parsed. Loading states...");

      loadStates();
    });
    document.getElementById("checkin_date").addEventListener("change", function(event) {
      var checkinDate = document.getElementById("checkin_date").value;
      var checkoutDate = document.getElementById("checkout_date").value;
      var today = new Date().toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format

      // Check if the check-in date is in the past
      if (checkinDate < today) {
        alert("Check-in date cannot be in the past.");
        event.preventDefault(); // Prevent form submission
        return;
      }

      // Check if the check-out date is after the check-in date
      if (checkoutDate <= checkinDate) {
        alert("Check-out date must be later than the check-in date.");
        event.preventDefault(); // Prevent form submission
        return;
      }
    });

    // Function to load states
    function loadStates() {
      fetch('getStates.php')
        .then(response => response.text())
        .then(html => {
          console.log("States loaded successfully");
          document.getElementById("searchstate").innerHTML = '<option value="">Select State</option>' + html;
        })
        .catch(error => console.error('Error loading states:', error));
    }

    // Function to load cities based on selected state
    function fetchCities(stateId) {
      fetch("getCities.php?state_id=" + encodeURIComponent(stateId))
        .then(response => response.text())
        .then(html => {
          console.log("Cities loaded successfully");
          document.getElementById("searchcity").innerHTML = '<option value="">Select City</option>' + html;
        })
        .catch(error => console.error('Error loading cities:', error));
    }

    function onStateChange() {
      const stateId = document.getElementById("searchstate").value;
      if (stateId) {
        fetchCities(stateId);
      } else {
        document.getElementById("searchcity").innerHTML = '<option value="">Select City</option>';
        document.getElementById("results").innerHTML = '';
      }
    }

    // Search hotels dynamically based on all inputs
    function searchHotels() {
      const stateId = document.getElementById("searchstate").value;
      const cityId = document.getElementById("searchcity").value;
      const checkInDate = document.getElementById("checkin_date").value;
      const checkOutDate = document.getElementById("checkout_date").value;

      if (!stateId || !cityId || !checkInDate || !checkOutDate) {
        console.log("All fields must be filled before searching for hotels.");
        document.getElementById("results").innerHTML = '<p class="text-muted">Please fill all the fields to view hotels.</p>';
        return;
      }

      if (cityId) {
        const params = new URLSearchParams({
          city_id: cityId,
          checkin_date: checkInDate,
          checkout_date: checkOutDate
        });

        fetch("hotel_search.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded"
            },
            body: params.toString()
          })
          .then(response => response.text())
          .then(html => {
            console.log("Hotels loaded successfully");
            document.getElementById("results").innerHTML = html;
          })
          .catch(error => console.error('Error searching hotels:', error));
      } else {
        document.getElementById("results").innerHTML = '<p class="text-muted">Please select a city to view hotels.</p>';
      }
    }

    //carousel
    const carousel = document.querySelector('.carousel');
    const prevButton = document.querySelector('.control-prev');
    const nextButton = document.querySelector('.control-next');

    prevButton.addEventListener('click', () => {
      carousel.scrollBy({
        left: -carousel.clientWidth,
        behavior: 'smooth'
      });
    });

    nextButton.addEventListener('click', () => {
      carousel.scrollBy({
        left: carousel.clientWidth,
        behavior: 'smooth'
      });
    });

    function updatePriceLabels() {
      const minPrice = document.getElementById("min-price-range").value;
      const maxPrice = document.getElementById("max-price-range").value;

      document.getElementById("min-price-label").textContent = minPrice;
      document.getElementById("max-price-label").textContent = maxPrice;
    }

    // Add event listener for the filter button
    document.getElementById("filter-btn").addEventListener("click", function() {
      const minPrice = document.getElementById("min-price-range").value;
      const maxPrice = document.getElementById("max-price-range").value;

      if (minPrice && maxPrice && parseInt(minPrice) <= parseInt(maxPrice)) {
        fetch(`filter_results.php?service_type=hotels&min_price=${minPrice}&max_price=${maxPrice}`)
          .then(response => response.text())
          .then(data => {
            document.getElementById("results").innerHTML = data;
          });
      } else {
        alert("Please ensure the minimum price is less than or equal to the maximum price.");
      }
    });
  </script>
  <!-- Bootstrap JavaScript Libraries -->
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