<?php
require_once '../../config.php';

$mysqli = $_DBPATH; 

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $sql = "UPDATE posts SET title = ?, updated_at = ? WHERE id = ? AND user_id = ?";
    

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $mysqli->error);
    }


    $title = $mysqli->real_escape_string($_POST['title']);
    $updatedAt = time();
    $postId = (int)$_POST['post_id'];
    $userId = (int)$_POST['user_id'];


    $stmt->bind_param("siii", $title, $updatedAt, $postId, $userId);


    if ($stmt->execute()) {

        header('Location: /core/posts/view.php?post_id=' . $postId);
        exit(); 
    } else {
        die("Error updating post: " . $stmt->error);
    }
} else {
    header('Location: /core/main.php');
    exit();
}
?>
