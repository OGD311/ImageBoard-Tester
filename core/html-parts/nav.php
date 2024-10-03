<?php

if (isset($_SESSION['user_id'])) {
    
    $sql = "SELECT * FROM users WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

} else {
    $user = null;
}

echo '
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<nav>
    <ul>
        <li><a href="http://localhost:8080/core/index.php">Home</a></li>';

if ($user) {
    echo '<li><a href="http://localhost:8080/core/posts/upload.php">Upload</a></li>';
    echo '<li><a href="http://localhost:8080/core/users/logout.php">Logout</a></li>';
} else {
    echo '
    <li><a href="http://localhost:8080/core/users/login.php">Login</a></li>
        <li><a href="http://localhost:8080/core/users/signup.php">Register</a></li>';
}

echo ' 
    </ul>
</nav>
';
?>
