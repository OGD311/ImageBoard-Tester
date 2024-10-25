<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$mysqli = $_DB; 
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $sql = "DELETE FROM comments WHERE id = ? AND user_id = ? AND post_id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        
        $postId = (int)$_POST['post_id'];
        $userId = (int)$_POST['user_id'];
        $commentID = (int)$_POST['comment_id']; 

        $stmt->bind_param("iii", $commentID, $userId, $postId);

        if ($stmt->execute()) {
            header('Location: /core/posts/view.php?post_id=' . $postId);
            exit(); 

        } else {
            die("Error deleting comment: " . htmlspecialchars($stmt->error));
        }

        $stmt->close();
        $mysqli->close();
    } else {
        die("SQL Error: " . htmlspecialchars($mysqli->error));
    }
} else {
    header('Location: /core/main.php');
    exit();
}
