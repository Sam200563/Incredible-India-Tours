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
  <title>Travel And Tourism</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css" />
  <style>
    .col-md-4 {
      width: 240px !important;
      position: relative !important;
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

    #book,
    #wishlist,
    #blogs,#event {
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

    .profile-icon {
      width: 50px;
      height: 50px;
      font-size: 20px;
      font-weight: bold;
    }

    .offcanvas-header {
      display: flex;
      align-items: center;
    }

    .initials {
      font-size: 24px;
    }

    .profile-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
    }

    h5.offcanvas-title {
      font-size: 20px;
    }

    p.text-muted {
      font-size: 14px;
    }

    .back-to-top {
      border: 2px solid white;
      position: fixed;
      bottom: 16px;
      right: 32px;
      width: 50px;
      height: 50px;
      color: #fff;
      padding: 10px 15px;
      border-radius: 25px;
      cursor: pointer;
      display: none;
      z-index: 1000;
    }

    .carousel-items img {
      height: 400px;
      object-fit: cover;
    }

    .carousel-caption {
      background-color: rgba(0, 0, 0, 0.5);
      padding: 15px;
      border-radius: 10px;
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
            <?php if (isset($_SESSION['username'])): ?>
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
    <img src="images/index.avif" alt="" class="img-fluid" style="height: 800px !important;" />

    <!-- Overlay -->
    <div class="card-img-overlay text-center" id="head">
      <h1 class="card-title pt-5 text-light">Explore</h1>
      <h3 class="card-title text-light">Your Favourite City with Us</h3>
      <p class="text-light" style="font-size: 25px">
        Find great places to stay, eat, shop, or visit.
      </p>
      <div class="card-text d-flex justify-content-center">
        <div class="row pt-5 items-center">
          <div class="col-md-6">
            <form action="" class="d-flex" id="searchForm">
              <div class="form-group" id="form-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Ex. hotel, place, service"
                  style="height: 60px; width: 300px" />
              </div>
              <!-- <div class="form-group" id="city" style="padding-left: 5px">
                  <select name="city"id="citySelect"class="form-select"placeholder="Where"style="height: 60px; width: 300px">
                    <option value="where">Where</option>
                    <option value="">Andhra Pradesh</option>
                    <option value="">Arunachal Pradesh</option>                   
                    <option value="">Assam</option>                    
                    <option value="">Bihar</option>                    
                    <option value="">Chhattisgarh</option>
                    <option value="">Goa</option>                    
                    <option value="">Gujarat</option>                  
                    <option value="">Haryana</option>                   
                    <option value="">Himachal Pradesh</option>                    
                    <option value="">Jammu and Kashmir</option>           
                    <option value="">Jharkhand</option>                  
                    <option value="">Karnataka</option>                    
                    <option value="">Kerala</option>                    
                    <option value="">Madhya Pradesh</option>                   
                    <option value="">Maharashtra</option>                    
                    <option value="">Manipur</option>                    
                    <option value="">Meghalaya</option>                    
                    <option value="">Mizoram</option>                    
                    <option value="">Nagaland</option>                    
                    <option value="">Orissa</option>                    
                    <option value="">Punjab</option>                    
                    <option value="">Rajasthan</option>
                    <option value="">Sikkim</option>              
                    <option value="">Tripura</option>
                    <option value="">Uttarakhand</option>                    
                    <option value="">Uttar Pradesh</option>                    
                    <option value="">West Bengal</option>                   
                    <option value="">Tamil Nadu</option>                    
                    <option value="">Tripura</option>                    
                    <option value="">Andaman and Nicobar Islands</option>                   
                    <option value="">Chandigarh</option>                   
                    <option value="">Dadra and Nagar Haveli</option>                   
                    <option value="">Daman and Diu</option>                    
                    <option value="">Delhi</option>                    
                    <option value="">Lakshadweep</option>                    
                    <option value="">Pondicherry</option>                        
                  </select>
                </div> -->
              <div class="form-group" style="padding-left: 5px">
                <button type="submit" value="submit" class="btn btn-danger" style="height: 60px; width: 150px">
                  Search
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div>
        <p class="text-light" id="high" style="font-size: 20px">
          Or browse the highlights
        </p>
        <div class="place d-flex justify-content-center align-items-center">
          <div class="s1">
            <a href="hotel.php" class="btn btn-outline-dark bg-light">
              <i class="fas fa-utensils"></i> Restaurant
            </a>
          </div>
          <div class="s2">
            <a href="package.php" class="btn btn-outline-dark bg-light">
              <i class="fas fa-location-arrow"></i> Places
            </a>
          </div>
          <div class="s3">
            <a href="flight.php" class="btn btn-outline-dark bg-light">
              <i class="fas fa-plane-departure"></i> Flights
            </a>
          </div>
        </div>
      </div>
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
      <a href="event_index.html" id="event" class="text-dark">Event Calendar</a>
      <br><br>
      <a class="nav-link text-dark" href="logout.php" id="logout">Logout</a>
    </div>
  </div>
  <section id="text" class="section">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-md-4 shadow bg-white me-5 mb-4" id="best">
          <div class="best text-center mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 20 20">
              <path fill="currentColor"
                d="M4.46 5.16L5 7.46l-.54 2.29l2.01 1.24L7.7 13l2.3-.54l2.3.54l1.23-2.01l2.01-1.24L15 7.46l.54-2.3l-2-1.24l-1.24-2.01l-2.3.55l-2.29-.54l-1.25 2zm5.55 6.34a3.999 3.999 0 1 1 0-8c2.2 0 3.99 1.79 3.99 3.99c0 2.22-1.79 4.01-3.99 4.01zm-.02-1C8.33 10.5 7 9.16 7 7.5c0-1.65 1.33-3 2.99-3S13 5.85 13 7.5c0 1.66-1.35 3-3.01 3zm3.84 1.1l-1.28 2.24l-2.08-.47L13 19.2l1.4-2.2h2.5zm-7.7.07l1.25 2.25l2.13-.51L7 19.2L5.6 17H3.1z" />
            </svg>
            <div class="text" id="heading">
              <h3 class="text-center">Best Price</h3>
              <p>
              Enjoy unbeatable travel deals with our Best Price Guarantee! We offer exclusive discounts on flights, hotels, and holiday packages to ensure you get the most value for your money. 
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 shadow bg-white me-5 mb-4" id="best">
          <div class="best text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 20 20">
              <path fill="currentColor"
                d="M4.46 5.16L5 7.46l-.54 2.29l2.01 1.24L7.7 13l2.3-.54l2.3.54l1.23-2.01l2.01-1.24L15 7.46l.54-2.3l-2-1.24l-1.24-2.01l-2.3.55l-2.29-.54l-1.25 2zm5.55 6.34a3.999 3.999 0 1 1 0-8c2.2 0 3.99 1.79 3.99 3.99c0 2.22-1.79 4.01-3.99 4.01zm-.02-1C8.33 10.5 7 9.16 7 7.5c0-1.65 1.33-3 2.99-3S13 5.85 13 7.5c0 1.66-1.35 3-3.01 3zm3.84 1.1l-1.28 2.24l-2.08-.47L13 19.2l1.4-2.2h2.5zm-7.7.07l1.25 2.25l2.13-.51L7 19.2L5.6 17H3.1z" />
            </svg>
            <div class="text">
              <h3 class="text-center">Custom itinerary</h3>
              <p>
              Plan your trip exactly the way you want with our personalized itinerary service. Choose your preferred destinations, activities, and travel dates, and we’ll create a tailor-made travel plan just for you.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 shadow bg-white me-5 mb-4" id="best">
          <div class="best text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 20 20">
              <path fill="currentColor"
                d="M4.46 5.16L5 7.46l-.54 2.29l2.01 1.24L7.7 13l2.3-.54l2.3.54l1.23-2.01l2.01-1.24L15 7.46l.54-2.3l-2-1.24l-1.24-2.01l-2.3.55l-2.29-.54l-1.25 2zm5.55 6.34a3.999 3.999 0 1 1 0-8c2.2 0 3.99 1.79 3.99 3.99c0 2.22-1.79 4.01-3.99 4.01zm-.02-1C8.33 10.5 7 9.16 7 7.5c0-1.65 1.33-3 2.99-3S13 5.85 13 7.5c0 1.66-1.35 3-3.01 3zm3.84 1.1l-1.28 2.24l-2.08-.47L13 19.2l1.4-2.2h2.5zm-7.7.07l1.25 2.25l2.13-.51L7 19.2L5.6 17H3.1z" />
            </svg>
            <div class="text">
              <h3 class="text-center">Verified Customer Review</h3>
              <p>
              Our platform features genuine feedback, ratings, and experiences shared by past customers to help you choose the best hotels, flights, and travel packages.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 shadow bg-white me-5 mb-4" id="best">
          <div class="best text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 20 20">
              <path fill="currentColor"
                d="M4.46 5.16L5 7.46l-.54 2.29l2.01 1.24L7.7 13l2.3-.54l2.3.54l1.23-2.01l2.01-1.24L15 7.46l.54-2.3l-2-1.24l-1.24-2.01l-2.3.55l-2.29-.54l-1.25 2zm5.55 6.34a3.999 3.999 0 1 1 0-8c2.2 0 3.99 1.79 3.99 3.99c0 2.22-1.79 4.01-3.99 4.01zm-.02-1C8.33 10.5 7 9.16 7 7.5c0-1.65 1.33-3 2.99-3S13 5.85 13 7.5c0 1.66-1.35 3-3.01 3zm3.84 1.1l-1.28 2.24l-2.08-.47L13 19.2l1.4-2.2h2.5zm-7.7.07l1.25 2.25l2.13-.51L7 19.2L5.6 17H3.1z" />
            </svg>
            <div class="text">
              <h3 class="text-center">24/7 support</h3>
              <p>
              Our team is available round the clock to assist you with all your travel needs. Whether you have questions about bookings, need help with cancellations, or require recommendations for your trip. 
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <br><br>
  <section id="carousel1">
    <h1 class="bg-light text-center py-3"
      style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Top Places</h1>
    <div class="container justify-content-center align-items-center" style="place-items: center; width:700px;">
      <div class="carousel slide justify-content-center align-items-center" id="demo" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
          <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
          <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
          <button type="button" data-bs-target="#demo" data-bs-slide-to="4"></button>
          <button type="button" data-bs-target="#demo" data-bs-slide-to="5"></button>
          <button type="button" data-bs-target="#demo" data-bs-slide-to="6"></button>
          <button type="button" data-bs-target="#demo" data-bs-slide-to="7"></button>
        </div>
        <div class="carousel-inner" style="place-items: center;">
          <div class="carousel-item active">
            <img src="images/places/place1.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/places/place2.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/places/place3.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/places/place5.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/places/place6.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/places/place7.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/places/place8.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/places/place9.jpg" alt="" class="d-block img-fluid w-100">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  </section>
  <br><br>
  <section>
    <h1 class="bg-light text-center py-3"
      style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Top Hotels</h1>
    <div class="container justify-content-center align-items-center" style="place-items: center; width:700px;">
      <div class="carousel slide justify-content-center align-items-center" id="demo1" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#demo1" data-bs-slide-to="0" class="active"></button>
          <button type="button" data-bs-target="#demo1" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#demo1" data-bs-slide-to="2"></button>
          <button type="button" data-bs-target="#demo1" data-bs-slide-to="3"></button>
          <button type="button" data-bs-target="#demo1" data-bs-slide-to="4"></button>
          <button type="button" data-bs-target="#demo1" data-bs-slide-to="5"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="images/hotel/punjab.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/hotel/gujarat.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/hotel/co1.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/hotel/tajhotel.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/hotel/nirvana.jpg" alt="" class="d-block img-fluid w-100">
          </div>
          <div class="carousel-item">
            <img src="images/hotel/kolhapur.png" alt="" class="d-block img-fluid w-100">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#demo1" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo1" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  </section>

  <div class="container mt-5" style="position: relative;">
    <h2 class="text-center mb-4">Special Offers</h2>
    <div id="offersCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active carousel-items">
          <img src="images/offer1.jpg" class="d-block w-100" alt="Offer 1">
          <div class="carousel-caption">
            <h5>Explore the Beaches</h5>
            <p>Get up to 30% off on Goa packages!</p>
          </div>
        </div>
        <div class="carousel-item carousel-items">
          <img src="images/offer2.jpg" class="d-block w-100" alt="Offer 2">
          <div class="carousel-caption">
            <h5>Adventure Awaits</h5>
            <p>Save 20% on trekking tours in Himachal Pradesh.</p>
          </div>
        </div>
        <div class="carousel-item carousel-items">
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
  <br><br>
  <section class="mh-100 newsletter border-top">
    <br>
    <div class="container w-75" id="newsletter">
      <h1 class="h1">Subscribe Now</h1>
      <p class="m-5 pb-4">Subscribe for our travel newsletter to receive exclusive deals, destination inspiration, and
        helpful tips for your next vacation. Stay informed and get the most out of your travels by subscribing to our
        email list today.</p>
      <form action="#" id="subscribe-form" class="w-100">
        <div class="form-group text-center d-flex gap-2">
          <input type="email" class="form-control w-100 border border-dark" id="email" placeholder="Enter your email">
          <button type="submit" class="btn btn-dark" id="btn">Subscribe</button>
        </div>
      </form>
    </div>
  </section>
  <br>
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
                <li class="nav-item mt-2" style="font-size: larger;"><a href="home.php"
                    class="nav-link text-light">Home</a></li>
                <li class="nav-item mt-2" style="font-size: larger;"><a href="about.php"
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
  <a class="back-to-top" id="backtoTop">
    <i class="fas fa-chevron-up"></i>
  </a>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
  <script>
    const backToTopButton = document.getElementById("backtoTop");

    // Show the button when scrolled down a specific distance
    window.onscroll = function() {
      if (document.documentElement.scrollTop > 200) {
        // Adjust the distance as needed
        backToTopButton.style.display = "block";
      } else {
        backToTopButton.style.display = "none";
      }
    };
    backToTopButton.addEventListener("click", function() {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      }); // Smooth scroll to the top
    });

    $(window).on('scroll', function() {
      if ($(window).scrollTop() > 200) {
        $('.navbar').addClass('navbar-scrolled');
      } else {
        $('.navbar').removeClass('navbar-scrolled');
      }
    });
    document.getElementById('searchForm').addEventListener('submit', function(event) {
      event.preventDefault();

      // Get the search input
      var searchInput = document.getElementById('searchInput').value.trim().toLowerCase();

      // Check if the search input includes "hotel", "tour" or "service"
      if (searchInput.includes('hotel', 'Hotel', 'HOTEL')) {
        window.location.href = '/registration/hotel.php';
      } else if (searchInput.includes('packages', 'Packages', 'package', 'Packages')) {
        window.location.href = '/registration/package.php';
      } else if (searchInput.includes('service')) {
        window.location.href = '/service';
      } else {
        alert('Please enter a valid search term such as "hotel", "packages", or "service".');
      }
    });

    const options = {
      root: null, // Use the viewport as the container
      rootMargin: '0px',
      threshold: 0.1 // Adjust this threshold as needed
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('show');
        } else {
          entry.target.classList.remove('show');
        }
      });
    }, options);

    // Select the single element with the ID 'text'
    const section = document.getElementById('text');
    // Observe the selected section
    observer.observe(section);
  </script>

</body>

</html>