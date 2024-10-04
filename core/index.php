<?php
require_once '../config.php';

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
        <?php include 'html-parts/header-elems.php' ?>
        <meta charset="UTF-8">
    </head>

    <body>
        <?php include 'html-parts/nav.php'; ?>

        <h1>Latest Posts</h1>
        <div id="posts" class="container-fluid text-center row justify-content-center">
        <?php
            if ($result) {
                foreach ($posts as $post) {
                    echo '<div class="card justify-content-center border-2 m-1" style="width: 12rem;">';
                    echo '<a href="/core/posts/view.php?post_id=' . $post['id'] . '">';
                    echo '<img class="card-img-top" src="/storage/uploads/' . htmlspecialchars($post['filehash'] . "." . $post['extension']) . '" alt="Post Image" width=200 height=200 style="object-fit: contain;">';
                    echo '</a></div>';
                }
            } else {
                echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
            }

        ?>

        </div>

        <?php include 'html-parts/footer.php'; ?>
    </body>

</html>