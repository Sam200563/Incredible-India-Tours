<?php
session_start();
include 'setup_database.php';
$servername = "localhost";
$username = "root"; // Change as necessary
$password = ""; // Change as necessary
$db = "travel";

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get booking ID from the query string
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid booking ID. Value received: " . ($_GET['id'] ?? 'None'));
}
error_log("Checking train ID: " . $id);

// Fetch flight booking details
$sql = "SELECT b.*, f.source, f.destination, f.departure_time, f.arrival_time, f.price, b.contact_info
        FROM train_bookings b
        JOIN trains f ON b.train_id = f.train_id
        WHERE b.train_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    echo "Booking not found.";
    error_log("Booking not found for Train ID: " . $id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Booking Confirmation</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        .confirmation-card {
            max-width: 550px;
            margin: auto;
            margin-top: 50px;
            padding: 25px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
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
        <div class="confirmation-card text-center">
            <h3 class="text-success"><i class="fas fa-train"></i> Train Booking Confirmation</h3>
            <p class="text-muted">Thank you for booking with us! Here are your booking details:</p>

            <p><strong><i class="fas fa-map-marker-alt"></i> Train Route:</strong> 
                <?php echo htmlspecialchars($booking['source']) . " → " . htmlspecialchars($booking['destination']); ?>
            </p>

            <p><strong><i class="far fa-clock"></i> Departure Time:</strong> 
                <?php echo htmlspecialchars(date("h:i A", strtotime($booking['departure_time']))); ?>
            </p>

            <p><strong><i class="far fa-clock"></i> Arrival Time:</strong> 
                <?php echo htmlspecialchars(date("h:i A", strtotime($booking['arrival_time']))); ?>
            </p>

            <p><strong><i class="fas fa-user-friends"></i> Passengers:</strong> 
                <?php echo htmlspecialchars($booking['passengers']); ?>
            </p>

            <p><strong><i class="fas fa-phone"></i> Contact Number:</strong> 
                <?php echo htmlspecialchars($booking['contact_info']); ?>
            </p>

            <p><strong><i class="fas fa-money-bill-wave"></i> Total Price:</strong> ₹
                <?php echo htmlspecialchars($booking['total_price']); ?>
            </p>

            <a href="train_payment.php?id=<?php echo htmlspecialchars($booking['train_id']); ?>" class="btn-custom">
                <i class="fas fa-credit-card"></i> Proceed to Payment
            </a>
        </div>
    </div>

</body>
</html>


<?php
$stmt->close();
$conn->close();
?>

