<?php
session_start();
include 'setup_database.php'; // Database connection
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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to save items to your wishlist.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Validate and retrieve POST data
$item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : null;
$item_type = isset($_POST['item_type']) ? $_POST['item_type'] : null;

if (!$item_id || !$item_type) {
    echo "Invalid input.";
    exit;
}

// Validate item type
$valid_types = ['package', 'flight', 'hotel','train'];
if (!in_array(strtolower($item_type), $valid_types)) {
    echo "Invalid item type.";
    exit;
}

// Check if the item is already in the wishlist
$sql_check = "SELECT * FROM wishlist WHERE user_id = ? AND item_id = ? AND item_type = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("iis", $user_id, $item_id, $item_type);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "This item is already in your wishlist.";
} else {
    // Insert item into wishlist
    $sql_insert = "INSERT INTO wishlist (user_id, item_id, item_type) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iis", $user_id, $item_id, $item_type);

    if ($stmt_insert->execute()) {
        echo "Item added to your wishlist successfully!";
    } else {
        echo "Error adding to wishlist: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>
