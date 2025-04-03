<?php
include('setup_database.php');
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$name=$conn->real_escape_string($_POST['name']);
$email=$conn->real_escape_string($_POST['email']);
$phone=$conn->real_escape_string($_POST['phone']);
$message=$conn->real_escape_string($_POST['message']);

$sql="INSERT INTO contact (user_name,email,phone_no,msg) VALUES('$name','$email','$phone','$message')";

if ($conn->query($sql) === TRUE) {
    // Success message prompt
    echo "<script>
            alert('Form submitted successfully!');
            window.location.href = 'contact.html';  // Redirect to the contact page or home page
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
$conn->close();
?>