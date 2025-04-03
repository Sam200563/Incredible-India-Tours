<?php
session_start();
include 'setup_database.php';
$servername = "localhost";
$username = "root"; 
$password = ""; 
$db = "travel";
$conn = new mysqli($servername, $username, $password, $db);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to cancel a booking.";
    exit;
}

if (isset($_GET['type']) && isset($_GET['booking_id'])) {
    $type = strtolower($_GET['type']); // Type of booking (package, flight, train, hotel)
    $booking_id = $_GET['booking_id'];
    $user_id = $_SESSION['user_id'];

    $user_query = $conn->prepare("SELECT email FROM users WHERE user_id = ?");
    $user_query->bind_param("i", $user_id);
    $user_query->execute();
    $user_result = $user_query->get_result();
    $user = $user_result->fetch_assoc();
    $user_email = $user['email'];

    if ($type == "package") {
        $sql = "UPDATE package_bookings SET status = 'cancelled' WHERE booking_id = ? AND user_id = ?";
        $item_query = "SELECT name FROM packages WHERE id = (SELECT package_id FROM package_bookings WHERE booking_id = ?)";
    } elseif ($type == "flight") {
        $item_query = "SELECT CONCAT(origin, ' to ', destination) AS name FROM flights WHERE id = (SELECT flight_id FROM flight_bookings WHERE id = ?)";
        $sql = "UPDATE flight_bookings SET status = 'cancelled' WHERE id = ? AND user_id = ?";
        $sql_del="DELETE FROM flight_bookings WHERE id = ? AND user_id = ?";
        $update_seats = "UPDATE flights SET seats_available = seats_available + 1 WHERE id = (SELECT flight_id FROM flight_bookings WHERE id = ?)";
    } elseif ($type == "train") {
        $sql = "UPDATE train_bookings SET status = 'cancelled' WHERE train_id = ? AND user_id = ?";
        $item_query = "SELECT train_name AS name FROM trains WHERE train_id = (SELECT train_id FROM train_bookings WHERE id = ?)";
        $update_seats_train="UPDATE trains SET seats_available = seats_available + 1 WHERE train_id = (SELECT train_id FROM train_bookings WHERE id = ?)";

    } elseif ($type == "hotel") {
        $sql = "UPDATE hotel_bookings SET status = 'cancelled' WHERE booking_id = ? AND user_id = ?";
        $item_query = "SELECT name FROM hotels WHERE id = (SELECT hotel_id FROM hotel_bookings WHERE booking_id = ?)";
    } else {
        echo "Invalid booking type.";
        exit;
    }

    $stmt_item = $conn->prepare($item_query);
    $stmt_item->bind_param("i", $booking_id);
    $stmt_item->execute();
    $result_item = $stmt_item->get_result();
    $item = $result_item->fetch_assoc();
    $item_name = $item['name'];


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $booking_id, $user_id);

    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param("ii", $booking_id, $user_id);
    $stmt_del->execute();

    if ($stmt->execute()) {
        if ($type == "flight") {
            // Update seats available for flights
            $stmt_seats = $conn->prepare($update_seats);
            $stmt_seats->bind_param("i", $booking_id);
            $stmt_seats->execute();
        }else if($type=="train"){
            $stmt_seats1 = $conn->prepare($update_seats_train);
            $stmt_seats1->bind_param("i", $booking_id);
            $stmt_seats1->execute();

        }
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'theampadag@gmail.com'; // Change to your email
            $mail->Password = 'yomm jdbn bski xjje'; // Change to your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('thesampadag@gmail.com', 'IncredibleIndia Tours');
            $mail->addAddress($user_email);

            $mail->isHTML(true);
            $mail->Subject = "Booking Cancellation Confirmation";
            $mail->Body = "<p>Dear User,</p>
                        <p>Your booking for <b>$item_name</b> has been successfully cancelled.</p>
                        <p>Thank you for using IncredibleIndia Tours.</p>";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email not sent. Error: " . $mail->ErrorInfo);
        }


        // echo "Booking cancelled successfully.";
        echo "<script> alert('Booking cancelled successfully');
        window.location.href='my_bookings.php?booking_type=$type';</script>";
    } else {
        echo "<script> alert('Cancellation Failed');
        window.location.href='my_bookings.php?booking_type=$type';</script>";
    }
} else {
    echo "<script> alert('Missing Parameters');
    window.location.href='my_bookings.php';</script>";
}
?>
