<?php
session_start();
include 'setup_database.php';

$conn = new mysqli("localhost", "root", "", "travel");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];
$booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;
$type = isset($_POST['type']) ? $_POST['type'] : '';
if ($type === 'flight') {
    $sql = "UPDATE flight_bookings SET status = 'Paid' WHERE id = ? AND user_id = ?";
} elseif ($type === 'package') {
    $sql = "UPDATE package_bookings SET status = 'Paid' WHERE booking_id = ? AND user_id = ?";
} elseif ($type === 'train') {
    $sql = "UPDATE train_bookings SET status = 'Paid' WHERE id = ? AND user_id = ?";
} elseif ($type === 'hotel') {
    $sql = "UPDATE hotel_bookings SET status = 'Paid' WHERE booking_id = ? AND user_id = ?";
} else {
    die("Invalid booking type. Please use 'flight' or 'package' or 'hotel' or 'train'.");
}

// Prepare the statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Prepare Error: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ii", $booking_id, $user_id);

// Execute and debug affected rows
if (!$stmt->execute()) {
    die("SQL Execute Error: " . $stmt->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .success-container {
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .checkmark-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }

        .checkmark {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #4CAF50;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: popIn 0.5s ease-in-out forwards;
        }

        @keyframes popIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .checkmark::after {
            content: "✔";
            font-size: 40px;
            color: white;
            font-weight: bold;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            display: inline-block;
            width: 100%;
            margin-top: 15px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="success-container">
        <div class="checkmark-container">
            <div class="checkmark"></div>
        </div>
        <?php
        if ($stmt->affected_rows > 0) {
        ?>
            <h2 class="text-success">Payment Successful!</h2>
            <p class="text-muted">Your booking has been confirmed.</p>
            <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking_id); ?></p>
            <a href="home.php" class="btn-custom">🏡 Go to Dashboard</a>
        <?php
        } else { ?>
            <p>No rows updated. Please verify your Booking ID and User ID.</p>
        <?php
        }
        ?>

    </div>

</body>

</html>

<?php
$stmt->close();
$conn->close();
?>