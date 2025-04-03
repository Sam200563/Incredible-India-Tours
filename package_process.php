<?php
session_start();
include 'setup_database.php';
include 'send_email.php';
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

$user_id = $_SESSION['user_id'];
$package_id = $_POST['package_id'];
$travel_dates = $_POST['travel_dates'];
$num_people = $_POST['num_people'];
$contact_info = $_POST['contact_info'];
$package_name = $_POST['name'];
$total_price = $_POST['price'] * $_POST['num_people'];
$sql = "INSERT INTO package_bookings (package_id, user_id,travel_dates, num_people, contact_info,package_name,total_price) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissssd", $package_id, $user_id, $travel_dates, $num_people, $contact_info, $package_name, $total_price);

if ($stmt->execute()) {
    $booking_id = $conn->insert_id;
    $user_email_query = "SELECT email FROM users WHERE user_id = ?";
    $user_email_stmt = $conn->prepare($user_email_query);
    $user_email_stmt->bind_param("i", $user_id);
    $user_email_stmt->execute();
    $user_email_result = $user_email_stmt->get_result();
    $user_email = $user_email_result->fetch_assoc()['email'];

    // Fetch flight details
    $package_details_query = "SELECT name,destinations,duration,itinerary  FROM packages WHERE id = ?";
    $package_details_stmt = $conn->prepare($package_details_query);
    $package_details_stmt->bind_param("i", $package_id);
    $package_details_stmt->execute();
    $package_details_result = $package_details_stmt->get_result();
    $package_details = $package_details_result->fetch_assoc();

    // Send confirmation email
    $subject = "Package Booking Confirmation - IncredibleIndia Tours";
    $body = "
                    <h3>Dear User,</h3>
                    <p>Your package booking is confirmed.</p>
                    <p><strong>Package Details:</strong></p>
                    <p>Package Name: {$package_details['name']}</p>
                    <p>Number of people: {$num_people}</p>
                    <p>Destination: {$package_details['destinations']}</p>
                    <p>Duration: {$package_details['duration']}</p>
                    <p>Itineray: {$package_details['itinerary']}</p>
                    <p>Travel Dates: {$travel_dates}</p>
                    <p>Total Price: {$total_price}</p>
                    <p>Booking Date: " . date("Y-m-d H:i:s") . "</p>
                    <p>Thank you for choosing IncredibleIndia Tours.</p>
                ";

    // Send the email
    if (sendBookingEmail($user_email, $subject, $body)) {
        echo "Booking successful! A confirmation email has been sent.";
    } else {
        echo "Booking successful, but email not sent.";
    }
    header("Location: package_confirm.php?booking_id=" . $booking_id);
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
