<?php
require 'config.php';

session_start();

$mysqli = $_DBPATH;

if (isset($_SESSION['user_id'])) {

    $sql = "SELECT * FROM users WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

}

$sql = "SELECT id, title, filehash, extension FROM posts LIMIT 15";

$result = $mysqli->query($sql);

$posts = [];

var_dump($result);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <meta charset="UTF-8">
    </head>

    <body>
        <?php include 'html-parts/nav.php'; ?>

        <h1>Home</h1>

        <?php if (isset($user)): ?>

            <p>Hello <?= htmlspecialchars($user['username']) ?></p>

            <a href='users/logout.php'>Log out</a>


        <?php else: ?>

            <p>Please <a href='users/login.php'>log in</a> or <a href='users/signup.html'>sign up</a></p>

        <?php endif; ?>
        
        <?php
            if ($result) {
                // Fetch all rows as an associative array
                $posts = [];
                while ($post = $result->fetch_assoc()) {
                    $posts[] = $post;  // Add each post to the array
                }

                // Iterate through the posts array
                foreach ($posts as $post) {
                    echo '<div class="post">';
                    echo '<a href="/core/posts/view.php?post_id=' . $post['id'] . '">';
                    echo '<img src="/storage/uploads/' . htmlspecialchars($post['filehash'] . "." . $post['extension']) . '" alt="Post Image" width="300" height="300">';

                    echo '</div>';
                }
            } else {
                echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
            }
        ?>


    </body>

</html>