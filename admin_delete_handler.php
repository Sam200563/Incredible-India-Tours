<?php
// Include database configuration
include 'setup_database.php';

// Connect to the database
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    die("Error: Only POST method is allowed.");
}

// Check if 'type' and 'id' are set
if (!isset($_POST['type']) || !isset($_POST['id'])) {
    die("Error: Missing 'type' or 'id' parameter.");
}

// Sanitize input
$type = sanitize_input($_POST['type']);
$id = (int) sanitize_input($_POST['id']); // Cast to int for safety

// Define the table based on the type
$table = '';
switch ($type) {
    case 'hotel':
        $table = 'hotels';
        break;
    case 'flight':
        $table = 'flights';
        break;
    case 'train':
        $table = 'trains';
        break;
    case 'package':
        $table = 'packages';
        break;
    default:
        die("Error: Unknown type specified.");
}

// Prepare the SQL query
$query = "DELETE FROM $table WHERE id = ?";
$stmt = $conn->prepare($query);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die("Error preparing query: " . $conn->error);
}

// Bind parameters and execute the query
$stmt->bind_param("d", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo ucfirst($type) . " record with ID $id has been deleted successfully.";
    } else {
        echo "No record found with ID $id in $table.";
    }
} else {
    echo "Error executing query: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Sanitize function
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}
