<?php

if (isset($_SESSION['user_id'])) {
    
    $sql = "SELECT * FROM users WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

} else {
    $user = null;
}

echo '
<nav>
    <ul>
        <li><a href="http://localhost:8080/core/index.php">Home</a></li>';

if ($user) {
    echo '<li><a href="http://localhost:8080/core/posts/upload.php">Upload</a></li>';
    echo '<li><a href="http://localhost:8080/core/users/logout.php">Logout</a><span> - ' . ($user['username']) . '</span></li>';
    echo '<li><a href="http://localhost:8080/core/users/user.php?user_id=' . ($user['id']) . '">My profile</a></li>';

} else {
    echo '
    <li><a href="http://localhost:8080/core/users/login.php">Login</a></li>
    <li><a href="http://localhost:8080/core/users/signup.php">Register</a></li>';
}

echo ' 
    <li><a href="http://localhost:8080/core/hide.php">Hide the page! [F9]</a></li>
    </ul>
</nav>
';
?>
