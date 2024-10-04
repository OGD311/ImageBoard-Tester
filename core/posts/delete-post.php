<?php
require_once '../../config.php';

$mysqli = $_DBPATH; 
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $postId = (int)$_POST['post_id'];
    $userId = (int)$_POST['user_id'];

    $mysqli->begin_transaction();

    try {
        $deleteCommentsSql = "DELETE FROM comments WHERE post_id = ?";
        $stmtComments = $mysqli->prepare($deleteCommentsSql);
        $stmtComments->bind_param("i", $postId);
        $stmtComments->execute();

        $deletePostSql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
        $stmtPost = $mysqli->prepare($deletePostSql);
        $stmtPost->bind_param("ii", $postId, $userId);
        $stmtPost->execute();

        $mysqli->commit();

        header('Location: http://localhost:8080/core/index.php');
        exit(); 

    } catch (mysqli_sql_exception $exception) {
        $mysqli->rollback();
        die("Error deleting post or comments: " . htmlspecialchars($exception->getMessage()));
    
    }
} else {
    header('Location: http://localhost:8080/core/index.php');
    exit();
}
?>
