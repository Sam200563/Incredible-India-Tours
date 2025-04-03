<?php
session_start();
require_once 'setup_database.php';
$servername = "localhost";
$username = "root";
$password = ""; 
$db = "travel";
$conn = new mysqli($servername, $username, $password, $db);
$query = "SELECT * FROM blogs ORDER BY blog_created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IncredibleIndia Tours Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="index.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    .blog-header {
      background-color: #007bff;
      color: white;
      padding: 2rem;
      text-align: center;
      height: 300px;
    }

    .blog-card {
      margin: 2rem auto;
      max-width: 800px;
      padding: 1.5rem;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .blog-title {
      font-size: 1.8rem;
      color: #007bff;
    }

    .blog-footer {
      text-align: center;
      padding: 1rem;
      background-color: #343a40;
      color: white;
    }

    .footer1 {
      background-repeat: no-repeat;
      background-position: center center;
      background-color: #040E27;
      position: relative;
      margin-top: 50px;
      z-index: 0;
    }
  </style>
</head>

<body>
  <header class="blog-header">
    <div class="hotel">
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
                <a class="nav-link text-light" href="map_feature.html">Map Features</a>
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
    </div>
    <div class="title" style="margin: 80px;">
      <h1>IncredibleIndia Tours Blog</h1>
      <p>Explore travel stories, tips, and updates from IncredibleIndia Tours!</p>
    </div>
    <div class="offcanvas offcanvas-end" id="demo">
      <div class="offcanvas-header d-flex align-items-center">
        <div class="profile-icon bg-dark text-white d-flex align-items-center justify-content-center rounded-circle">
          <span class="initials">
            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
          </span>
        </div>
        <div class="ms-3">
          <h5 class="offcanvas-title m-0"><?php echo $_SESSION['username']; ?></h5>
          <p class="text-muted small mb-0"><?php echo $_SESSION['email']; ?></p>
        </div>
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
  </header>
  <main>
    <div class="container">
      <h2 class="mt-4">Submit Your Blog</h2>
      <form action="upload_blog.php" method="POST" class="mb-5" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="blogTitle" class="form-label">Blog Title</label>
          <input type="text" class="form-control" id="blogTitle" name="title" required>
        </div>
        <div class="mb-3">
          <label for="blogContent" class="form-label">Content</label>
          <textarea class="form-control" id="blogContent1" name="content" rows="5" required></textarea>
        </div>
        <div class="mb-3">
          <label for="blogImage" class="form-label">Upload Image (Optional)</label>
          <input type="file" class="form-control" id="blogImage" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Submit Blog</button>
      </form>

      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="blog-card">
          <h2 class="blog-title"><?php echo htmlspecialchars($row['title']); ?></h2>
          <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($row['blog_created_at'])); ?></p>
          <p><?php echo substr(htmlspecialchars($row['content']), 0, 150); ?>...</p>
          <button class="btn btn-primary read-more-btn"
            data-title="<?php echo htmlspecialchars($row['title']); ?>"
            data-content="<?php echo htmlspecialchars($row['content']); ?>"
            data-date="<?php echo date('F j, Y', strtotime($row['blog_created_at'])); ?>"
            data-bs-toggle="modal" data-bs-target="#blogModal">
            Read More
          </button>
        </div>
      <?php } ?>
    </div>
    <div class="modal fade" id="blogModal" tabindex="-1" aria-labelledby="blogModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="blogModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p><strong>Date:</strong> <span id="blogDate"></span></p>
            <p id="blogContent"></p>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer1">
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
    
  <script src="index.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll(".read-more-btn").forEach(button => {
        button.addEventListener("click", function() {
          const title = this.getAttribute("data-title");
          const content = this.getAttribute("data-content");
          const date = this.getAttribute("data-date");

          document.getElementById("blogModalLabel").textContent = title;
          document.getElementById("blogDate").textContent = date;
          document.getElementById("blogContent").textContent = content;
        });
      });
    });
  </script>

</body>

</html>