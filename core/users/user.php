<?php

require_once '../config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $mysqli = $_DBPATH;

    if (isset($_GET['user_id'])) {
        $accountId = (int)$_GET['user_id']; 
    
        $userQuery = sprintf("
        SELECT username 
        FROM users 
        WHERE id = '%s'", 
        $mysqli->real_escape_string($accountId));
     
    
    
        $userResult = $mysqli->query($userQuery);
        $userData = $userResult->fetch_assoc();
        

        $postsQuery = sprintf("
            SELECT p.* 
            FROM posts p 
            WHERE p.user_id = '%s' 
            ORDER BY p.uploaded_at DESC", 
            $mysqli->real_escape_string($accountId)
        );
        
        $postsResult = $mysqli->query($postsQuery);
        $postsData = [];
        while ($post = $postsResult->fetch_assoc()) {
            $postsData[] = $post;
        }
        

        $commentsData = [];
        $commentsQuery = sprintf("
            SELECT c.* 
            FROM comments c 
            WHERE  c.user_id = '%s' 
            ORDER BY c.posted_at DESC", 
            $mysqli->real_escape_string($accountId)
        );
    
        $commentsResult = $mysqli->query($commentsQuery);
        while ($comment = $commentsResult->fetch_assoc()) {
            $commentsData[] = $comment;
        }
        
    } else {
        header("Location: ../index.php");
        exit();
    }
    

} else {
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $userData['username'] ?>'s profile</title>
</head>
<body>
    <?php include '../html-parts/nav.php'; ?>

    <h1><?= $userData['username'] ?>'s profile</h1>

    <h2><?= $userData['username'] ?>'s latest Posts</h2>
        
        <?php

            if ($postsData) {
                foreach ($postsData as $post) {
                    echo '<div class="post">';
                    echo '<a href="/core/posts/view.php?post_id=' . $post['id'] . '">';
                    echo '<img src="/storage/uploads/' . htmlspecialchars($post['filehash'] . "." . $post['extension']) . '" alt="Post Image" width="300" height="300">';
                    echo '</a></div>';
                }

            } elseif (count($postsData) === 0) {
                echo "<p>User has no posts yet!</p>";
            } else {
                echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
            }

            
        ?>

    <h2><?= $userData['username'] ?>'s latest Comments</h2>

        <?php
            if ($commentsData) {

                foreach ($commentsData as $comment) {
                    echo "<p><strong>" . htmlspecialchars($comment['comment']) . "</strong> on <a href='/core/posts/view.php?post_id=" . htmlspecialchars($comment['post_id']) . "'>" . "'" . post_title($comment['post_id']) . "'" ."</a> at "  . date("d/m/y h:i:s a", $comment['posted_at']) . "</a></p>";
                }

            } elseif (count($commentsData) === 0) {
                echo "<p>User has no comments yet!</p>";
            } else {
                echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
            }
        ?>
    
</body>