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
        echo '<li><a onclick="add_to_search(\'' . htmlspecialchars($tag['name']) . '\')">+</a> <a onclick="add_to_search(\'-' . htmlspecialchars($tag['name']) . '\')">-</a> ' . htmlspecialchars($tag['name']) . ' (' . htmlspecialchars($tag['count']) . ')</li>';
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

<script>
    function add_to_search(tag) {
    const url = new URL(window.location.href);
    const currentSearch = url.searchParams.get('search') || '';

    // Update regex to match 'character before' + 'tag' only if not followed by word characters
    let updatedSearch = currentSearch
        .replace(new RegExp(`(?:[^\\w]|\\b)${tag}\\b(?!\\w)`, 'g'), '')
        .replace(/\s+/g, ' ') // Clean up extra spaces
        .trim(); 

    console.log(updatedSearch);

    const newSearch = updatedSearch ? `${updatedSearch} ${tag}` : tag;

    url.searchParams.set('search', newSearch.trim()); 
    console.log(newSearch);
    
    // document.location.href = url.toString();
}


</script>