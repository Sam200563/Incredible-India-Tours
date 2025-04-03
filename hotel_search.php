<?php
include 'setup_database.php';
$servername = "localhost";
$username = "root"; // Change as necessary
$password = ""; // Change as necessary
$db = "travel";
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$city_id = intval($_POST['city_id']);
$checkin_date = $_POST['checkin_date'];
$checkout_date = $_POST['checkout_date'];

// Fetch city details for geocoding
$city_stmt = $conn->prepare("SELECT city_name, state_id FROM city WHERE city_id = ?");
$city_stmt->bind_param("i", $city_id);
$city_stmt->execute();
$city_result = $city_stmt->get_result();
$city_data = $city_result->fetch_assoc();

if ($city_data) {
    $city_name = $city_data['city_name'];

    // Fetch state name
    $state_stmt = $conn->prepare("SELECT state_name FROM state WHERE state_id = ?");
    $state_stmt->bind_param("i", $city_data['state_id']);
    $state_stmt->execute();
    $state_result = $state_stmt->get_result();
    $state_data = $state_result->fetch_assoc();
    $state_name = $state_data['state_name'];

    // Use HERE Geocoding API to get latitude and longitude
    $apiKey = "ETSBpLUhFrIleBXFKSmgVDCayx_0330hfuJ4ytGujIA"; // Replace with your API key
    $address = urlencode("$city_name, $state_name");
    $geocode_url = "https://geocode.search.hereapi.com/v1/geocode?q=$address&apiKey=$apiKey";

    $geocode_response = file_get_contents($geocode_url);
    $geocode_data = json_decode($geocode_response, true);

    if (!empty($geocode_data['items'])) {
        $latitude = $geocode_data['items'][0]['position']['lat'];
        $longitude = $geocode_data['items'][0]['position']['lng'];

        // Insert latitude and longitude into the database
        $update_stmt = $conn->prepare("UPDATE city SET latitude = ?, longitude = ? WHERE city_id = ?");
        $update_stmt->bind_param("ddi", $latitude, $longitude, $city_id);
        $update_stmt->execute();
    }
}

// Fetch hotels based on the city_id
$stmt = $conn->prepare("SELECT id, name, location, price_range, images FROM hotels WHERE city_id = ?");
$stmt->bind_param("i", $city_id);
$stmt->execute();
$result = $stmt->get_result();

// Display hotels
while ($hotel = $result->fetch_assoc()) {
    echo "
    <div class='col-md-4 mb-4'>
                <div class='card d-flex' style='width:355px !important;'>
                  <img class='card-img-top' src='" . htmlspecialchars($hotel['images']) . "' alt='Hotel Image' height='160'>
                  <div class='card-body'>
                    <h5 class='card-title' style='font-size:30px !important;'>" . htmlspecialchars($hotel['name']) . "</h5>
                    <p class='card-text'>" . htmlspecialchars($hotel['location']) . "</p>
                    <p class='card-text'><strong>Price:</strong> ₹" . htmlspecialchars($hotel['price_range']) . " per night</p>
                    <a href='hotel_details.php?id=" . $hotel['id'] . "' class='btn btn-primary'>View Details</a>
                  </div>
                </div>
              </div>";
}
?>
