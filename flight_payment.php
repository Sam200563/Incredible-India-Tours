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

$flight_id = $_GET['id'] ; 
$user_id=$_SESSION['user_id'];
// Retrieve booking details
$sql = "SELECT b.*, f.origin, f.destination, f.departure_time, f.arrival_time, f.class, f.price, b.contact_info
        FROM flight_bookings b
        JOIN flights f ON b.flight_id = f.id
        WHERE b.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $flight_id);
$stmt->execute();
$flight = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .payment-card {
            max-width: 450px;
            margin: auto;
            margin-top: 50px;
            padding: 25px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
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
        <div class="payment-card text-center">
            <h3 class="text-primary"><i class="fas fa-plane"></i> Payment for Flight Booking</h3>
            <p class="text-muted">Secure your flight now by proceeding with the payment.</p>

            <p><strong><i class="fas fa-map-marker-alt"></i> Flight Route:</strong> 
                <?php echo htmlspecialchars($flight['origin']) . " → " . htmlspecialchars($flight['destination']); ?>
            </p>

            <p><strong><i class="fas fa-money-bill-wave"></i> Total Amount:</strong> ₹
                <?php echo htmlspecialchars($flight['total_price']); ?>
            </p>

            <form action="process_payment.php" method="POST">
                <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($flight_id); ?>">
                <input type="hidden" name="type" value="flight">
                <button type="submit" class="btn-custom">
                    <i class="fas fa-credit-card"></i> Pay Now
                </button>
            </form>
        </div>
    </div>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?> 
