<?php
require_once '../config.php';

$mysqli = $_DB; 
if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $sql = sprintf("SELECT name, count
    FROM tags
    LIMIT " . $_TAGS_ALL_LIMIT . "");
    
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
        echo '<li><span><a id="addTag" onclick="add_to_search(\'' . htmlspecialchars($tag['name']) . '\', true)">+</a> <a id="removeTag" onclick="add_to_search(\'-' . htmlspecialchars($tag['name']) . '\', false)">-</a></span> ' . htmlspecialchars($tag['name']) . ' (' . htmlspecialchars($tag['count']) . ')</li>';
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
