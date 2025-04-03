<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Results</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php
        include 'setup_database.php'; // Include your database connection file
        $servername = "localhost";
        $username = "root"; // Change as necessary
        $password = ""; // Change as necessary
        $db = "travel";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $service_type = $_GET['service_type'];
        $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
        $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 50000;

        // Determine the table and query based on service type
        if ($service_type === "flights") {
            $query = "SELECT * FROM flights WHERE price BETWEEN ? AND ?";
        } elseif ($service_type === "trains") {
            $query = "SELECT * FROM trains WHERE price BETWEEN ? AND ?";
        } elseif ($service_type === "hotels") {
            $query = "SELECT * FROM hotels WHERE price_range BETWEEN ? AND ?";
        } elseif ($service_type === "packages") {
            $query = "SELECT * FROM packages WHERE price BETWEEN ? AND ?";
        } else {
            echo "<p>Invalid service type selected.</p>";
            exit;
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $min_price, $max_price);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='row'>";
            while ($row = $result->fetch_assoc()) {
                if ($service_type === "flights") {
                    echo "<div class='col-md-3'>
                            <div class='card mb-3'>
                                <div class='card-body'>
                                    <h5 class='card-title'>Flight: " . htmlspecialchars($row['origin']) . "→".htmlspecialchars($row['destination'])."</h5>
                                    <p class='card-text'>Price: ₹" . htmlspecialchars($row['price']) . "</p>
                                    <p class='card-text'>Class: " . htmlspecialchars($row['class']). "</p>
                                    <a class='btn btn-primary' href='flight_detail.php?id=" . htmlspecialchars($row['id']) . "'>View Details</a>
                                </div>
                            </div>
                          </div>";
                } elseif ($service_type === "trains") {
                    echo "<div class='col-md-3'>
                            <div class='card mb-3'>
                                <div class='card-body'>
                                    <h3 class='card-title'>Train: " . htmlspecialchars($row['train_name']) . "</h3>
                                    <p class='card-text'>Price: ₹" . htmlspecialchars($row['price']) . "</p>
                                    <p class='card-text'>From: " . htmlspecialchars($row['departure_city']) . " To: " . htmlspecialchars($row['arrival_city']) . "</p>
                                    <a class='btn btn-primary' href='flight_detail.php?id=" . htmlspecialchars($row['id']) . "'>View Details</a>

                                </div>
                            </div>
                          </div>";
                } elseif ($service_type === "packages") {
                    echo "<div class='col-md-3'>
                            <div class='card mb-3'>
                                <div class='card-body'>
                                    <h3 class='card-title'>Package: " . htmlspecialchars($row['package_name']) . "</h3>
                                    <p class='card-text'>Price: ₹" . htmlspecialchars($row['price']) . "</p>
                                    <p class='card-text'>Destination: " . htmlspecialchars($row['destination']) . "</p>
                                    <a class='btn btn-primary' href='package_detail.php?id=" . htmlspecialchars($row['id']) . "'>View Details</a>
                                </div>
                            </div>
                          </div>";
                } elseif ($service_type === "hotels") {
                    echo "<div class='col-md-3'>
                            <div class='card mb-3'>
                                <div class='card-body'>
                                    <h5 class='card-title' style='font-size:20px!important;'>Hotel: " . htmlspecialchars($row['name']) . "</h5>
                                    <p class='card-text'>Price: ₹" . htmlspecialchars($row['price_range']) . "</p>
                                    <p class='card-text'>Destination: " . htmlspecialchars($row['location']) . "</p>
                                    <a class='btn btn-primary' href='hotel_details.php?id=" . htmlspecialchars($row['id']) . "'>View Details</a>
                                </div>
                            </div>
                          </div>";
                }
            }
            echo "</div>";
        } else {
            echo "<p>No results found in this price range for the selected service type.</p>";
        }
        ?>
    </div>

    <!-- Add Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
