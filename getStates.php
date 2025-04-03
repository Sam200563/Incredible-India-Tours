<?php
include 'setup_database.php'; // Ensure this file contains a proper DB connection
$conn = new mysqli($servername, $username, $password, $db);
// Perform the query
$query = "SELECT * FROM state";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

// Fetch and output options
while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='{$row['state_id']}'>{$row['state_name']}</option>";
}

// Close the connection after you're done
mysqli_close($conn);
?>

