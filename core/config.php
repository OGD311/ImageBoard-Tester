<?php

$GLOBALS['_DBPATH'] = require dirname(__DIR__, 1) . "\storage\database.php";

$GLOBALS['_UPLOADPATH'] = dirname(__DIR__, 1) . "/storage/uploads/";



function is_admin($user_id) {

    $mysqli = require dirname(__DIR__, 1) . "\storage\database.php";

    $sql = sprintf("SELECT is_admin FROM users WHERE id = '%s'", $user_id);

    $result = $mysqli->query($sql);

    $is_admin = ($result->fetch_assoc())['is_admin'];

    return $is_admin;
}