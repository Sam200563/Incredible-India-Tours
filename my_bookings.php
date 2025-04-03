<?php
session_start();
include 'setup_database.php'; // Database connection
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
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Check the selected booking type (Package, Flight, Hotel)
$selected_type = isset($_GET['booking_type']) ? $_GET['booking_type'] : 'Package';

// Initial SQL Query (start with packages first)
$sql = "
    SELECT b.booking_id, p.name AS package_name, p.price, b.booking_date
    FROM package_bookings b
    JOIN packages p ON b.package_id = p.id
    WHERE b.user_id = ?
";

// Adjust query based on the booking type (Flight or Hotel)
if ($selected_type == 'Flight') {
    $sql = "
        SELECT b.id, CONCAT(f.origin, ' to ', f.destination) AS flight_name, f.price, b.booking_date
        FROM flight_bookings b
        JOIN flights f ON b.flight_id = f.id
        WHERE b.user_id = ?
    ";
} elseif ($selected_type == 'Hotel') {
    $sql = "
        SELECT b.booking_id, h.name AS hotel_name, h.price_range AS price, b.booking_date
        FROM hotel_bookings b
        JOIN hotels h ON b.hotel_id = h.id
        WHERE b.user_id = ?
    ";
} elseif ($selected_type == 'Train') {
    $sql = "
        SELECT b.id, t.train_name AS name, t.price AS price , b.booking_date
     FROM train_bookings b
    JOIN trains t ON b.train_id = t.train_id
    WHERE b.user_id = ?
    ";
}

// Prepare and execute the SQL query
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>My Bookings</h2>
        <div class="mb-3">
            <a href="my_bookings.php?booking_type=Package" class="btn btn-primary">Package Bookings</a>
            <a href="my_bookings.php?booking_type=Flight" class="btn btn-primary">Flight Bookings</a>
            <a href="my_bookings.php?booking_type=Hotel" class="btn btn-primary">Hotel Bookings</a>
            <a href="my_bookings.php?booking_type=Train" class="btn btn-primary">Train Bookings</a>
        </div>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Booking Type</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($booking = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($selected_type); ?></td>
                            <td><?php echo htmlspecialchars($booking['package_name'] ?? $booking['flight_name'] ?? $booking['hotel_name']?? $booking['name']); ?></td>
                            <td>₹<?php echo htmlspecialchars($booking['price']); ?></td>
                            <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                            <td>
                                <a href="cancel_booking.php?type=<?php echo urlencode($selected_type); ?>&booking_id=<?php echo urlencode($booking['booking_id'] ?? $booking['id']); ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to cancel this booking?');">
                                    Cancel
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-warning">You have no bookings for this category yet.</p>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>