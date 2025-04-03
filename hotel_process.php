<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'setup_database.php';
include 'send_email.php';

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$hotel_id = $_POST['id'];
$room_type_id = $_POST['room_type'];
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$guests = intval($_POST['guests']);
$price_range = $_POST['price_per_night'];
$contact_info = strval($_POST['contact_info']); 
$room_type=$_POST['room_name'];

if ($hotel_id <= 0 || $room_type_id <= 0 || $guests <= 0) {
    die("Invalid booking details.");
}

if (!isset($_POST['contact_info']) || empty($contact_info)) {
    die("Contact information is missing.");
}

// Check room availability
$sql = "SELECT available_rooms FROM hotel_rooms WHERE id = ? FOR UPDATE";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $room_type_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $room = $result->fetch_assoc();
    if ($room['available_rooms'] < $guests) {
        die("Sorry, not enough rooms are available for the selected type.");
    }
} else {
    die("Room type not found.");
}
$stmt->close();

// Reduce the number of available rooms
$sql = "UPDATE hotel_rooms SET available_rooms = available_rooms - ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $guests, $room_type_id);

if (!$stmt->execute()) {
    die("Error updating room availability: " . $stmt->error);
}
$stmt->close();

// Insert the booking into the database
$sql = "INSERT INTO hotel_bookings (user_id, hotel_id, room_type, check_in_date, check_out_date, guests,total_price, contact_info, booking_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?,?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssiss", $user_id, $hotel_id, $room_type, $check_in_date, $check_out_date, $guests, $price_range, $contact_info);

if ($stmt->execute()) {
    $booking_id = $conn->insert_id;
    echo "Inserted Contact Number: " . $contact_info;
    $user_email_query = "SELECT email FROM users WHERE user_id = ?";
    $user_email_stmt = $conn->prepare($user_email_query);
    $user_email_stmt->bind_param("i", $user_id);
    $user_email_stmt->execute();
    $user_email_result = $user_email_stmt->get_result();
    $user_email = $user_email_result->fetch_assoc()['email'];

    $hotel_details_query = "SELECT name,location FROM hotels WHERE id = ?";
    $hotel_details_stmt = $conn->prepare($hotel_details_query);
    $hotel_details_stmt->bind_param("i", $hotel_id);
    $hotel_details_stmt->execute();
    $hotel_details_result = $hotel_details_stmt->get_result();
    $hotel_details = $hotel_details_result->fetch_assoc();

    $hotel_room_details_query = "SELECT room_type FROM hotel_rooms WHERE id = ?";
    $hotel_room_details_stmt = $conn->prepare($hotel_room_details_query);
    $hotel_room_details_stmt->bind_param("i", $room_type_id);
    $hotel_room_details_stmt->execute();
    $hotel_room_details_result = $hotel_room_details_stmt->get_result();
    $hotel_room_details = $hotel_room_details_result->fetch_assoc();

    // Send confirmation email
    $subject = "Hotel Booking Confirmation - IncredibleIndia Tours";
    $body = "
                    <h3>Dear User,</h3>
                    <p>Your Hotel booking is confirmed.</p>
                    <p><strong>Hotel Details:</strong></p>
                    <p>Hotel Name: {$hotel_details['name']}</p>
                    <p>Location: {$hotel_details['location']}</p>                   
                    <p>Room Type: {$hotel_room_details['room_type']}</p>
                    <p>Number of guests: {$guests}</p> 
                    <p>Total Price: {$price_range}</p>
                    <p>Booking Date: " . date("Y-m-d H:i:s") . "</p>
                    <p>Thank you for choosing IncredibleIndia Tours.</p>
                ";

    // Send the email
    if (sendBookingEmail($user_email, $subject, $body)) {
        echo "Booking successful! A confirmation email has been sent.";
    } else {
        echo "Booking successful, but email not sent.";
    }
    header("Location: hotel_confirm.php?id=" . $booking_id);
    exit;
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
