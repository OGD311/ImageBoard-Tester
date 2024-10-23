<?php
require_once '../../config.php';

session_start();

$mysqli = $_DB;

if (! isset($_SESSION['user_id']) && !is_admin($_SESSION['user_id'])) {
    header('Location: /core/users/login.php');
    exit();
}

// Loop 1 million times
for ($i = 1; $i <= 1000000; $i++) {
    // Prepare the SQL statement with incremented titles
    $sql = "INSERT INTO `posts` (`id`, `title`, `user_id`, `extension`, `filesize`, `filehash`, `file_height`, `file_width`, `rating`, `comment_count`, `uploaded_at`, `updated_at`) 
            VALUES (NULL, 'test$i', '1', 'jpeg', '1234', '0efebf182ef7bc93b535ad00735ab097', '133', '133', '2', '0', " . time() . ", NULL);\n";
    
    $stmt = $mysqli->stmt_init();
    
    if (! $stmt->prepare($sql)) {
        die("SQL Error " . $mysqli->error);
    }
    
    $stmt->execute();

    $sql = "INSERT INTO `tags` (`id`, `name`, `count`, `created_at`) 
        VALUES (NULL, 'test$i', '0', " . time() . ");\n";

    
    $stmt = $mysqli->stmt_init();
    
    if (! $stmt->prepare($sql)) {
        die("SQL Error " . $mysqli->error);
    }
    
    $stmt->execute();

    $sql = "INSERT INTO post_tags (post_id, tag_id)
        VALUES (FLOOR(1 + RAND() * 20000), FLOOR(1 + RAND() * 15000));\n";

    
    $stmt = $mysqli->stmt_init();
    
    if (! $stmt->prepare($sql)) {
        die("SQL Error " . $mysqli->error);
    }
    
    $stmt->execute();
}





echo "SQL file generated successfully!";
?>
