<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo LOGIN_TITLE; ?></title>
</head>
<body>
    <h1><?php echo LOGIN_TITLE; ?></h1>
    <form action="/PracticeProject/<?php echo $lang; ?>/user/loginProcess" method="POST">
        <input type="text" name="username" placeholder="<?php echo USERNAME; ?>">
        <input type="password" name="password" placeholder="<?php echo PASSWORD; ?>">
        <button type="submit"><?php echo LOGIN; ?></button>
    </form>
    <p><?php echo NO_ACCOUNT; ?> <a href="/PracticeProject/<?php echo $lang; ?>/user/register"><?php echo REGISTER_HERE; ?></a></p>
</body>
</html>
