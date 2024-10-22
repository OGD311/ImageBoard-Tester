<?php
require_once '../../config.php';

session_start();

$mysqli = $_DB;

if (! isset($_SESSION['user_id']) && !is_admin($_SESSION['user_id'])) {
    header('Location: /core/users/login.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1>Admin Console</h1>
    <h3>Welcome <?= get_user_name($_SESSION['user_id']) ?></h3>
    <ul>

        <li><a href="regenerate-thumbnails.php">Regenerate Thumbnails</a></li>

        <li><a href="recount-tags.php">Recount Tags</a></li>

        <li><a href="sql-test.php">SQL Posts check</a></li>

        <li><a href="shuffle-post-ids.php">Shuffle Post IDs</a></li>

        <li><a href="/index.php">Home</a></li>

    </ul>
    
</body>
</html>