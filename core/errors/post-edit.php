<?php
require_once '../../config.php';

$mysqli = $_DB; 

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

    <h1>Oops - could not find that post...</h1>
    <h4>If you are trying to edit your posting, check you are logged in</h4>

    <?php include '../html-parts/footer.php'; ?>
</body>
</html>