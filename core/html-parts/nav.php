<?php

if (isset($_SESSION['user_id'])) {
    
    $sql = "SELECT * FROM users WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

} else {
    $user = null;
}

echo '
<nav class="navbar" style="background-color: #CFEE91">
    <div class="container-fluid">
    <ul class="nav nav-pills justify-content-center">
        <li class="nav-item border rounded" ><a class="nav-link" href="/core/main.php">Home</a></li>';

if ($user) {
    echo '<li class="nav-item border rounded"><a class="nav-link" href="/core/posts/upload.php">Upload</a></li>';

} else {
    echo '
    <li class="nav-item border rounded"><a class="nav-link" href="/core/users/login.php">Login</a></li>
    <li class="nav-item border rounded"><a class="nav-link" href="/core/users/signup.php">Register</a></li>';
}

echo '<li class="nav-item border rounded"><a class="nav-link" href="/core/hide.php">Hide the page! [F9]</a></li>';

if ($user) {
    echo '
    <li class="nav-item dropdown border rounded">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        ' . htmlspecialchars($user['username']) . '
        </a>
        <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="/core/users/user.php?user_id=' . ($user['id']) . '">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="/core/users/logout.php">Logout</a></li>
        </ul>
    </li>';
}

echo'

</ul>

<form class="d-flex" role="search" action="/core/search-posts.php" method="post">
    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
</form>

</div>
</nav>';
?>
