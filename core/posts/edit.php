<?php
require '../config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $mysqli = $_DBPATH;

    if (isset($_GET['post_id'])) {
        $postId = $mysqli->real_escape_string((int)$_GET['post_id']);

        $sql = sprintf("SELECT * FROM posts WHERE id = '%s'", $postId);

        $result = $mysqli->query($sql);

        $post = $result->fetch_assoc();

        if (! $post) {
            header("Location: upload.html");
            exit();
        }

        if ($post['user_id']) {
            $sql = sprintf("SELECT username FROM users WHERE id = '%s'", $post['user_id']);

            $result = $mysqli->query($sql);

            $user = $result->fetch_assoc();

        }
        else {
            $user = null;
        }
    }

    if ($_SESSION['user_id'] !== $post['user_id']) {
        header('Location: error.php');
        exit();
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post <?= $post['id'] ?></title>
</head>
<body>
    <?php include '../html-parts/nav.php'; ?>

    <h1>Editing: <?= $post['title'] ?></h1>

    <form action="edit-post.php" method="post" enctype="multipart/form-data">

        <!-- <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> -->
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <label for="title">Post title</label>
        <input type="text" id="title" name="title" value="<?= $post['title'] ?>">
        <br>
        
        <button>Save</button>

    </form>
    
</body>