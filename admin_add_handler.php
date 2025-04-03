<?php
// Include database configuration
include 'setup_database.php';

// Connect to the database
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST method detected.<br>";
    echo "Data received: ";
    print_r($_POST);
} else {
    http_response_code(405);
    die("Error: Only POST method is allowed.");
}

// Check if the 'type' parameter exists
if (!isset($_POST['type'])) {
    die("Error: Missing 'type' parameter.");
}

// Get the type from the POST data
$type = $_POST['type'];
$data = $_POST; 

if ($type === 'hotel') {
    if (!isset($data['name'], $data['location'], $data['price_per_night'], $data['description'],$data['state_id'],$data['city_id'])) {
        die("Error: Missing fields for hotels.");
    }

    $query = "INSERT INTO hotels (name, location, price_range, description,state_id,city_id) VALUES (?, ?, ?, ?,?,?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param(
        "ssdsdd",
        $data['name'],
        $data['location'],
        $data['price_per_night'],
        $data['description'],
        $data['state_id'],
        $data['city_id']
    );

    if ($stmt->execute()) {
        echo "Hotel record added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
else if ($type === 'flights') {
    if (!isset($data['origin'], $data['destination'],$data['departure_time'], $data['arrival_time'],$data['class'], $data['price'],$data['seats_available'])) {
        die("Error: Missing fields for flights.");
    }

    $query = "INSERT INTO flights (origin,destination, departure_time, arrival_time,class, price,seats_available) VALUES (?, ?, ?, ?,?,?,?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param(
        "ssddsdd",
        $data['origin'], 
        $data['destination'],
        $data['departure_time'], 
        $data['arrival_time'],
        $data['class'], 
        $data['price'],
        $data['seats_available']
    );

    if ($stmt->execute()) {
        echo "Flight record added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
else if ($type === 'trains') {
    if (!isset($data['train_name'], $data['departure'], $data['arrival'], $data['ticket_price'])) {
        die("Error: Missing fields for trains.");
    }

    $query = "INSERT INTO trains (train_name, departure_time, arrival_time, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param(
        "sssd",
        $data['train_name'],
        $data['departure'],
        $data['arrival'],
        $data['ticket_price']
    );

    if ($stmt->execute()) {
        echo "Train record added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
// Handle package insertion
else if ($type === 'packages') {
    if (!isset($data['package_name'],  $data['price'],$data['description'],$data['duration'],$data['destination'],$data['inclusions'],$data['exclusions'],$data['images'],$data['itinerary'],$data['state_id'],$data['city_id'])) {
        die("Error: Missing fields for packages.");
    }

    $query = "INSERT INTO packages (name, price,description,duration, destinations,inclusions,exclusions,images,itinerary,state_id,city_id) VALUES (?, ?, ?, ?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param(
        "sdsssssssdd",
        $data['package_name'],  
        $data['price'],
        $data['description'],
        $data['duration'],
        $data['destination'],
        $data['inclusions'],
        $data['exclusions'],
        $data['images'],
        $data['itinerary'],
        $data['state_id'],
        $data['city_id']
    );

    if ($stmt->execute()) {
        echo "Package record added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
// Handle invalid type
else {
    die("Error: Unknown type specified.");
}

// Close the database connection
$conn->close();
?>
