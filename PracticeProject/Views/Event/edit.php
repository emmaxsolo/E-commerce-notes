<?php if (isset($event) && $event): ?>
    <h1>Edit Event</h1>
    <!-- Updated form action to use clean URL -->
    <form method="POST" action="/PracticeProject/event/editSave/<?= htmlspecialchars($event->id) ?>">
        <label for="name">Event Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars(html_entity_decode($event->name)) ?>" required><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?= htmlspecialchars(html_entity_decode($event->description)) ?></textarea><br>

        <label for="location">Location:</label>
        <input type="text" name="location" id="location" value="<?= htmlspecialchars(html_entity_decode($event->location)) ?>" required><br>

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" value="<?= htmlspecialchars(html_entity_decode($event->date)) ?>" required><br>

        <button type="submit">Update Event</button>
    </form>
<?php else: ?>
    <p style="color:red;">Event not found or invalid ID.</p>
<?php endif; ?>

<!-- Updated Back link to use clean URL -->
<a href="/PracticeProject/event/list">Back to Event List</a>
