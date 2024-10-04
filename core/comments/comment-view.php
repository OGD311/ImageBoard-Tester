<?php
require_once '../../config.php';

$mysqli = $_DBPATH; 
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $sql = sprintf("SELECT c.*, u.username 
    FROM comments c
    JOIN users u ON c.user_id = u.id 
    WHERE c.post_id = '%s'", htmlspecialchars($post['id']) );
    
    $result = $mysqli->query($sql);

    $comments = [];
    while ($comment = $result->fetch_assoc()) {
        $comments[] = $comment; 
    }


}


    if ($result) {

        foreach ($comments as $comment) {
            echo '<div class="post"> <p>';
            echo '<span><strong><a href="../users/user.php?user_id=' . $comment['user_id'] . '">' . htmlspecialchars($comment['username']) . ': </a></strong></span>';
            echo '<span>' . htmlspecialchars($comment['comment']) . ' - </span>';
            echo '<span>' . date("d/m/y h:i:s a", $comment['posted_at']) . '</span>';
            if (isset($_SESSION['user_id'])) {
                if ($_SESSION['user_id'] === $comment['user_id'] || is_admin($_SESSION['user_id'])) {
                echo '<span>
                        <form action="../comments/delete-comment.php" method="post" onsubmit="return confirm(\'Delete comment?\');"">
                            <input type="hidden" name="user_id" value="' . htmlspecialchars($comment['user_id']) . '">
                            <input type="hidden" name="post_id" value="' . htmlspecialchars($comment['post_id']) . '">
                            <input type="hidden" name="comment_id" value="' . htmlspecialchars($comment['id']) . '">
                            <button>Delete</button>
                        </form>
                    </span>';
                }
            }
    
            echo '</p></div>';
        }
    } else {
        echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
    }

?>
