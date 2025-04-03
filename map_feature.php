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
  <title>Location Search with HERE Maps</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
  <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
  <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
  <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
  <script src="https://js.api.here.com/v3/3.1/mapsjs-data.js"></script>
  <link rel="stylesheet" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css">
  <link rel="stylesheet" href="index.css">
  <style>
    #map {
      height: 100vh;
      width: 100%;
    }

    .sidebar {
      height: 100vh;
      overflow-y: auto;
    }

    .custom-marker-info {
      max-width: 250px;
      font-size: 0.9em;
    }

    .btn-map-action {
      margin-bottom: 10px;
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
              <a class="nav-link text-dark" href="home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="about.php">About us</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link text-dark" href="#" role="button" data-bs-toggle="dropdown">Places</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="package.php">Packages</a></li>
                <li><a class="dropdown-item" href="blog.php">Blogs</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="hotel.php">Hotels</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link text-dark" href="#" role="button" data-bs-toggle="dropdown">Transport</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="flights.php">Flight</a></li>
                <li><a class="dropdown-item" href="trains.php">Train</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="map_features.php">Map Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="contact.php">Contact</a>
            </li>
            <?php
            if (isset($_SESSION['username'])): ?>
              <li class="nav-item">
                <a class="nav-link text-dark" data-bs-target="#demo" data-bs-toggle="offcanvas">Welcome, <?php echo $_SESSION['username']; ?></a>
              </li>
            <?php else: ?>
              <li class="nav-item dropdown">
                <a class="nav-link text-dark " href="#" data-bs-toggle="dropdown"><i class="fa-solid fa-circle-user fa-lg"></i>Create Account</a>
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
  <div class="container-fluid" style="margin-top:70px;background-attachment: fixed;">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 sidebar bg-light p-3">
        <h5 class="text-center">Map Features</h5>
        <hr>

        <!-- Location Search -->
        <div class="form-group">
          <label for="locationSearch">Search Location</label>
          <input type="text" id="location-input" class="form-control" placeholder="Enter location">
          <button class="btn btn-primary btn-block mt-2" id="search-button">Search</button>
        </div>

        <!-- Feature Toggles -->
        <div class="form-group">
          <label>Feature Toggles</label>
          <div>
            <a href="hotel_search_map.php" class="btn btn-map-action btn-primary btn-block" id="hotelsBtn">Show
              Hotels</a>
            <a href="route_selector.php" class="btn btn-map-action btn-secondary btn-block" id="routesBtn">Get Route</a>
            <button class="btn btn-map-action btn-success btn-block" id="trafficToggleBtn">Toggle Traffic</button>
            <button class="btn btn-map-action btn-info btn-block" id="weatherBtn">Show Weather</button>
            <button class="btn btn-block btn-map-action btn-warning" id="measureDistanceBtn">Measure Distance</button>
          </div>
        </div>

        <!-- Heatmaps -->
        <div class="form-group">
          <label>Heatmaps</label>
          <button class="btn btn-warning btn-block btn-map-action" id="heatmapBtn">Show Heatmap</button>
        </div>
        <div claass="form-group">
          <label for="">Drawing Tool</label>
          <button class="btn btn-block btn-primary" id="drawPolygon">Draw Polygon</button>
          <button id="finalizePolygon" class="btn btn-success">Finalize Polygon</button>
          <button class="btn btn-block btn-secondary" id="clearShapes">Clear Shapes</button>
        </div>
      </div>

      <!-- Map Section -->
      <div class="col-md-9">
        <div id="map"></div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    
  <script>
    // Initialize HERE Maps Platform
    const apiKey = 'ETSBpLUhFrIleBXFKSmgVDCayx_0330hfuJ4ytGujIA'; // Replace with your HERE API key
    const platform = new H.service.Platform({
      apikey: apiKey
    });
    const defaultLayers = platform.createDefaultLayers();

    // Create the map
    const map = new H.Map(
      document.getElementById('map'),
      defaultLayers.vector.normal.map, {
        center: {
          lat: 20.5937,
          lng: 78.9629
        }, // Default center (India)
        zoom: 6,
      }
    );

    // Enable map interaction (zoom, drag, etc.)
    const behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
    const ui = H.ui.UI.createDefault(map, defaultLayers);


    //MeasureDistance
    document.getElementById('measureDistanceBtn').addEventListener('click', () => {
      let points = [];
      map.addEventListener('tap', (evt) => {
        const coord = map.screenToGeo(evt.currentPointer.viewportX, evt.currentPointer.viewportY);
        points.push(coord);

        map.addObject(new H.map.Marker(coord));

        if (points.length === 2) {
          const distance = points[0].distance(points[1]);
          alert(`Distance: ${(distance / 1000).toFixed(2)} km`);
          points = [];
        }
      });
    });

    //ToggletrafficFunction
    let trafficLayer = null;

    function toggleTraffic() {
      if (!trafficLayer) {
        // Create a traffic flow layer using Traffic API v7
        trafficLayer = platform.getMapTileService({
          type: 'base'
        }).createTileLayer(
          'traffic',
          'flow',
          256,
          'png8'
        );
        map.addLayer(trafficLayer);
        console.log('Traffic Layer Enabled');
      } else {
        // Remove the traffic layer if it already exists
        map.removeLayer(trafficLayer);
        trafficLayer = null;
        console.log('Traffic Layer Disabled');
      }
    }
    document.getElementById('trafficToggleBtn').addEventListener('click', toggleTraffic);


    //search function
    function searchLocation(query) {
      if (!query) {
        alert('Please enter a location!');
        return;
      }

      const geocodeUrl = `https://geocode.search.hereapi.com/v1/geocode?q=${encodeURIComponent(query)}&apiKey=${apiKey}`;

      console.log(`Geocoding URL: ${geocodeUrl}`); // Log the request URL

      fetch(geocodeUrl)
        .then((response) => {
          if (!response.ok) {
            throw new Error(`Geocoding failed with status: ${response.status}`);
          }
          return response.json();
        })
        .then((data) => {
          if (data.items.length > 0) {
            const location = data.items[0].position;
            console.log('Geocoding result:', location);

            map.setCenter({
              lat: location.lat,
              lng: location.lng
            });
            map.setZoom(14);

            const marker = new H.map.Marker({
              lat: location.lat,
              lng: location.lng
            });
            map.addObject(marker);
          } else {
            alert('No results found for this location.');
          }
        })
        .catch((error) => {
          console.error('Geocoding fetch error:', error);
          alert('Failed to find the location. Please try again.');
        });
    }
    // Add event listener to the search button
    document.getElementById('search-button').addEventListener('click', () => {
      const query = document.getElementById('location-input').value.trim();
      searchLocation(query);
    });


    //ShowWeather
    function fetchHereWeather(lat, lng) {
      const weatherUrl = `https://weather.ls.hereapi.com/weather/1.0/report.json?apiKey=${apiKey}&product=observation&latitude=${lat}&longitude=${lng}`;

      fetch(weatherUrl)
        .then((response) => {
          if (!response.ok) {
            throw new Error(`Weather fetch failed: ${response.statusText}`);
          }
          return response.json();
        })
        .then((data) => {
          const observation = data.observations.location[0].observation[0];
          const weatherInfo = `
                Location: ${observation.city}, ${observation.state}
                Weather: ${observation.description}
                Temperature: ${observation.temperature}°C
                Humidity: ${observation.humidity}%
                Wind Speed: ${observation.windSpeed} km/h
            `;
          alert(weatherInfo);
        })
        .catch((error) => {
          console.error('Error fetching weather data:', error);
          alert('Failed to fetch weather data. Please try again.');
        });
    }

    function showWeatherHere() {
      // Add a click event listener to the map
      map.addEventListener('tap', (evt) => {
        // Get the geographic coordinates of the clicked point
        const coord = map.screenToGeo(
          evt.currentPointer.viewportX,
          evt.currentPointer.viewportY
        );

        // Fetch and display weather information for the clicked location
        fetchHereWeather(coord.lat, coord.lng);
      });

      alert('Click on the map to see the weather at that location.');
    }
    document.getElementById('weatherBtn').addEventListener('click', showWeatherHere);

    function addHeatmap() {
      const dataPoints = [{
          lat: 19.076,
          lng: 72.8777,
          value: 1
        }, // Mumbai
        {
          lat: 28.7041,
          lng: 77.1025,
          value: 0.8
        }, // Delhi
        {
          lat: 13.0827,
          lng: 80.2707,
          value: 0.6
        }, // Chennai
        {
          lat: 22.5726,
          lng: 88.3639,
          value: 0.4
        }, // Kolkata
        {
          lat: 12.9716,
          lng: 77.5946,
          value: 0.9
        }, // Bangalore
      ];

      // Create heatmap provider
      const heatmapProvider = new H.data.heatmap.Provider({
        colors: new H.data.heatmap.Colors({
          '0': 'rgba(0, 0, 255, 0.8)', // Blue
          '0.5': 'rgba(255, 255, 0, 0.8)', // Yellow
          '1': 'rgba(255, 0, 0, 0.8)', // Red
        }),
      });

      // Add data points to the provider
      dataPoints.forEach((point) => {
        heatmapProvider.addData([{
          lat: point.lat,
          lng: point.lng,
          value: point.value
        }]);
      });

      // Create heatmap layer and add it to the map
      const heatmapLayer = new H.map.layer.TileLayer(heatmapProvider);
      map.addLayer(heatmapLayer);

      alert('Heatmap added to the map.');
    }

    // Bind the heatmap functionality to the button
    document.getElementById('heatmapBtn').addEventListener('click', addHeatmap);

    //Drawing Tool
    const drawnShapes = [];

    function enableUserDefinedPolygon() {
      alert("Select point to draw polygon");
      const lineString = new H.geo.LineString(); // Store user-defined points
      const markers = []; // Store markers for visual feedback

      // Add a click event listener to capture points
      map.addEventListener('tap', (evt) => {
        const coord = map.screenToGeo(evt.currentPointer.viewportX, evt.currentPointer.viewportY);

        // Add the clicked point to the LineString
        lineString.pushPoint({
          lat: coord.lat,
          lng: coord.lng
        });

        // Add a marker to show the clicked point
        const marker = new H.map.Marker({
          lat: coord.lat,
          lng: coord.lng
        });
        map.addObject(marker);
        markers.push(marker);

        //alert(`Point added: Latitude: ${coord.lat.toFixed(6)}, Longitude: ${coord.lng.toFixed(6)}`);
      });

      // Finalize and draw the polygon
      document.getElementById('finalizePolygon').addEventListener('click', () => {
        if (lineString.getPointCount() < 3) {
          alert('At least 3 points are required to create a polygon!');
          return;
        }

        // Create and add the polygon to the map
        const polygon = new H.map.Polygon(lineString, {
          style: {
            fillColor: 'rgba(0, 128, 255, 0.5)', // Semi-transparent blue
            strokeColor: 'blue',
            lineWidth: 2,
          },
        });
        map.addObject(polygon);
        drawnShapes.push(polygon);
        // Clear markers and stop listening for clicks
        markers.forEach(marker => map.removeObject(marker));
        map.removeEventListener('tap');

        alert('Polygon created successfully!');
      });
    }

    function clearShapes() {
      drawnShapes.forEach(shape => map.removeObject(shape));
      drawnShapes.length = 0;
    }
    // Add buttons for user interaction in your sidebar
    document.getElementById('drawPolygon').addEventListener('click', enableUserDefinedPolygon);
    document.getElementById('clearShapes').addEventListener('click', clearShapes);
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