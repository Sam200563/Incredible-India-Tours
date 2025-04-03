<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $current_url = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    header("Location: login.php?redirect=$current_url");
    exit;
}
include 'setup_database.php';
$train_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($train_id <= 0) {
    die("Invalid train ID.");
}

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM trains WHERE train_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $train_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $train = $result->fetch_assoc();
} else {
    die("Train not found.");
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Train</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Book Your Train</h1>
        <div class="card">
            <div class="card-body">
            <h2 class="card-title"><?php echo htmlspecialchars($train['train_name']); ?></h2>
            <h4 class="card-text"><?php echo htmlspecialchars($train['source']) . " → " . htmlspecialchars($train['destination']); ?></h4>                
            <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($train['price']); ?></p>
                <p><strong>Departure Time:</strong> <?php echo htmlspecialchars(date("h:i A", strtotime($train['departure_time']))); ?></p>
                <p><strong>Arrival Time:</strong> <?php echo htmlspecialchars(date(" h:i A", strtotime($train['arrival_time']))); ?></p>
                <form action="train_process.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($train['train_id']); ?>">
                    <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($train['price']); ?>">
                    <div class="mb-3">
                        <label for="passengers" class="form-label">Number of Passengers</label>
                        <input type="number" name="passengers" id="passengers" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_info">Contact Information:</label>
                        <input type="text" name="contact_info" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-5">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>