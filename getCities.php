<?php
include 'setup_database.php'; // Ensure you include your database connection

if (isset($_GET['state_id'])) {
    echo "State ID received: " . $_GET['state_id'];
} else {
    echo "No State ID received.";
}
$conn = new mysqli($servername, $username, $password, $db);

if (isset($_GET['state_id'])) {
    $state_id = $_GET['state_id'];
    
    $query = "SELECT city_id,city_name FROM city WHERE state_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $state_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        echo '<option value="">Select City</option>'; // Default option
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . htmlspecialchars($row['city_id']) . '">' . htmlspecialchars($row['city_name']) . '</option>';
        }
    } else {
        echo '<option value="">No cities available</option>';
    }

    mysqli_stmt_close($stmt);
} else {
    echo '<option value="">No cities available</option>'; // Default option if no state_id is set
}

mysqli_close($conn);
?>
