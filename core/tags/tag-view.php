<?php
require_once '../../config.php';

$mysqli = $_DBPATH; 
if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $sql = sprintf("SELECT t.name, t.count
    FROM tags t
    JOIN post_tags pt ON t.id = pt.tag_id
    WHERE pt.post_id = '%s'", htmlspecialchars($post['id']) );
    
    $result = $mysqli->query($sql);

    $tags = [];
    while ($tag = $result->fetch_assoc()) {
        $tags[] = $tag; 
    }

    


}

if ($result) {

    echo '<aside>';

    foreach ($tags as $tag) {
        echo '<div class="tag"> <p>';
        echo '<span>' . htmlspecialchars($tag['name']) . ' (' . htmlspecialchars($tag['count']) . ') </a></strong></span>';
        echo '</p></div>';
    }
    
    echo '</aside>';


    if ((count($tags)) == 0) {
        echo '<p>No tags to display!</p>';
    }
} else {
    echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
}

?>