<?php
require_once '../config.php';


function get_posts($search = [], $rating = null, $order_by = 'uploaded_at desc', $page = 1) {
    $mysqli = require __DIR__ . "../../storage/database.php";
    $_POSTS_PER_PAGE = $GLOBALS['_POSTS_PER_PAGE'];

    $sql = "SELECT p.id, p.title, p.filehash, p.extension, p.rating, p.comment_count 
            FROM posts p ";

    if (!empty($search)) {
        $sql .= "JOIN post_tags pt ON p.id = pt.post_id 
                  JOIN tags t ON pt.tag_id = t.id ";
    }

    $conditions = [];
    if (isset($rating)) {
        $conditions[] = "p.rating LIKE '" . $mysqli->real_escape_string($rating) . "'";
    }
    
    foreach ($search as $searchTerm) {
        $conditions[] = "t.name LIKE '" . $mysqli->real_escape_string(trim($searchTerm)) . "'";
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $sql .= " ORDER BY " . $order_by . " 
              LIMIT " . $_POSTS_PER_PAGE . " 
              OFFSET " . (($page - 1) * $_POSTS_PER_PAGE) . ";";

    $result = $mysqli->query($sql);
    if (!$result) {
        return [];
    }

    $mysqli->close();
    
    $posts = [];
    while ($post = $result->fetch_assoc()) {
        $posts[] = $post; 
    }

    return $posts; // Return the fetched posts
}
