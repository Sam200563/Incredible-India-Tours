<?php
include 'setup_database.php';

$servername = "localhost";
$username = "root"; // Update as needed
$password = ""; // Update as needed
$db = "travel";

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$input = json_decode(file_get_contents('php://input'), true);
$city_id = intval($input['city_id']);

$stmt = $conn->prepare("SELECT * FROM hotels WHERE city_id = ?");
$stmt->bind_param("i", $city_id);
$stmt->execute();
$result = $stmt->get_result();

$hotels = [];
while ($row = $result->fetch_assoc()) {
    $hotels[] = $row;
}

echo json_encode($hotels);

$stmt->close();
$conn->close();
?>
