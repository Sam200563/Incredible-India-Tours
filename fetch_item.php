<?php
include 'setup_database.php';
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the type parameter from the URL
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Function to fetch items based on type
function fetchItems($conn, $type)
{
    $query = '';
    if ($type === 'hotel') {
        $query = "SELECT * FROM hotels";
    } elseif ($type === 'flights') {
        $query = "SELECT * FROM flights";
    } elseif ($type === 'packages') {
        $query = "SELECT * FROM packages";
    } elseif ($type === 'trains') {
        $query = "SELECT * FROM trains";
    }

    if (!empty($query)) {
        $result = $conn->query($query);
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
    return [];
}

// Fetch items if a valid type is provided
$items = fetchItems($conn, $type);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage <?php echo ucfirst($type); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage <?php echo ucfirst($type); ?></h2>
        <?php if (!empty($items)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <?php foreach (array_keys($items[0]) as $column): ?>
                            <th><?php echo ucfirst($column); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <?php foreach ($item as $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-danger">No data found or invalid type specified.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>
