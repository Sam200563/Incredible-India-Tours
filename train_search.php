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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $source = $_POST['source'] ?? '';
$destination = $_POST['destination'] ?? '';
$date = $_POST['date'] ?? '';
$min_price = $_POST['min_price'] ?? 0;
$max_price = $_POST['max_price'] ?? 50000;
    
    // Query to fetch matching flights
    $sql = "SELECT * FROM trains 
        WHERE source LIKE ? 
          AND destination LIKE ? 
          AND date_of_journey = ? 
          AND price BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $source = "%$source%";
    $destination = "%$destination%";
    $stmt->bind_param('sssii', $source, $destination, $date, $min_price, $max_price);
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
