<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
</head>
<body>
    <h1>Create Event</h1>
    <form action="/PracticeProject/event/createSave" method="POST">
        <label for="name">Event Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="description">Event Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <label for="location">Event Location:</label>
        <input type="text" id="location" name="location" required>
        <br>
        <label for="date">Event Date:</label>
        <input type="date" id="date" name="date" required>
        <br>
        <button type="submit">Create Event</button>
    </form>
    <p><a href="/PracticeProject/event/list">Back to Dashboard</a></p>
</body>
</html>
