<?php
require_once '../../config.php';

$mysqli = $_DB;

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
}





echo "SQL file generated successfully!";
?>
