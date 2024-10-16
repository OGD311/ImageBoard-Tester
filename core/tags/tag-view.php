<?php
require_once '../../config.php';

$mysqli = $_DB; 
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

    echo '<h4>Tags</h4>';

    echo '<ul>';
    foreach ($tags as $tag) {
        echo '<div class="tag"> <p>';
        echo '<li>' . htmlspecialchars($tag['name']) . ' (' . htmlspecialchars($tag['count']) . ')</li>';
        echo '</p></div>';
    }


    if ((count($tags)) == 0) {
        echo '<p>No tags to display!</p>';
    }

    echo '</ul>';

} else {
    echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
}

?>