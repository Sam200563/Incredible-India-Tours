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
$flight_id = $_POST['id'];
$passengers = $_POST['passengers'];
$contact_info = $_POST['contact_info'];
$total_price = $_POST['total_price'];

if ($flight_id <= 0 || $passengers <= 0 || $total_price <= 0) {
    die("Invalid booking details.");
}

// Check seat availability
$availability_query = "SELECT seats_available FROM flights WHERE id = ?";
$availability_stmt = $conn->prepare($availability_query);
$availability_stmt->bind_param("i", $flight_id);
$availability_stmt->execute();
$availability_result = $availability_stmt->get_result();

if ($availability_result->num_rows > 0) {
    $flight = $availability_result->fetch_assoc();
    $available_seats = $flight['seats_available'];

    if ($available_seats >= $passengers) {
        // Enough seats available, proceed with booking
        $new_seat_count = $available_seats - $passengers;

        // Update available seats
        $update_seats_query = "UPDATE flights SET seats_available = ? WHERE id = ?";
        $update_seats_stmt = $conn->prepare($update_seats_query);
        $update_seats_stmt->bind_param("ii", $new_seat_count, $flight_id);

        if ($update_seats_stmt->execute()) {
            // Insert flight booking into the database
            $booking_query = "INSERT INTO flight_bookings (user_id, flight_id, booking_date, passengers, total_price, contact_info) 
                              VALUES (?, ?, NOW(), ?, ?, ?)";
            $booking_stmt = $conn->prepare($booking_query);
            $booking_stmt->bind_param("iiids", $user_id, $flight_id, $passengers, $total_price, $contact_info);
            

            if ($booking_stmt->execute()) {
                $booking_id = $conn->insert_id;
                $user_email_query = "SELECT email FROM users WHERE user_id = ?";
                $user_email_stmt = $conn->prepare($user_email_query);
                $user_email_stmt->bind_param("i", $user_id);
                $user_email_stmt->execute();
                $user_email_result = $user_email_stmt->get_result();
                $user_email = $user_email_result->fetch_assoc()['email'];

                // Fetch flight details
                $flight_details_query = "SELECT origin, destination, price,class FROM flights WHERE id = ?";
                $flight_details_stmt = $conn->prepare($flight_details_query);
                $flight_details_stmt->bind_param("i", $flight_id);
                $flight_details_stmt->execute();
                $flight_details_result = $flight_details_stmt->get_result();
                $flight_details = $flight_details_result->fetch_assoc();

                // Send confirmation email
                $subject = "Flight Booking Confirmation - IncredibleIndia Tours";
                $body = "
                    <h3>Dear User,</h3>
                    <p>Your flight booking is confirmed.</p>
                    <p><strong>Flight Details:</strong></p>
                    <p>Departure: {$flight_details['origin']}</p>
                    <p>Arrival: {$flight_details['destination']}</p>
                    <p>Flight Class: {$flight_details['class']}</p>
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

                // Redirect to booking confirmation page
                header("Location: flight_confirm.php?id=" .  $booking_id);
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
        // Not enough seats available
        echo "Sorry, only $available_seats seat(s) are available for this flight.";
    }
} else {
    echo "Flight not found.";
}

// Close connections
$availability_stmt->close();
$conn->close();
?>
