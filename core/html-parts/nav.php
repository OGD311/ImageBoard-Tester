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
    <ul class="nav nav-pills justify-content-center">
        <li class="nav-item border rounded" ><a class="nav-link" href="http://localhost:8080/core/index.php">Home</a></li>';

if ($user) {
    echo '<li class="nav-item border rounded"><a class="nav-link" href="http://localhost:8080/core/posts/upload.php">Upload</a></li>';

} else {
    echo '
    <li class="nav-item border rounded"><a class="nav-link" href="http://localhost:8080/core/users/login.php">Login</a></li>
    <li class="nav-item border rounded"><a class="nav-link" href="http://localhost:8080/core/users/signup.php">Register</a></li>';
}

echo '<li class="nav-item border rounded"><a class="nav-link" href="http://localhost:8080/core/hide.php">Hide the page! [F9]</a></li>';

if ($user) {
    echo '
    <li class="nav-item dropdown border rounded">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        ' . htmlspecialchars($user['username']) . '
        </a>
        <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="http://localhost:8080/core/users/user.php?user_id=' . ($user['id']) . '">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="http://localhost:8080/core/users/logout.php">Logout</a></li>
        </ul>
    </li>';
}

echo'    </ul>
</nav>
';
?>
