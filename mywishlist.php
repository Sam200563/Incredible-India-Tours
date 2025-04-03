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

// Check the selected wishlist type (Package, Flight, Hotel)
$selected_type = isset($_GET['item_type']) ? $_GET['item_type'] : 'Package';

// Initial SQL Query (start with packages)
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
        SELECT b.booking_id,h.id AS id, h.name AS hotel_name, h.price_range AS price, b.booking_date
        FROM hotel_bookings b
        JOIN hotels h ON b.hotel_id = h.id
        WHERE b.user_id = ?
    ";
} elseif ($selected_type == 'Train') {
    $sql = "
        SELECT b.id,t.train_id AS train_id, t.train_name AS name, t.price AS price , b.booking_date
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
    <title>My Wishlist</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>My Wishlist</h2>
        <div class="mb-3">
            <a href="mywishlist.php?item_type=Package" class="btn btn-primary">Package Wishlist</a>
            <a href="mywishlist.php?item_type=Flight" class="btn btn-primary">Flight Wishlist</a>
            <a href="mywishlist.php?item_type=Hotel" class="btn btn-primary">Hotel Wishlist</a>
            <a href="mywishlist.php?item_type=Train" class="btn btn-primary">Train Wishlist</a>

        </div>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item Type</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Booking Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($selected_type); ?></td>
                            <td><?php echo htmlspecialchars($item['package_name'] ?? $item['flight_name'] ?? $item['hotel_name'] ?? $item['name']); ?></td>
                            <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                            <td><?php echo htmlspecialchars($item['booking_date']); ?></td>
                            <td>
                                <a href=" <?php
                                                if ($selected_type === 'Package') {
                                                    echo 'package_detail.php?id=' . $item['id'];
                                                } elseif ($selected_type === 'Flight') {
                                                    echo 'flight_detail.php?id=' . $item['id'];
                                                } elseif ($selected_type === 'Hotel') {
                                                    echo 'hotel_details.php?id=' . $item['id'];
                                                } elseif ($selected_type === 'Train') {
                                                    echo 'train_detail.php?id=' . $item['train_id'];
                                                }
                                                ?>"
                                    class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-warning">You have no items saved in this category yet.</p>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>