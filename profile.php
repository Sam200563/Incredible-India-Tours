<?php
session_start();
include 'setup_database.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "travel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username, email, phone,dob,address,emergency_contact, profile_picture, offcanvas_color FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_picture'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png'];

    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["profile_pictre"]["tmp_name"], $target_file)) {
            $update_pic = "UPDATE users SET profile_picture = ? WHERE user_id = ?";
            $stmt = $conn->prepare($update_pic);
            $stmt->bind_param("si", $target_file, $user_id);
            $stmt->execute();
            header("Location: profile.php?success=1");
            exit;
        }
    } else {
        $error = "Invalid file type! Only JPG, JPEG, and PNG are allowed.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_phone = $_POST['phone'];
    $new_emergency_phone = $_POST['emergency_contact'];
    $new_dob = $_POST['dob'];
    $new_address = $_POST['address'];

    $update_sql = "UPDATE users SET username = ?, email = ?, phone = ?,emergency_contact=? ,dob=?, address=? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $new_username, $new_email, $new_phone,$new_emergency_phone,$new_dob,$new_address, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['username'] = $new_username;
        $_SESSION['email'] = $new_email;
        header("Location: profile.php?success=1");
        exit;
    } else {
        $error = "Failed to update profile!";
    }
}

// Handle offcanvas color change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['offcanvas_color'])) {
    $new_color = $_POST['offcanvas_color'];

    $update_color = "UPDATE users SET offcanvas_color = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_color);
    $stmt->bind_param("si", $new_color, $user_id);
    $stmt->execute();
    header("Location: profile.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <div class="d-flex align-items-center">
            <div class="profile-icon bg-dark text-white rounded-circle overflow-hidden">
                <img src="<?php echo $user['profile_picture'] ? $user['profile_picture'] : 'default.png'; ?>" 
                     class="img-fluid" alt="Profile Picture">
            </div>
            <div class="ms-3">
                <h4 class="mb-0"><?php echo htmlspecialchars($user['username']); ?></h4>
                <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>

        <hr>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Profile updated successfully!</div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Upload Profile Picture -->
        <form method="post" enctype="multipart/form-data">
            <label>Change Profile Picture:</label>
            <input type="file" name="profile_picture" class="form-control">
            <button type="submit" class="btn btn-primary mt-3">Upload</button>
        </form>

        <hr>

        <!-- Update Profile Details -->
        <form method="post">
            <input type="hidden" name="update_profile" value="1">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Phone Number:</label>
                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
            </div>
            <div class="form-group">
                <label>Emergency Phone Number:</label>
                <input type="text" name="emergencyphone" class="form-control" value="<?php echo htmlspecialchars($user['emergency_contact']); ?>">
            </div>
            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($user['dob']); ?>">
            </div>
            <div class="form-group">
                <label>Address:</label>
                <input type="textarea" name="address" class="form-control" value="<?php echo htmlspecialchars($user['address']); ?>">
            </div>
            <button type="submit" class="btn btn-success mt-3">Save Changes</button>
        </form>

        <hr>

        <!-- Change Offcanvas Color -->
        <form method="post">
            <label>Select Offcanvas Background Color:</label>
            <input type="color" name="offcanvas_color" class="form-control" value="<?php echo htmlspecialchars($user['offcanvas_color'] ?? '#ffffff'); ?>">
            <button type="submit" class="btn btn-secondary mt-3">Save Color</button>
        </form>
    </div>
</div>

<style>
    .profile-icon {
        width: 70px;
        height: 70px;
        font-size: 24px;
        font-weight: bold;
    }
    .profile-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

</body>
</html>
