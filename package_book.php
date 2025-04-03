<?php
session_start(); // Start the session to access session variables

if (!isset($_SESSION['user_id'])) {
    // User is not logged in
    $current_url = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    header("Location: login.php?redirect=$current_url");
    exit;
    
}

// Retrieve the package ID from GET or POST
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>Package ID is required to proceed.</p>";
    exit;
}

$package_id = intval($_GET['id']);

// Database connection
include 'setup_database.php';
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch package details
$sql = "SELECT * FROM packages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result = $stmt->get_result();
$package = $result->fetch_assoc();

if (!$package) {
    echo "<p>Package not found.</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Package - <?php echo htmlspecialchars($package['name']); ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Book: <?php echo htmlspecialchars($package['name']); ?></h2>
        <form action="package_process.php" method="post">
            <input type="hidden" name="package_id" value="<?php echo htmlspecialchars($package['id']); ?>">
            <input type="hidden" name="name" value="<?php echo htmlspecialchars($package['name']); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($package['price']); ?>">
            <div class="form-group">
                <label for="travel_dates">Travel Dates:</label>
                <input type="date" name="travel_dates" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="num_people">Number of People:</label>
                <input type="number" name="num_people" class="form-control" min="1" required>
            </div>
            <div class="form-group">
                <label for="contact_info">Contact Information:</label>
                <input type="text" name="contact_info" class="form-control" maxlength="10" pattern="\d{10}" required>
            </div>
            <button type="submit" class="btn btn-success">Confirm Booking</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
