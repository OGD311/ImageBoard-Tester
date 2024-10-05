<?php
require_once '../../config.php';

$mysqli = $_DBPATH; 

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oops...</title>
    <?php include '../html-parts/header-elems.php' ?>
</head>
<body>
    <?php include '../html-parts/nav.php'; ?>

    <h1>Oops - could not find that user...</h1>
    <h4>Check your user id if you entered it manually</h4>

    <?php include '../html-parts/footer.php'; ?>
</body>
</html>