<?php

require_once '../../config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $mysqli = $_DBPATH;

    if (isset($_GET['post_id'])) {
        $postId = (int)$_GET['post_id']; // Casting to integer for safety
    
        // Combined SQL query using LEFT JOIN
        $sql = sprintf("
            SELECT p.*, u.id AS uploader_id, u.username, u.is_admin 
            FROM posts p 
            LEFT JOIN users u ON p.user_id = u.id 
            WHERE p.id = '%s'", 
            $mysqli->real_escape_string($postId)
        );
    
        $result = $mysqli->query($sql);
    
        $post = $result->fetch_assoc();
    
        if (!$post) {
            header("Location: ../errors/post-view.php");
            exit();
        }

        $uploader = [
            "id" => $post['uploader_id'],
            "username" => $post['username'],
            "is_admin" => $post['is_admin']
        ];
    }
    
} else {
    header('Location: /core/main.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post <?= $post['id'] ?></title>
    <?php include '../html-parts/header-elems.php' ?>
</head>
<body>
    <?php include '../html-parts/nav.php'; ?>


    <div class="container-fluid text-center justify-content-center">
        <h1><?= $post['title'] ?></h1>
        <img class="" src="<?= '/storage/uploads/' . $post['filehash'] . '.' . $post['extension'] ?>" height="<?= $post['file_height'] ?>" width="<?= $post['file_width'] ?>" style="border-width: 1px;">
    </div>
    <br>
    <div id="details" class="container-md text-center justify-content-center " style="font-size: 12px;">
        <p>Uploaded on <?= date("d/m/y h:i:s a", $post['uploaded_at']) ?></p>
            
        <?php if ($post['updated_at']): ?>
            <p>Last updated on <?= date("d/m/y h:i:s a", $post['updated_at']) ?></p>
        <?php endif ?>
            
        
        <p>File type: <?=  $post['extension'] ?></P>
        <p>File Resolution: <?= $post['file_height'] . " x " . $post['file_width'] ?></p>
        <?php if ($uploader): ?>
            <p>Uploaded by: <a href="../users/user.php?user_id=<?php echo htmlspecialchars($uploader['id']); ?>"><?= $uploader['username'] ?></a>
            </a></p>
        <?php endif ?>
        <p>MD5 Hash: <?= $post['filehash'] ?></p>

        <?php if (!empty($_SESSION['user_id']) && ($uploader['id'] == $_SESSION['user_id'] || is_admin($_SESSION['user_id']))) : ?>
            <a href="edit.php?post_id=<?= $post['id'] ?>">Edit Post</a>
        <?php endif ?>
        
    </div>


    <?php include '../comments/comment-view.php'; ?>
    
    <?php include '../comments/comment-form.php'; ?>


    <div class="container-md">
        <p>POTTO</p>
    </div>

    <?php include '../html-parts/footer.php'; ?>
    
</body>