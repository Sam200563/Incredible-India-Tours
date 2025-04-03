<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$db = "travel";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to view your blogs.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch blogs created by the logged-in user
$sql = "SELECT title, content, image, blog_created_at FROM blogs WHERE user_id = ? ORDER BY blog_created_at DESC";
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
    <title>My Blogs</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">My Blogs</h1>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (!empty($row['image'])): ?>
                                <img src="<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="Blog Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text">
                                    <?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 100))); ?>...
                                </p>
                                <p class="text-muted"><small>Created on: <?php echo date("F d, Y H:i", strtotime($row['blog_created_at'])); ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">You have not created any blogs yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
