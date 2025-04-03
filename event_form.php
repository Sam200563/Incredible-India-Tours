<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add/Edit Event</title>
</head>
<body>
    <h2>Add or Edit Event</h2>
    <form action="event_action.php" method="POST">
        <!-- Hidden field to store event ID (only used for editing) -->
        <input type="hidden" name="id" value="<?php echo isset($event['id']) ? $event['id'] : ''; ?>">

        <label for="title">Event Title:</label>
        <input type="text" id="title" name="title" value="<?php echo isset($event['title']) ? $event['title'] : ''; ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo isset($event['description']) ? $event['description'] : ''; ?></textarea>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo isset($event['date']) ? $event['date'] : ''; ?>" required>

        <label for="time">Time:</label>
        <input type="time" id="time" name="time" value="<?php echo isset($event['time']) ? $event['time'] : ''; ?>" required>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo isset($event['location']) ? $event['location'] : ''; ?>" required>

        <label for="organizer">Organizer:</label>
        <input type="text" id="organizer" name="organizer" value="<?php echo isset($event['organizer']) ? $event['organizer'] : ''; ?>" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo isset($event['price']) ? $event['price'] : '0.00'; ?>" step="0.01" required>

        <button type="submit">Save Event</button>
    </form>
</body>
</html>
