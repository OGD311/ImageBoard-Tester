<?php
require_once '../config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $mysqli = $_DBPATH;

    if (isset($_GET['post_id'])) {
        $postId = $mysqli->real_escape_string((int)$_GET['post_id']);

        $sql = sprintf("SELECT * FROM posts WHERE id = '%s'", $postId);

        $result = $mysqli->query($sql);

        $post = $result->fetch_assoc();

        if (! $post) {
            header("Location: error.php");
            exit();
        }

        if ($post['user_id']) {
            $sql = sprintf("SELECT id, username, is_admin FROM users WHERE id = '%s'", $post['user_id']);

            $result = $mysqli->query($sql);

            $uploader = $result->fetch_assoc();

        }
        else {
            $uploader = [
                "id" => "1",
                "username" => "Admin",
                "is_admin" => "1"
            ];
        }
    }

    
} else {
    header('Location: http://localhost:8080/core/index.php');
    exit();
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
    <h1><?= $post['title'] ?></h1>
    <img src="<?= '/storage/uploads/' . $post['filehash'] . "." . $post['extension'] ?>" height="<?= $post['file_height'] ?>" width="<?= $post['file_width'] ?>">

    <p>Uploaded on <?= date("d/m/y h:i:s a", $post['uploaded_at']) ?></p>
        
    <?php if ($post['updated_at']): ?>
        <p>Last updated on <?= date("d/m/y h:i:s a", $post['updated_at']) ?></p>
    <?php endif ?>
        
    
    <p>File type: <?=  $post['extension'] ?></P>
    <p>File Resolution: <?= $post['file_height'] . " x " . $post['file_width'] ?></p>
    <?php if ($uploader): ?>
        <p>Uploaded by: <?= $uploader['username'] ?></p>
    <?php endif ?>
    <p>MD5 Hash: <?= $post['filehash'] ?></p>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== '' && ($uploader['id'] == $_SESSION['user_id'] || $user['is_admin'] == 1)): ?>
        <a href="edit.php?post_id=<?= $post['id'] ?>">Edit</a>
    <?php endif ?>

    <?php include '../comments/comment-view.php'; ?>
    
    <?php include '../comments/comment-form.php'; ?>
    
</body>