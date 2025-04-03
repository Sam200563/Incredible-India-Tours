<?php
// Include database configuration
include 'setup_database.php';

// Connect to the database
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Handle POST requests only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Error: Only POST method is allowed.");
}

// Check if 'type' is provided in POST data
if (!isset($_POST['type'])) {
    die("Error: Missing 'type' parameter.");
}

$type = sanitize_input($_POST['type']);
$data = $_POST;

// Hotel update handling
if ($type === 'hotel') {
    if (!isset($data['id'], $data['name'], $data['location'], $data['price_per_night'], $data['description'], $data['state_id'], $data['city_id'])) {
        die("Error: Missing required fields for hotel update.");
    }

    $id = sanitize_input($data['id']);
    $name = sanitize_input($data['name']);
    $location = sanitize_input($data['location']);
    $price = sanitize_input($data['price_per_night']);
    $description = sanitize_input($data['description']);
    $state_id = sanitize_input($data['state_id']);
    $city_id = sanitize_input($data['city_id']);

    $query = "UPDATE hotels SET name = ?, location = ?, price_range = ?, description = ?, state_id = ?, city_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param("ssssddd", $name, $location, $price, $description, $state_id, $city_id, $id);

    if ($stmt->execute()) {
        echo "Hotel record updated successfully.";
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
}
// Flight update handling
else if ($type === 'flights') {
    if (!isset($data['id'], $data['origin'], $data['destination'], $data['departure_time'], $data['arrival_time'], $data['class'], $data['price'], $data['seats_available'])) {
        die("Error: Missing required fields for flight update.");
    }

    $id = sanitize_input($data['id']);
    $origin = sanitize_input($data['origin']);
    $destination = sanitize_input($data['destination']);
    $departure_time = sanitize_input($data['departure_time']);
    $arrival_time = sanitize_input($data['arrival_time']);
    $class = sanitize_input($data['class']);
    $price = sanitize_input($data['price']);
    $seats_available = sanitize_input($data['seats_available']);

    $query = "UPDATE flights SET origin = ?, destination = ?, departure_time = ?, arrival_time = ?, class = ?, price = ?, seats_available = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param("ssssssdd", $origin, $destination, $departure_time, $arrival_time, $class, $price, $seats_available, $id);

    if ($stmt->execute()) {
        echo "Flight record updated successfully.";
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
}
// Package update handling
else if ($type === 'packages') {
    if (!isset($data['id'], $data['package_name'], $data['price'], $data['description'], $data['duration'], $data['destination'], $data['inclusions'], $data['exclusions'], $data['images'], $data['itinerary'], $data['state_id'], $data['city_id'])) {
        die("Error: Missing required fields for package update.");
    }

    $id = sanitize_input($data['id']);
    $package_name = sanitize_input($data['package_name']);
    $price = sanitize_input($data['price']);
    $description = sanitize_input($data['description']);
    $duration = sanitize_input($data['duration']);
    $destination = sanitize_input($data['destination']);
    $inclusions = sanitize_input($data['inclusions']);
    $exclusions = sanitize_input($data['exclusions']);
    $images = sanitize_input($data['images']);
    $itinerary = sanitize_input($data['itinerary']);
    $state_id = sanitize_input($data['state_id']);
    $city_id = sanitize_input($data['city_id']);

    $query = "UPDATE packages SET name = ?, price = ?, description = ?, duration = ?, destinations = ?, inclusions = ?, exclusions = ?, images = ?, itinerary = ?, state_id = ?, city_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param("sdsssssssss", $package_name, $price, $description, $duration, $destination, $inclusions, $exclusions, $images, $itinerary, $state_id, $city_id, $id);

    if ($stmt->execute()) {
        echo "Package record updated successfully.";
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
}
// Invalid type handling
else {
    die("Error: Unknown 'type' parameter value.");
}

// Close the database connection
$conn->close();
?>
