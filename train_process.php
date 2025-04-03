<?php
session_start();
include 'setup_database.php';
include 'send_email.php'; 
$servername = "localhost";
$username = "root"; 
$password = ""; 
$db = "travel";

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID dynamically from session
$user_id = $_SESSION['user_id'];
$train_id = $_POST['id'];
$passengers = $_POST['passengers'];
$contact_info = $_POST['contact_info'];
$total_price = $_POST['total_price'];

if ($train_id <= 0 || $passengers <= 0 || $total_price <= 0) {
    die("Invalid booking details.");
}

// Check seat availability
$availability_query = "SELECT seats_available FROM trains WHERE train_id = ?";
$availability_stmt = $conn->prepare($availability_query);
$availability_stmt->bind_param("i", $train_id);
$availability_stmt->execute();
$availability_result = $availability_stmt->get_result();

if ($availability_result->num_rows > 0) {
    $train = $availability_result->fetch_assoc();
    $available_seats = $train['seats_available'];

    if ($available_seats >= $passengers) {
        // Enough seats available, proceed with booking
        $new_seat_count = $available_seats - $passengers;

        // Update available seats
        $update_seats_query = "UPDATE trains SET seats_available = ? WHERE train_id = ?";
        $update_seats_stmt = $conn->prepare($update_seats_query);
        $update_seats_stmt->bind_param("ii", $new_seat_count, $train_id);

        if ($update_seats_stmt->execute()) {
            // Insert flight booking into the database
            $booking_query = "INSERT INTO train_bookings (user_id, train_id, booking_date, passengers, total_price, contact_info) 
                              VALUES (?, ?, NOW(), ?, ?, ?)";
            $booking_stmt = $conn->prepare($booking_query);
            $booking_stmt->bind_param("iiids", $user_id, $train_id, $passengers, $total_price, $contact_info);

            if ($booking_stmt->execute()) {
                $booking_id = $conn->insert_id;
                $user_email_query = "SELECT email FROM users WHERE user_id = ?";
                $user_email_stmt = $conn->prepare($user_email_query);
                $user_email_stmt->bind_param("i", $user_id);
                $user_email_stmt->execute();
                $user_email_result = $user_email_stmt->get_result();
                $user_email = $user_email_result->fetch_assoc()['email'];

                // Fetch flight details
                $train_details_query = "SELECT train_name,source,destination,departure_time,arrival_time,price FROM trains WHERE train_id = ?";
                $train_details_stmt = $conn->prepare($train_details_query);
                $train_details_stmt->bind_param("i", $train_id);
                $train_details_stmt->execute();
                $train_details_result = $train_details_stmt->get_result();
                $train_details = $train_details_result->fetch_assoc();

                // Send confirmation email
                $subject = "Train Booking Confirmation - IncredibleIndia Tours";
                $body = "
                    <h3>Dear User,</h3>
                    <p>Your train booking is confirmed.</p>
                    <p><strong>Train Details:</strong></p>
                    <p>Train Name: {$train_details['train_name']}</p>
                    <p>Departure: {$train_details['source']}</p>
                    <p>Arrival: {$train_details['destination']}</p>
                    <p>Destination Time: {$train_details['departure_time']}</p>
                    <p>Arrival Time: {$train_details['arrival_time']}</p>
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
                
                header("Location: train_confirm.php?id=" . $booking_id);
                exit;
            } else {
                echo "Error: " . $booking_stmt->error;
            }

            $booking_stmt->close();
        } else {
            echo "Error updating seat count: " . $update_seats_stmt->error;
        }

        $update_seats_stmt->close();
    } else {
        echo "Sorry, only $available_seats seat(s) are available for this train.";
    }
} else {
    echo "Train not found.";
}

// Close connections
$availability_stmt->close();
$conn->close();
?>
