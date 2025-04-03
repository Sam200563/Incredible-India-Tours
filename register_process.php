<?php
include 'setup_database.php';
$servername = "localhost";
$username = "root"; 
$password = ""; 
$db = "travel";
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
$email = $_POST['email'];
$phone=$_POST['phone'];
$dob=$_POST['dob'];
$state=$_POST['state'];
$preferred_destination=$_POST['preferred_destination'];
$address=$_POST['address'];
$emergency_contact=$_POST['emergency_contact'];
$profile_picture=$_POST['profile_picture'];

$sql = "INSERT INTO Users (username, password, email,phone,dob,state,preferred_destination,address,emergency_contact,profile_picture) VALUES (?, ?, ?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssiisssis", $username, $password, $email,$phone,$dob,$state,$preferred_destination,$address,$emergency_contact,$profile_picture);

if ($stmt->execute()) {
    header("Location: login.php"); 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
