<?php
require_once '../../config.php';

session_start();

$mysqli = $_DB;

if (! isset($_SESSION['user_id']) && !is_admin($_SESSION['user_id'])) {
    header('Location: /core/users/login.php');
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

    <a href="regenerate-thumbnails.php">Regenerate Thumbnails</a>


    <a href="/index.php">Home</a>
    
</body>
</html>