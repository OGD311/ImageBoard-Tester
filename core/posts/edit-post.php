<?php
require_once '../../config.php';

$mysqli = $_DB; 

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $sql = "UPDATE posts SET title = ?, rating = ?, updated_at = ? WHERE id = ? AND user_id = ?";
    

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $mysqli->error);
    }


    $title = $mysqli->real_escape_string($_POST['title']);
    $rating = $mysqli->real_escape_string($_POST['rating']);

    if (! is_numeric($rating) && $rating >= 0 && $rating <= 2) {
        die('Please enter a valid rating');
    }

    $updatedAt = time();
    $postId = (int)$_POST['post_id'];
    $userId = (int)$_POST['user_id'];


    $stmt->bind_param("siiii", $title, $rating, $updatedAt, $postId, $userId);


    if ($stmt->execute()) {
        $mysqli->close();
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
