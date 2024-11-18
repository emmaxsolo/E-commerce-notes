<?php
$lang = $_SESSION['lang'] ?? 'en';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <!-- Use clean URL for form submission -->
    <form action="/PracticeProject/<?php echo $lang; ?>/user/registerSave" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="isAdmin">Admin:</label>
        <input type="checkbox" id="isAdmin" name="isAdmin" value="1">
        <br>
        <button type="submit">Register</button>
    </form>
    <!-- Use clean URL for login link -->
    <p>Already have an account? <a href="/PracticeProject/<?php echo $lang; ?>/user/login">Login here</a></p>
</body>
</html>
