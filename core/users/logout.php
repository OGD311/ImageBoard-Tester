<?php
require_once '../../config.php';

if (! isset($_SESSION['user_id'])) {
    header('Location: ../../main.php');
    exit();
}

session_start();

session_destroy();

header('Location: ../main.php');

exit;