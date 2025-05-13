<?php
include 'middleware.php'; // Blocks access if not logged in

$user = $_SESSION['user'];
?>

<h1>Welcome, <?= htmlspecialchars($user['name']) ?>!</h1>
<p>Your username is: <?= htmlspecialchars($user['username']) ?></p>
<a href="logout.php">Logout</a>
