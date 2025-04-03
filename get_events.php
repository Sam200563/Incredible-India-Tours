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

// Query to get events
$sql = "SELECT event_id, event_name, event_date, event_time FROM event";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format event data for calendar
        $events[] = [
            'id' => $row['event_id'],
            'title' => $row['event_name'],
            'start' => $row['event_date'] . 'T' . $row['event_time'], // FullCalendar requires ISO datetime format
            'display'=>'block'
        ];
    }
}

echo json_encode($events);

$conn->close();
?>
