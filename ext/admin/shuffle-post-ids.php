<?php
require_once '../../config.php';

session_start();

$mysqli = $_DB;

if (!isset($_SESSION['user_id']) || !is_admin($_SESSION['user_id'])) {
    header('Location: /core/users/login.php');
    exit();
}

// Disable foreign key checks
$mysqli->query("SET foreign_key_checks = 0");

// Update posts and reassign IDs
$mysqli->query("
    UPDATE posts
    JOIN (
        SELECT id AS old_id, ROW_NUMBER() OVER (ORDER BY id) AS new_id
        FROM posts
    ) AS OrderedPosts
    ON posts.id = OrderedPosts.old_id
    SET posts.id = OrderedPosts.new_id;
");

// Update post_tags based on new post IDs
$mysqli->query("
    UPDATE post_tags
    JOIN (
        SELECT id AS old_id, ROW_NUMBER() OVER (ORDER BY id) AS new_id
        FROM posts
    ) AS OrderedPosts
    ON post_tags.post_id = OrderedPosts.old_id
    SET post_tags.post_id = OrderedPosts.new_id;
");

// Update comments based on new post IDs
$mysqli->query("
    UPDATE comments
    JOIN (
        SELECT id AS old_id, ROW_NUMBER() OVER (ORDER BY id) AS new_id
        FROM posts
    ) AS OrderedPosts
    ON comments.post_id = OrderedPosts.old_id
    SET comments.post_id = OrderedPosts.new_id;
");

// Re-enable foreign key checks
$mysqli->query("SET foreign_key_checks = 1");

$maxId = $mysqli->query("SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM posts")->fetch_assoc()['next_id'];
$mysqli->query("ALTER TABLE posts AUTO_INCREMENT = $maxId");

// Redirect to main page
header('Location: main.php');
exit();
