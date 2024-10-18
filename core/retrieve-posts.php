<?php
require_once '../config.php';

function get_posts($search = [], $page = 1, $count = false) {
    if ($page == 0) {
        $page = 1;
    }
    $joinTags = false;

    $mysqli = require __DIR__ . "../../storage/database.php";
    $_POSTS_PER_PAGE = $GLOBALS['_POSTS_PER_PAGE'];

    // Base SQL for posts
    $sql = "SELECT p.* FROM posts p";


    $conditions = [];

    foreach ($search as $key => $searchTerm) {
        $negation = false;
        if (strpos($searchTerm, '-') === 0) {
            $negation = true;
            $searchTerm = ltrim($searchTerm, '-');
        }

        if (str_contains($searchTerm, 'rating')) {
            preg_match('/rating\s*:\s*\'?(\S+?)\'?/', $searchTerm, $matches);
            $condition = "p.rating LIKE '" . $mysqli->real_escape_string($matches[1]) . "'";
        } elseif (str_contains($searchTerm, 'title')) {
            preg_match('/title\s*:\s*\'?(.+?)(\+|$)/', $searchTerm, $matches);
            $condition = "p.title LIKE '" . $mysqli->real_escape_string($matches[1]) . "'";
        } elseif (str_contains($searchTerm, 'user')) {
            preg_match('/user\s*:\s*\'?(.+?)(\+|$)/', $searchTerm, $matches);
            $condition = "p.user_id LIKE '" . $mysqli->real_escape_string(get_user_id($matches[1])) . "'";
        } else {
            $condition = "t.name LIKE '" . $mysqli->real_escape_string(trim($searchTerm)) . "'";
            $joinTags = true;
        }

        if ($negation) {
            $condition = str_replace('LIKE', 'NOT LIKE', $condition);
        }

        $conditions[] = $condition;
        unset($search[$key]);
    }

    if ($joinTags) {
        $sql .= " JOIN post_tags pt ON p.id = pt.post_id 
                  JOIN tags t ON pt.tag_id = t.id ";
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // Add pagination
    $sql .= " ORDER BY p.uploaded_at DESC
              LIMIT " . $_POSTS_PER_PAGE . " 
              OFFSET " . (($page - 1) * $_POSTS_PER_PAGE) . ";";

              
    // Execute the main query to get posts
    $result = $mysqli->query($sql);
    if (!$result) {
        return [];
    }

    $posts = [];
    while ($post = $result->fetch_assoc()) {
        $posts[] = $post; 
    }

    if ($count) {
        $count_sql = "SELECT COUNT(*) AS total_posts FROM posts p";

        if ($joinTags) {
            $count_sql .= " JOIN post_tags pt ON p.id = pt.post_id 
                      JOIN tags t ON pt.tag_id = t.id ";
        }
        

        if (!empty($conditions)) {
            $count_sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $count_sql .= " ;";
        
        $count_result = $mysqli->query($count_sql);
        $total_count = $count_result->fetch_assoc()['total_posts'];

        

        $mysqli->close();

        return [
            'posts' => $posts,
            'total_posts' => $total_count,
        ];
    }

  
    $mysqli->close();
    return $posts; 
}
