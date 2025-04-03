<?php
session_start();
include 'setup_database.php';
$servername = "localhost";
$username = "root";
$password = "";
$db = "travel";

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id=$_SESSION['user_id'];
$booking_id = $_GET['booking_id'] ; // Assume you pass the booking ID from the URL

// Retrieve booking details
$sql = "SELECT * FROM package_bookings WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
$total_price=$booking['total_price'] * $booking['num_people'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment for Package Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .payment-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            display: inline-block;
            width: 100%;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .details p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .icon {
            font-size: 20px;
            margin-right: 5px;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="payment-container">
    <h2 class="text-primary">💳 Payment for Package Booking</h2>
    <p class="text-muted">Please confirm your payment details below:</p>
    
    <div class="details">
        <p><i class="icon">🏝️</i> <strong>Package:</strong> <?php echo htmlspecialchars($booking['package_name']); ?></p>
        <p><i class="icon">💰</i> <strong>Total Amount:</strong> ₹<?php echo htmlspecialchars($total_price); ?></p>
    </div>

    <form action="process_payment.php" method="POST">
        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
        <input type="hidden" name="type" value="package">
        <button type="submit" class="btn-custom">🚀 Pay Now</button>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?> 
