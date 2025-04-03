<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $current_url = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    header("Location: login.php?redirect=$current_url");
    exit;
}

// Include the database connection
include 'setup_database.php';

// Get the flight ID from the query string
$hotel_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($hotel_id <= 0) {
    die("Invalid hotel ID.");
}

// Connect to the database
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch flight details
$sql = "SELECT * FROM hotels WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $hotel = $result->fetch_assoc();
} else {
    die("hotel not found.");
}
$stmt->close();

$sql = "SELECT id, room_type, price_per_night FROM hotel_rooms WHERE hotel_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$room_result = $stmt->get_result();

$room_types = [];
if ($room_result->num_rows > 0) {
    while ($row = $room_result->fetch_assoc()) {
        $room_types[] = $row;
    }
} else {
    die("No rooms available for this hotel.");
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($hotel['images']); ?>" alt="Hotel Image" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h1 class="mb-4"><?= htmlspecialchars($hotel['name']); ?></h1>
                <p><?= htmlspecialchars($hotel['description']); ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($hotel['location']); ?></p>
                <p><strong>Price per night:</strong> ₹<?= number_format($hotel['price_range'], 2); ?></p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8 offset-md-2">
                <form method="POST" action="hotel_process.php" class="p-4 border rounded">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($hotel['id']); ?>">
                    <input type="hidden" name="price_per_night" value="<?= htmlspecialchars($hotel['price_range']); ?>">

                    <div class="mb-3">
                        <label for="room_type" class="form-label">Room Type:</label>
                        <select id="room_type" name="room_type" class="form-select" required onchange="updateRoomName()">
                            <?php foreach ($room_types as $room): ?>
                                <option value="<?= $room['id']; ?>" data-room-name="<?= htmlspecialchars($room['room_type']) ?>">
                                    <?= htmlspecialchars($room['room_type']) . " (₹" . number_format($room['price_per_night'], 2) . ")"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="room_name" name="room_name">
                    </div>

                    <div class="mb-3">
                        <label for="check_in_date" class="form-label">Check-in Date:</label>
                        <input type="date" id="check_in_date" name="check_in_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="check_out_date" class="form-label">Check-out Date:</label>
                        <input type="date" id="check_out_date" name="check_out_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="guests" class="form-label">Number of Guests:</label>
                        <input type="number" id="guests" name="guests" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="contact_info" class="form-label">Contact Information:</label>
                        <input type="text" id="contact_info" name="contact_info" class="form-control" pattern="\d{10}" maxlength="10" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Book Now</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function updateRoomName() {
        var select = document.getElementById("room_type");
        var selectedOption = select.options[select.selectedIndex];
        document.getElementById("room_name").value = selectedOption.getAttribute("data-room-name");
    }

    // Initialize the hidden field with the first option's value
    document.addEventListener("DOMContentLoaded", function() {
        updateRoomName();
    });
</script>
</body>

</html>