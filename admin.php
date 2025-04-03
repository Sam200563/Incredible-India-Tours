<?php
session_start();
include 'setup_database.php'; // Database connection

// Check if admin is logged in (add your own authentication logic)
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$db = "travel";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #dropdown {
            font-size: 1.5rem;
            font-style: normal;
            font-weight: 600;
            background-color: #0d6efd;
            color: white !important;
            border-radius: 5px;
            padding: 5px
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div>
            <h1 class="text-center">Admin Dashboard</h1>
            <div class="d-flex justify-content-end">
                <div class="nav-item dropdown">
                    <a class="nav-link text-dark" href="#" role="button" data-bs-toggle="dropdown" id="dropdown">Log In</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin_login.php">Log In</a></li>
                        <li><a class="dropdown-item" href="admin_logout.php">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Sidebar -->
            <div class="col-md-3">
                <ul class="list-group">
                    <li class="list-group-item"><a href="admin.php?type=hotel">Manage Hotels</a></li>
                    <li class="list-group-item"><a href="admin.php?type=flights">Manage Flights</a></li>
                    <li class="list-group-item"><a href="admin.php?type=packages">Manage Packages</a></li>
                    <li class="list-group-item"><a href="admin.php?type=trains">Manage Trains</a></li>
                    <li class="list-group-item"><a href="event_form.php">Manage Events</a></li>
                </ul>
            </div>

            <!-- Main Section -->
            <div class="col-md-9">
                <h3>Manage <?php echo isset($_GET['type']) ? ucfirst($_GET['type']) : 'Hotels'; ?></h3>
                <div id="adminActions" class="mb-3">
                    <button class="btn btn-success" onclick="showForm('add')">Add</button>
                    <button class="btn btn-primary" onclick="showForm('update')">Update</button>
                    <button class="btn btn-danger" onclick="showForm('delete')">Delete</button>
                </div>
                <div id="dynamicForm" class="mt-3"></div>
                <div id="itemsTable" class="mt-3">
                    <!-- Fetched data will be displayed here -->
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script>
        // Get the 'type' parameter from the URL
        const params = new URLSearchParams(window.location.search);
        const type = params.get('type') || 'hotel'; // Default to 'hotel'

        // Update the page heading dynamically
        document.getElementById('itemType').innerText = capitalizeFirstLetter(type);

        // Function to capitalize the first letter of a string
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Function to dynamically show forms
        function showForm(action) {
            let formHtml = '';
            if (action === 'add') {
                formHtml = `
                    <h4>Add New ${capitalizeFirstLetter(type)}</h4>
                    <form action="admin_add_handler.php" method="POST">
                        <input type="hidden" name="type" value="${type}">
                        ${getDynamicFields(type)}
                        <button type="submit" class="btn btn-success mt-2">Add</button>
                    </form>`;
            } else if (action === 'update') {
                formHtml = `
                    <h4>Update ${capitalizeFirstLetter(type)}</h4>
                    <form action="admin_update_handler.php" method="POST">
                        <input type="hidden" name="type" value="${type}">
                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="number" class="form-control" id="id" name="id" placeholder="Enter ID to update" required>
                        </div>
                        ${getDynamicFields(type)}
                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                    </form>`;
            } else if (action === 'delete') {
                formHtml = `
                    <h4>Delete ${capitalizeFirstLetter(type)}</h4>
                    <form action="admin_delete_handler.php" method="POST">
                        <input type="hidden" name="type" value="${type}">
                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="Enter ID to delete" required>
                        </div>
                        <button type="submit" class="btn btn-danger mt-2">Delete</button>
                    </form>`;
            }
            document.getElementById('dynamicForm').innerHTML = formHtml;
        }

        // Function to dynamically generate form fields based on type
        function getDynamicFields(type) {
            if (type === 'hotel') {
                return `
                    <div class="mb-3">
                        <label for="name" class="form-label">Hotel Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_per_night" class="form-label">Price Per Night</label>
                        <input type="number" class="form-control" id="price_per_night" name="price_per_night" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="state_id" class="form-label">State</label>
                        <select class="form-control" id="state_id" name="state_id" required>
                            <option value="">Select a State</option>
                            <?php
                            // Database connection
                            include 'setup_database.php';
                            $conn = new mysqli($servername, $username, $password, $db);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            // Fetch states
                            $query = "SELECT state_id, state_name FROM state";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['state_id']}'>{$row['state_name']}</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No States Available</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="city_id" class="form-label">City</label>
                        <select class="form-control" id="city_id" name="city_id" required>
                            <option value="">Select a City</option>
                            <?php
                            // Fetch cities dynamically from the database
                            $conn = new mysqli($servername, $username, $password, $db);
                            $result = $conn->query("SELECT city_id, city_name FROM city");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['city_id']}'>{$row['city_name']}</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>`;
            } else if (type === 'flights') {
                return `
                    <div class="mb-3">
                        <label for="origin" class="form-label">Origin</label>
                        <input type="text" class="form-control" id="origin" name="origin" required>
                    </div>
                    <div class="mb-3">
                        <label for="destination" class="form-label">Destination</label>
                        <input type="text" class="form-control" id="deatination" name="destination" required>
                    </div>
                    <div class="mb-3">
                        <label for="departure_time" class="form-label">Departure_time</label>
                        <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="arrival_time" class="form-label">Arrival_time</label>
                        <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-control" id="class" name="class" required>
                            <option>Economy</option>
                            <option>Business</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="seats_available" class="form-label">Seats_available</label>
                        <input type="number" class="form-control" id="seats_available" name="seats_available" required>
                    </div>`;
            } else if (type === 'packages') {
                return `
                    <div class="mb-3">
                        <label for="package_name" class="form-label">Package Name</label>
                        <input type="text" class="form-control" id="package_name" name="package_name" required>
                    </div>
                     <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" required>
                    </div>
                    <div class="mb-3">
                        <label for="destination" class="form-label">Destinations</label>
                        <input type="text" class="form-control" id="destination" name="destination" required>
                    </div>
                    <div class="mb-3">
                        <label for="inclusions" class="form-label">Inclusion (comma-separated):</label>
                        <textarea name="inclusions" class="form-control" required></textarea><br>
                    </div>
                    <div class="mb-3">
                        <label for="exclusions" class="form-label">Exclusion (comma-separated):</label>
                        <textarea name="exclusions" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images (comma-separated URLs):</label>
                        <input type="text" class="form-control" name="images" required>
                    </div>
                    <div class="mb-3">
                        <label for="itinerary" class="form-label">Itinerary:</label>
                        <textarea name="itinerary" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="state_id" class="form-label">State</label>
                        <select class="form-control" id="state_id" name="state_id" required>
                            <option value="">Select a State</option>
                            <?php
                            // Database connection
                            include 'setup_database.php';
                            $conn = new mysqli($servername, $username, $password, $db);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            // Fetch states
                            $query = "SELECT state_id, state_name FROM state";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['state_id']}'>{$row['state_name']}</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No States Available</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="city_id" class="form-label">City</label>
                        <select class="form-control" id="city_id" name="city_id" required>
                            <option value="">Select a City</option>
                            <?php
                            // Fetch cities dynamically from the database
                            $conn = new mysqli($servername, $username, $password, $db);
                            $result = $conn->query("SELECT city_id, city_name FROM city");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['city_id']}'>{$row['city_name']}</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>`;
            } else if (type === 'trains') {
                return `
                    <div class="mb-3">
                        <label for="train_name" class="form-label">Train Name</label>
                        <input type="text" class="form-control" id="train_name" name="train_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="departure" class="form-label">Departure Station</label>
                        <input type="text" class="form-control" id="departure" name="departure" required>
                    </div>
                    <div class="mb-3">
                        <label for="arrival" class="form-label">Arrival Station</label>
                        <input type="text" class="form-control" id="arrival" name="arrival" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>`;
            }
            return '';
        }
    </script>
</body>

</html>