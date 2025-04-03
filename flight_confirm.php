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


// if ($id <= 0) {
//     die("Invalid booking ID.".htmlspecialchars($_GET['id']));
// }
// Fetch flight booking details
$sql = "SELECT b.*, f.origin, f.destination, f.departure_time, f.arrival_time, f.class, f.price, b.contact_info
        FROM flight_bookings b
        JOIN flights f ON b.flight_id = f.id
        WHERE b.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows>0){
$booking = $result->fetch_assoc();
}
else{
    echo "Booking not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Confirmation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            font-family: 'Arial', sans-serif;
        }
        .confirmation-card {
            max-width: 500px;
            margin: auto;
            margin-top: 50px;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background: white;
            animation: fadeIn 1s ease-in-out;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="confirmation-card text-center">
            <h3 class="text-success"><i class="fas fa-plane-departure"></i> Flight Booking Confirmed!</h3>
            <p class="text-muted">Thank you for booking with us. Here are your details:</p>

            <p><strong><i class="fas fa-map-marker-alt"></i> Flight:</strong> 
                <?php echo htmlspecialchars($booking['origin']) . " → " . htmlspecialchars($booking['destination']); ?>
            </p>

            <p><strong><i class="far fa-clock"></i> Departure:</strong> 
                <?php echo htmlspecialchars(date("d M Y, h:i A", strtotime($booking['departure_time']))); ?>
            </p>

            <p><strong><i class="fas fa-clock"></i> Arrival:</strong> 
                <?php echo htmlspecialchars(date("d M Y, h:i A", strtotime($booking['arrival_time']))); ?>
            </p>

            <p><strong><i class="fas fa-chair"></i> Class:</strong> 
                <?php echo htmlspecialchars($booking['class']); ?>
            </p>

            <p><strong><i class="fas fa-user-friends"></i> Passengers:</strong> 
                <?php echo htmlspecialchars($booking['passengers']); ?>
            </p>

            <p><strong><i class="fas fa-phone"></i> Contact:</strong> 
                <?php echo htmlspecialchars($booking['contact_info']); ?>
            </p>

            <p><strong><i class="fas fa-money-bill-wave"></i> Total Price:</strong> ₹
                <?php echo htmlspecialchars($booking['total_price']); ?>
            </p>

            <a href="flight_payment.php?id=<?php echo htmlspecialchars($booking['id']); ?>" class="btn-custom">
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

