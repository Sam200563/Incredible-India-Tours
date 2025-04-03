<?php
// fetch_flights.php
include 'setup_database.php';
$servername = "localhost";
$username = "root"; // Change as necessary
$password = ""; // Change as necessary
$db = "travel";
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$origin = $_POST['origin'];
$destination = $_POST['destination'];
$travelDate = $_POST['travelDate'];
$class = $_POST['class'];

// Query to fetch matching flights
$sql = "SELECT * FROM flights 
        WHERE origin = ? AND destination = ? AND DATE(departure_time) = ? AND class = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $origin, $destination, $travelDate, $class);
$stmt->execute();

$result = $stmt->get_result();
$flights = [];

while ($row = $result->fetch_assoc()) {
    $flights[] = $row;
}

// Return JSON response
echo json_encode($flights);

$stmt->close();
}
$conn->close();

?>
