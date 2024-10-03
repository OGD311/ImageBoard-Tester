<?php

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $mysqli = require dirname(__DIR__, 1) . "\storage\database.php";

    if (isset($_GET['post_id'])) {
        $postId = $mysqli->real_escape_string((int)$_GET['post_id']);

        $sql = sprintf("SELECT * FROM posts WHERE id = '%s'", $postId);

        $result = $mysqli->query($sql);

        $post = $result->fetch_assoc();

        if (! $post) {
            header("Location: upload.html");
            exit();
        }
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
    <h1><?= $post['title'] ?></h1>
    <img src="../storage/uploads/<?= $post['filehash'] . "." . $post['extension'] ?>" height="<?= $post['file_height'] ?>" width="<?= $post['file_width'] ?>">

    <p>Uploaded at <?= date("Y-m-d h:i:sa", $post['uploaded_at']) ?></p>
    <p>File type: <?=  $post['extension'] ?></P>
    <p>File Resolution: <?= $post['file_height'] . " x " . $post['file_width'] ?></p>
    <p>MD5 Hash: <?= $post['filehash'] ?></p>
    
</body>