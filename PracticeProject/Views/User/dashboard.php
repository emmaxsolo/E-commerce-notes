<?php
include_once "Models/Event.php";
include_once __DIR__ . '/../Includes/navigation.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$lang = $_SESSION['lang'] ?? 'en';
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

$eventModel = new Event();
$events = $eventModel->listEvents();
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Dashboard</title>
</head>
<body>
    <h1>Event Dashboard</h1>

    <?php if ($isAdmin): ?>
        <a href="/PracticeProject/<?php echo $lang; ?>/event/create">Create Event</a>
        <?php endif; ?>
    
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Location</th>
                <th>Date</th>
                <?php if ($isAdmin): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo htmlspecialchars(html_entity_decode($event->name)); ?></td>
                    <td><?php echo htmlspecialchars(html_entity_decode($event->description)); ?></td>
                    <td><?php echo htmlspecialchars(html_entity_decode($event->location)); ?></td>
                    <td><?php echo htmlspecialchars(html_entity_decode($event->date)); ?></td>
                    <?php if ($isAdmin): ?>
                        <td>
                            <a href="/PracticeProject/<?php echo $lang; ?>/event/edit/<?php echo $event->id; ?>">Edit</a> |
                            <a href="/PracticeProject/<?php echo $lang; ?>/event/delete/<?php echo $event->id; ?>"
                               onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
