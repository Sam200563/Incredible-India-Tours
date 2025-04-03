<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // User is not logged in
    echo "<script>
        alert('Login is required to book a package.');
        window.location.href = 'login.html'; // Redirect to login page
    </script>";
    exit;
}
include 'setup_database.php';
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
$booking_id = $_GET['booking_id'];
$sql = "SELECT b.*, p.name AS package_name, p.price
        FROM package_bookings b
        JOIN packages p ON b.package_id = p.id
        WHERE b.booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$total_price=$booking['price'] * $booking['num_people'];
if (!$booking) {
    echo "Booking not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .confirmation-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .details p {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .icon {
            font-size: 18px;
            margin-right: 5px;
            color: #28a745;
        }
    </style>
</head>
<body>

<div class="confirmation-container">
    <h2 class="text-center text-success">🎉 Booking Confirmed!</h2>
    <p class="text-center text-muted">Thank you for booking with us! Here are your booking details:</p>
    
    <div class="details">
        <p><i class="icon">🏝️</i> <strong>Package:</strong> <?php echo htmlspecialchars($booking['package_name']); ?></p>
        <p><i class="icon">📅</i> <strong>Travel Dates:</strong> <?php echo htmlspecialchars($booking['travel_dates']); ?></p>
        <p><i class="icon">👥</i> <strong>Number of People:</strong> <?php echo htmlspecialchars($booking['num_people']); ?></p>
        <p><i class="icon">📞</i> <strong>Contact Info:</strong> <?php echo htmlspecialchars($booking['contact_info']); ?></p>
        <p><i class="icon">💰</i> <strong>Total Price:</strong> ₹<?php echo htmlspecialchars($total_price); ?></p>
    </div>

    <div class="text-center">
        <a href="package_payment.php?booking_id=<?php echo htmlspecialchars($booking['booking_id']); ?>" class="btn-custom">💳 Proceed to Payment</a>
    </div>
    
    <p class="text-center text-muted mt-3"><em>You will receive an email confirmation soon.</em></p>
</div>

</body>
</html>


<?php
$stmt->close();
$conn->close();
?>
