<?php

$GLOBALS['_DBPATH'] = require __DIR__ . "\storage\database.php";

$GLOBALS['_UPLOADPATH'] = __DIR__ . "/storage/uploads/";



function is_admin($user_id) {

    $mysqli = require __DIR__ . "\storage\database.php";

    $sql = sprintf("SELECT is_admin FROM users WHERE id = '%s'", $user_id);

    $result = $mysqli->query($sql);

    $is_admin = ($result->fetch_assoc())['is_admin'];

    return $is_admin;
}

function post_title($post_id) {
    $mysqli = require __DIR__ . "\storage\database.php";

    $sql = sprintf("SELECT title FROM posts WHERE id = '%s'", $post_id);

    $result = $mysqli->query($sql);

    $title = ($result->fetch_assoc())['title'];

    return $title;
}

function get_user_id($username) {
    $mysqli = require __DIR__ . "\storage\database.php";

    $sql = sprintf("SELECT id FROM users WHERE username = '%s'", $username);

    $result = $mysqli->query($sql);

    $user_id = ($result->fetch_assoc())['id'];

    return $user_id;
}