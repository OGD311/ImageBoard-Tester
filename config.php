<?php

$GLOBALS['_DB'] = require __DIR__ . "/storage/database.php";

$GLOBALS['_UPLOADPATH'] = __DIR__ . "/storage/uploads/";

$GLOBALS['_POSTS_PER_PAGE'] = 45;

$GLOBALS['_TAGS_ALL_LIMIT'] = 16;


function is_admin($user_id) {
    $mysqli = require __DIR__ . "/storage/database.php";

    $stmt = $mysqli->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();

    $result = $stmt->get_result();
    $is_admin = $result->fetch_assoc()['is_admin'];
    $stmt->close();

    $val = isset($is_admin) ? (bool)$is_admin : false;

    return $val;
}

function post_title($post_id) {
    $mysqli = require __DIR__ . "/storage/database.php";

    $stmt = $mysqli->prepare("SELECT title FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id); 
    $stmt->execute();

    $result = $stmt->get_result();
    $title = $result->fetch_assoc()['title'];
    $stmt->close();

    return $title;
}

function get_user_id($username) {
    $mysqli = require __DIR__ . "/storage/database.php";

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user_id = $result->fetch_assoc()['id'];
    $stmt->close();

    return $user_id;
}

function posts_count($column, $likes) {
    $mysqli = require __DIR__ . "/storage/database.php";

    $sql = "SELECT COUNT(*) AS total_posts FROM posts";

    if (!empty($column) && !empty($likes)) {
        $sql .= " WHERE ";
        $conditions = [];

        foreach ($likes as $like) {
            $conditions[] = "$column LIKE ?";
        }

        $sql .= implode(' AND ', $conditions);
    }

    $stmt = $mysqli->prepare($sql);

    if (!empty($column) && !empty($likes)) {
        $types = str_repeat('s', count($likes)); 
        $likeParams = array_map(function($like) {
            return "%$like%"; 
        }, $likes);
        
        $stmt->bind_param($types, ...$likeParams);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $posts_count = $result->fetch_assoc();

    return $posts_count['total_posts'];
}



function number_of_pages($column, $like) {
    $posts_per_page = $GLOBALS['_POSTS_PER_PAGE'];

    $posts_count = posts_count($column, $like);

    $number_of_pages = ceil($posts_count / $posts_per_page);

    return $number_of_pages;
}

function get_rating_text($rating_value) {
    switch ($rating_value) {
        case 0: 
            return 'Safe';
        
        case 1:
            return 'Questionable';

        case 2:
            return 'Explicit';

        default:
            return 'Explicit';
    }
}

function get_rating_value($rating_text) {
    switch (strtolower(substr($rating_text, 0, 1))) {
        case 's': 
            return 0;
        
        case 'q':
            return 1;

        case 'e':
            return 2;

        default:
            return 2;
    }
}