<?php
require '../config.php';

$mysqli = $_DBPATH; 
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
    
    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $mysqli->error);
    }

    $postId = (int)$_POST['post_id'];
    $userId = (int)$_POST['user_id'];


    $stmt->bind_param("ii", $postId, $userId);


    if ($stmt->execute()) {

        header('Location: http://localhost:8080/core/index.php');
        exit(); 
    } else {
        die("Error deleting post: " . $stmt->error);
    }
} else {
    header('Location: http://localhost:8080/core/index.php');
    exit();
}
?>
