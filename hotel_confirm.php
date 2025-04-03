<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'setup_database.php';

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get booking ID from the query string
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($booking_id <= 0) {
    die("Invalid booking ID: " . htmlspecialchars($_GET['id']));
}

// Fetch booking details
$sql = "
    SELECT 
        hb.booking_id AS booking_id,
        h.name AS hotel_name,
        hr.room_type AS room_type,
        hb.check_in_date,
        hb.check_out_date,
        hb.guests,
        hb.contact_info,
        hb.booking_date
    FROM 
        hotel_bookings hb
    JOIN 
        hotels h ON hb.hotel_id = h.id
    JOIN 
        hotel_rooms hr ON hb.room_type = hr.room_type
    WHERE 
        hb.booking_id = ? AND hb.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    echo "contact number". htmlspecialchars($booking['contact_info']);
} else {
    die("Booking not found or access denied.");
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background-color: #f8f9fa;
        }
        .confirmation-card {
            max-width: 600px;
            margin: 50px auto;
            padding: 25px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
        }
        .icon {
            color: #28a745;
            margin-right: 10px;
        }
        .btn-custom {
            background-color: #28a745;
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
            background-color: #218838;
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
        <div class="card confirmation-card">
            <div class="card-header text-center bg-success text-white">
                <h3><i class="fas fa-check-circle"></i> Booking Confirmed</h3>
            </div>
            <div class="card-body">
                <h5 class="card-title text-center">Thank you for booking with us! 🎉</h5>
                <hr>
                <p class="card-text"><i class="fas fa-hashtag icon"></i><strong>Booking ID:</strong> <?= htmlspecialchars($booking['booking_id']); ?></p>
                <p class="card-text"><i class="fas fa-hotel icon"></i><strong>Hotel Name:</strong> <?= htmlspecialchars($booking['hotel_name']); ?></p>
                <p class="card-text"><i class="fas fa-bed icon"></i><strong>Room Type:</strong> <?= htmlspecialchars($booking['room_type']); ?></p>
                <p class="card-text"><i class="fas fa-calendar-check icon"></i><strong>Check-in:</strong> <?= htmlspecialchars($booking['check_in_date']); ?></p>
                <p class="card-text"><i class="fas fa-calendar-times icon"></i><strong>Check-out:</strong> <?= htmlspecialchars($booking['check_out_date']); ?></p>
                <p class="card-text"><i class="fas fa-users icon"></i><strong>Guests:</strong> <?= htmlspecialchars($booking['guests']); ?></p>
                <p class="card-text"><i class="fas fa-phone icon"></i><strong>Contact:</strong> <?= htmlspecialchars($booking['contact_info']); ?></p>
                <p class="card-text"><i class="fas fa-calendar-alt icon"></i><strong>Booking Date:</strong> <?= htmlspecialchars($booking['booking_date']); ?></p>
            </div>
            <div class="card-footer text-center">
                <a href="hotel_payment.php?id=<?= htmlspecialchars($booking['booking_id']); ?>" class="btn-custom">
                    <i class="fas fa-credit-card"></i> Proceed to Payment
                </a>
            </div>
        </div>
    </div>


</body>

</html>
