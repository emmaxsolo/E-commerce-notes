<?php
$lang = $_SESSION['lang'] ?? 'en';
?>
<nav>
    <ul>
        <li><a href="/PracticeProject/<?php echo $lang; ?>/user/dashboard">Events</a></li>
        <li><a href="/PracticeProject/<?php echo $lang; ?>/guestlist/list">GuestLists</a></li>
        <li><a href="/PracticeProject/<?php echo $lang; ?>/user/logout">Logout</a></li>
    </ul>
</nav>
