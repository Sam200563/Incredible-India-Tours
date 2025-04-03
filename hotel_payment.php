<?php
session_start();
include 'setup_database.php';

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$db = "travel";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get hotel booking ID from the URL
$booking_id = $_GET['id']; 
$user_id = $_SESSION['user_id'];

// Retrieve booking details
$sql = "SELECT b.*, h.name as hotel_name,h.location,  h.price_range, b.check_in_date, b.check_out_date, b.guests, b.contact_info
        FROM hotel_bookings b
        JOIN hotels h ON b.hotel_id = h.id
        WHERE b.booking_id = ? AND b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
// Calculate total price
$check_in_date = strtotime($booking['check_in_date']);
$check_out_date = strtotime($booking['check_out_date']);
$price_per_night = $booking['price_range'];
$guests = $booking['guests'];

// Calculate number of nights
$nights = ($check_out_date - $check_in_date) / (60 * 60 * 24);

// Total price
$total_price = $nights * $price_per_night * $guests;


$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Payment</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background-color: #f8f9fa;
        }
        .payment-card {
            max-width: 600px;
            margin: 50px auto;
            padding: 25px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
        }
        .icon {
            color: #007bff;
            margin-right: 10px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            padding: 12px 18px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
            width: 100%;
            text-align: center;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card payment-card">
            <div class="card-header text-center bg-primary text-white">
                <h3><i class="fas fa-credit-card"></i> Hotel Payment</h3>
            </div>
            <div class="card-body">
                <h5 class="card-title text-center">Confirm Your Payment 💳</h5>
                <hr>
                <p class="card-text"><i class="fas fa-hotel icon"></i><strong>Hotel:</strong> <?= htmlspecialchars($booking['hotel_name']); ?></p>
                <p class="card-text"><i class="fas fa-map-marker-alt icon"></i><strong>Location:</strong> <?= htmlspecialchars($booking['location']); ?></p>
                <p class="card-text"><i class="fas fa-bed icon"></i><strong>Room Type:</strong> <?= htmlspecialchars($booking['room_type']); ?></p>
                <p class="card-text"><i class="fas fa-calendar-check icon"></i><strong>Check-in:</strong> <?= htmlspecialchars($booking['check_in_date']); ?></p>
                <p class="card-text"><i class="fas fa-calendar-times icon"></i><strong>Check-out:</strong> <?= htmlspecialchars($booking['check_out_date']); ?></p>
                <p class="card-text"><i class="fas fa-users icon"></i><strong>Guests:</strong> <?= htmlspecialchars($booking['guests']); ?></p>
                <p class="card-text"><i class="fas fa-money-bill-wave icon"></i><strong>Total Price:</strong> ₹<?= number_format($total_price, 2); ?></p>
            </div>
            <div class="card-footer text-center">
                <form action="process_payment.php" method="POST">
                    <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking_id); ?>">
                    <input type="hidden" name="type" value="hotel">
                    <input type="hidden" name="total_price" value="<?= htmlspecialchars($total_price); ?>">
                    <button type="submit" class="btn-custom">
                        <i class="fas fa-lock"></i> Pay Now
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
