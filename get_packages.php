
<?php
include 'setup_database.php';
$servername = "localhost";
$username = "root"; // Change as necessary
$password = ""; // Change as necessary
$db = "travel";
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if (isset($_GET['state']) && isset($_GET['city'])) {
    $state = $_GET['state'];
    $city = $_GET['city'];

    // SQL query to get packages
    $sql = "SELECT DISTINCT p.id, p.name, p.price, p.description, p.images
        FROM packages p
        JOIN state s ON p.state_id = s.state_id
        JOIN city c ON p.city_id = c.city_id
        WHERE p.state_id = ? AND p.city_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $state, $city);
    $stmt->execute();
    $result = $stmt->get_result();
    echo '<div class="row">';
    while ($package = $result->fetch_assoc()) {

        echo '<div class="col-md-4 mb-4">
         <div class="card">
          <img class="card-img-top" src="' . htmlspecialchars(explode(',', $package['images'])[0]) . '" alt="Package Image" height="160">
           <div class="card-body">
           <h5 class="card-title">' . htmlspecialchars($package['name']) . '</h5>
            <p class="card-text">Price: ₹' . htmlspecialchars($package['price']) . '</p>
          <a href="package_detail.php?id=' . htmlspecialchars($package['id']) . '" class="btn btn-primary">View Details</a>
            </div>
           </div>
            </div>';
    }

    $stmt->close();
} else {
    echo "<p>State or city not provided.</p>";
}

$conn->close();
?>
