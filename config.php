<?php

$GLOBALS['_DBPATH'] = require __DIR__ . "\storage\database.php";

$GLOBALS['_UPLOADPATH'] = __DIR__ . "/storage/uploads/";

$GLOBALS['_POSTS_PER_PAGE'] = 32;

function is_admin($user_id) {
    $mysqli = require __DIR__ . "\storage\database.php";

    $stmt = $mysqli->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();

    $result = $stmt->get_result();
    $is_admin = $result->fetch_assoc()['is_admin'];
    $stmt->close();

    return $is_admin;
}

function post_title($post_id) {
    $mysqli = require __DIR__ . "\storage\database.php";

    $stmt = $mysqli->prepare("SELECT title FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id); 
    $stmt->execute();

    $result = $stmt->get_result();
    $title = $result->fetch_assoc()['title'];
    $stmt->close();

    return $title;
}

function get_user_id($username) {
    $mysqli = require __DIR__ . "\storage\database.php";

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user_id = $result->fetch_assoc()['id'];
    $stmt->close();

    return $user_id;
}

function posts_count() {
    $mysqli = require __DIR__ . "\storage\database.php";

    $stmt = $mysqli->prepare("SELECT COUNT(*) AS total_posts FROM posts");
    $stmt->execute();

    $result = $stmt->get_result();
    $posts_count = $result->fetch_assoc();
    $stmt->close();

    return $posts_count['total_posts'];
}

function number_of_pages() {
    $posts_per_page = $GLOBALS['_POSTS_PER_PAGE'];

    $posts_count = posts_count();

    $number_of_pages = ceil($posts_count / $posts_per_page);

    return $number_of_pages;
}