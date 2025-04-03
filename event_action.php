<?php
$servername = "localhost";
$username = "root"; // Change as necessary
$password = ""; // Change as necessary
$db = "calendar";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$id = $_POST['id'] ?? null; // Null if adding a new event
$title = $conn->real_escape_string($_POST['title']);
$description = $conn->real_escape_string($_POST['description']);
$date = $conn->real_escape_string($_POST['date']);
$time = $conn->real_escape_string($_POST['time']);
$location = $conn->real_escape_string($_POST['location']);
$organizer = $conn->real_escape_string($_POST['organizer']);
$price = $conn->real_escape_string($_POST['price']);

// Check if editing or adding
if ($id) {
    // Update existing event
    $sql = "UPDATE event SET title = '$title', description = '$description', date = '$date', time = '$time', location = '$location', organizer = '$organizer', price = '$price' WHERE id = $id";
} else {
    // Insert new event
    $sql = "INSERT INTO event (event_name, description, event_date, event_time, location) VALUES ('$title', '$description', '$date', '$time', '$location')";
}

if ($conn->query($sql) === TRUE) {
    echo "Event saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
