<?php
require_once '../config.php';

session_start();


if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET['page'])) {
        $current_page_number = $_GET['page'];

        if ($current_page_number > number_of_pages()) {
            header('Location: main.php?page='. number_of_pages() .'');
        }
    } else {
        $current_page_number = 1;
    }


    $mysqli = $_DBPATH;

    if (isset($_SESSION['user_id'])) {

        $sql = "SELECT username FROM users WHERE id = {$_SESSION['user_id']}";

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();

    }

    $sql = "SELECT id, title, filehash, extension FROM posts ORDER BY uploaded_at DESC LIMIT " . ($_POSTS_PER_PAGE) . " OFFSET " . (($current_page_number-1) * $_POSTS_PER_PAGE) . ";";


    $result = $mysqli->query($sql);

    $posts = [];
    while ($post = $result->fetch_assoc()) {
        $posts[] = $post; 
    }

} else {
    header("Location: main.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Posts</title>
        <?php include 'html-parts/header-elems.php' ?>
        <meta charset="UTF-8">
    </head>

    <body>
        <?php include 'html-parts/nav.php'; ?>

        <h1>Latest Posts</h1>
        <div id="posts" class="container-fluid text-center row justify-content-center">
            <?php
                if ($result) {
                    foreach ($posts as $post) {
                        echo '
                        <div class="card justify-content-center border-2 m-1 " style="width: 12rem;">
                        <a href="/core/posts/view.php?post_id=' . $post['id'] . '">
                        <img class="card-img-top" src="/storage/uploads/' . htmlspecialchars($post['filehash'] . "." . $post['extension']) . '" alt="Post Image" width=200 height=200 style="object-fit: contain;">
                        </a>
                        <span style="display: flex; align-items: center; gap: 10px;">
                            <img src="static/svg/comment-icon.svg" alt="Description of the icon" width="16" height="16">
                            <p style="margin: 0;">'. comment_count($post['id']). '</p>
                        </span>
                        </div>';
                    }
                } else {
                    echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
                }
                if ($current_page_number == (int)number_of_pages()) {
                    echo "<p>You've reached the end!<br>If you got here from just scrolling I would be concerned...<br><a href='main.php?page=1'>Go Home</a></p>";
                }
            ?>
        </div>
        <br>

        <div id="pages-buttons" class="container-fluid text-center row justify-content-center">
            
            <?php

                $current_page_number = max(1, $current_page_number); 

                if ($current_page_number > (int)number_of_pages()) {
                    echo "<span>
                    <strong> No posts to display! </strong>
                    <p>Why don't you <a href='posts/upload.php'>upload</a> one?</p>
                    </span>";

                } else if ($current_page_number == (int)number_of_pages() && $current_page_number == 1) {
                    echo '<span>
                    <strong> ' . $current_page_number . ' </strong>
                    </span>';
                    
                } else if ($current_page_number == (int)number_of_pages()) {
                    echo '<span>
                    <a href="main.php?page=1">1</a> 
                    ... <a href="main.php?page=' . ($current_page_number - 1) . '"><<</a>
                    <strong> ' . $current_page_number . ' </strong>
                    </span>';

                } else if ($current_page_number == 1) {
                    echo '<span>
                    <strong> ' . $current_page_number .  '</strong>
                    <a href="main.php?page=' . ($current_page_number + 1) . '">>></a>
                    ... <a href="main.php?page=' . ((int)number_of_pages()) . '">'. ((int)number_of_pages()) .'</a>
                    </span> ';

                } else {
                    echo '<span>
                    <a href="main.php?page=1">1</a> 
                    ... <a href="main.php?page=' . ($current_page_number - 1) . '"><<</a>
                    <strong> ' . $current_page_number . ' </strong>
                    <a href="main.php?page=' . ($current_page_number + 1) . '">>></a>
                    ... <a href="main.php?page=' . ((int)number_of_pages()) . '">'. ((int)number_of_pages()) .'</a> 
                    </span> ';

                }

                               

                
            ?>

        </div>

        <?php include 'html-parts/footer.php'; ?>
    </body>

</html>