<?php
require_once 'config.php';

session_start();

$mysqli = $_DBPATH;

if (isset($_SESSION['user_id'])) {

    $sql = "SELECT username FROM users WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

}

$sql = "SELECT id, title, filehash, extension FROM posts ORDER BY uploaded_at DESC LIMIT 15;";

$result = $mysqli->query($sql);

$posts = [];
while ($post = $result->fetch_assoc()) {
    $posts[] = $post; 
}

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

        <h1>Latest Posts</h1>
        
        <?php
            if ($result) {
  
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