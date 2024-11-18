<?php
include_once "Models/GuestList.php";
include_once __DIR__ . '/../Includes/navigation.php'; // Use __DIR__ to get the absolute path of the current file



// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check admin status using the corrected session key
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

// Create a new Event instance and get the list of events
$guestListModel = new GuestList();
$guestLists = $guestListModel->list();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Dashboard</title>
</head>
<body>
    <h1>Event Dashboard</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Event Id</th>
                <?php if ($isAdmin): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guestLists as $guestList): ?>
                <tr>
                    <td><?php echo htmlspecialchars(html_entity_decode($guestList->id)); ?></td>
                    <td><?php echo htmlspecialchars(html_entity_decode($guestList->eventId)); ?></td>
                      <?php if ($isAdmin): ?>
                        <!---    <a href="?controller=guestList&action=editGuestList&id=<?php echo $guestList->id; ?>">Edit</a> |
                            <a href="?controller=guestList&action=deleteGuestList&id=<?php echo $guestList->eventId; ?>"
                               onclick="return confirm('Are you sure?');">Delete</a>
                        </td>--->
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
