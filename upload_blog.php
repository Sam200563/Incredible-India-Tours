<?php
session_start(); // Start the session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verify if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to create a blog.'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image = "";

    // Handle file upload if an image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $imageName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $imageName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Validate file type
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $image = $targetFilePath;
            } else {
                echo "Error uploading the image file.";
            }
        } else {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }

    // Insert blog into the database
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO blogs (user_id, title, content, image, blog_created_at) VALUES ('$user_id', '$title', '$content', '$image', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Blog uploaded successfully!'); window.location.href = 'blog.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
