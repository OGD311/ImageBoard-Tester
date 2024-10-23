<?php
require_once '../../config.php';

session_start();

if (! isset($_SESSION['user_id'])) {
    header('Location: ../main.php');
    exit();
}

session_destroy();



header('Location: ../../index.php');
exit;