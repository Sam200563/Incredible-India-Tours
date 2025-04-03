<?php
$servername = "localhost";
$username = "root"; // Change as necessary
$password = ""; // Change as necessary
$db = "travel";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $password = password_hash("admin123", PASSWORD_BCRYPT); // Use this hashed password
// // Insert into database
// $sql="INSERT INTO admin (username, password) VALUES ('admin', '$password')";
// if($conn->query($sql)===TRUE){
//     echo "Inserted data successfully";
// }else{
//     echo "data is not inserted";
// }

// $contact="CREATE TABLE admin(
//     username varchar(255),
//     password varchar(255) 
// )";
// if($conn->query($contact)===TRUE)
// {
//     echo "Table is created";
// }
// else{
//     echo "Table is not created";

// }

// $contact="CREATE TABLE contact(
//     userid INT AUTO_INCREMENT PRIMARY KEY,
//     user_name VARCHAR(50) NOT NULL,
//     email VARCHAR(255) NOT NULL,
//     phone_no INT NOT NULL,
//     msg Text 
// )";
// if($conn->query($contact)===TRUE)
// {
//     echo "Table is created";
// }
// else{
//     echo "Table is not created";

// }

// Create database
// $sql = "CREATE DATABASE travel";
// if ($conn->query($sql) === TRUE) {
//     echo "Database created successfully\n";
// } else {
//     echo "Error creating database: " . $conn->error . "\n";
// }

// $region="CREATE TABLE Region (
//     region_id INT PRIMARY KEY AUTO_INCREMENT,
//     region_name VARCHAR(255) NOT NULL
// )";
// if($conn->query($region)===TRUE){
//     echo "Region Table is created";
// } else{
//     echo "Table is not created";
// }

// $state="CREATE TABLE State (
//     state_id INT PRIMARY KEY AUTO_INCREMENT,
//     state_name VARCHAR(255) NOT NULL,
//     region_id INT,
//     FOREIGN KEY (region_id) REFERENCES Region(region_id)
// )";
// if($conn->query($state)===TRUE){
//     echo "State Table is created";
// } else{
//     echo "Table is not created";
// }

// $city="CREATE TABLE City (
//     city_id INT PRIMARY KEY AUTO_INCREMENT,
//     city_name VARCHAR(255) NOT NULL,
//     state_id INT,
//     FOREIGN KEY (state_id) REFERENCES State(state_id)
// )";
// if($conn->query($city)===TRUE){
//     echo "City Table is created";
// } else{
//     echo "Table is not created";
// }

// $user="CREATE TABLE Users (
//     user_id INT AUTO_INCREMENT PRIMARY KEY,
//     username VARCHAR(50) NOT NULL UNIQUE,
//     password VARCHAR(255) NOT NULL,
//     email VARCHAR(100) NOT NULL UNIQUE,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// )";
// if($conn->query($user)===TRUE){
//     echo "Table is created";
// }

// $sql_p="CREATE TABLE hotels (
//     id INT(11) AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(255) NOT NULL,
//     price_range VARCHAR(255) NOT NULL,
//     description TEXT NOT NULL,
//     amenities TEXT NOT NULL,
//     images TEXT NOT NULL,
//     state_id INT(11),
//     city_id INT(11),
//     FOREIGN KEY (state_id) REFERENCES state(state_id),
//     FOREIGN KEY (city_id) REFERENCES city(city_id)
// )";
// $sql_p="CREATE TABLE flights (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     origin VARCHAR(100),
//     destination VARCHAR(100),
//     departure_time DATETIME,
//     arrival_time DATETIME,
//     class VARCHAR(50),
//     price DECIMAL(10, 2),
//     seats_available INT
// )";
// $sql_p="CREATE TABLE flight_bookings (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     user_id INT,
//     flight_id INT,
//     booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     passengers INT,
//     total_price DECIMAL(10, 2),
//     FOREIGN KEY (flight_id) REFERENCES flights(id)
// )";
// if($conn->query($sql_p)===TRUE){
//         echo "hotel Table is created";
//     } else{
//         echo "Table is not created";
//     }

// $sql_p = "CREATE TABLE packages (
//     id INT(11) AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(255) NOT NULL,
//     price DECIMAL(10, 2) NOT NULL,
//     description TEXT NOT NULL,
//     duration VARCHAR(255) NOT NULL,
//     destinations TEXT NOT NULL,
//     inclusions TEXT NOT NULL,
//     exclusions TEXT NOT NULL,
//     images TEXT NOT NULL,
//     itinerary TEXT NOT NULL,
//     state_id INT NOT NULL,
//     city_id INT NOT NULL,
//     FOREIGN KEY (state_id) REFERENCES state(state_id),
//     FOREIGN KEY (city_id) REFERENCES city(city_id) 
// )";
// if($conn->query($sql_p)===TRUE){
//     echo "package Table is created";
// } else{
//     echo "Table is not created";
// }
// $packages = [


// ];

// // // //Insert data into packages table
// foreach ($packages as $package) {
//     $sql = "INSERT INTO packages (name, price, description, duration, destinations, inclusions, exclusions, images,itinerary,state_id,city_id) 
//             VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param(
//         "sdsssssssdd",
//         $package['name'],
//         $package['price'],
//         $package['description'],
//         $package['duration'],
//         $package['destinations'],
//         $package['inclusions'],
//         $package['exclusions'],
//         $package['images'],
//         $package['itinerary'],
//         $package['state_id'],
//         $package['city_id']
//     );

//     $stmt->execute();
// }

// $stmt->close();


// $sql = " DROP TABLE packages";
// if ($conn->query($sql) === TRUE) {
//     echo "table drop successfully\n";
// } else {
//     echo "Error creating database: " . $conn->error . "\n";
// }
// $hotel="CREATE TABLE hotel(
//      id INT(11) AUTO_INCREMENT PRIMARY KEY,
//      name VARCHAR(255) NOT NULL,
//      location VARCHAR(255) NOT NULL,
//      description TEXT NOT NULL,
//      amenities TEXT NOT NULL,
//      image_url TEXT NOT NULL,
//      price_per_night DECIMAL(10,2)
// )";
// if($conn->query($hotel)===TRUE){
//     echo "table is created";
// }else{
//     echo "table is not created". $conn->error; 
// }
$conn->close();
