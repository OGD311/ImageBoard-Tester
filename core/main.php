<?php
require_once '../config.php';

session_start();

$mysqli = $_DBPATH;



if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET['search'])) {
        $like = htmlspecialchars($_GET['search']);
    } else {
        $like = '';
    }

    $number_of_posts = (int)number_of_pages($like);

    if (isset($_GET['page'])) {
        $current_page_number = $_GET['page'];

        if ($current_page_number > $number_of_posts) {
            header('Location: main.php?page='. $number_of_posts .'');
        }
    } else {
        $current_page_number = 1;
    }

    

    if (isset($_GET['order_by'])) {
        $order_by = $_GET['order_by'];
        switch ($order_by) {
            case 'upload-asc':
                $order_by = 'uploaded_at asc';
                break;
            case 'upload-desc':
                $order_by = 'uploaded_at desc';
                break;

            case 'updated-asc':
                $order_by = 'updated_at asc';
                break;
            case 'updated-desc':
                $order_by = 'updated_at desc';
                break;


            case 'comments-asc':
                $order_by = 'comment_count asc';
                break;
            case 'comments-desc':
                $order_by = 'comment_count desc';
                break;

            default:
            $order_by = 'uploaded_at desc';
        }
    } else {
        $order_by = 'uploaded_at desc';
    }


    $sql = "SELECT id, title, filehash, extension, comment_count 
        FROM posts 
        WHERE title LIKE '%" . $like . "%' 
        ORDER BY " . $order_by . " 
        LIMIT " . $_POSTS_PER_PAGE . " 
        OFFSET " . (($current_page_number - 1) * $_POSTS_PER_PAGE) . ";";
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

        
        <div id="posts" class="container-fluid text-center row justify-content-center">
        <h1>Latest Posts</h1>
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
                            <p style="margin: 0;">'. $post['comment_count']. '</p>
                        </span>
                        </div>';
                    }
                } else {
                    echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
                }
                if ($current_page_number == $number_of_posts) {
                    echo "<p>You've reached the end!<br>If you got here from just scrolling I would be concerned...<br><a href='main.php?page=1'>Go Home</a></p>";
                }
            ?>
        </div>
        <br>

        <form name="order_by">
            <label for="sort-options">Choose an option:</label>
            <select id="sort-options" onchange="sort_posts(this.value, <?= $like ?>)">
                <option value="upload-desc" <?= ($_GET['order_by'] == 'upload-desc') ? 'selected' : '' ?>>Upload date ↑</option>
                <option value="upload-asc" <?= ($_GET['order_by'] == 'upload-asc') ? 'selected' : '' ?>>Upload date ↓</option>

                <option value="updated-desc" <?= ($_GET['order_by'] == 'updated-desc') ? 'selected' : '' ?>>Updated at ↑</option>
                <option value="updated-asc" <?= ($_GET['order_by'] == 'updated-asc') ? 'selected' : '' ?>>Updated at ↓</option>

                <option value="comments-desc" <?= ($_GET['order_by'] == 'comments-desc') ? 'selected' : '' ?>>Comments ↑</option>
                <option value="comments-asc" <?= ($_GET['order_by'] == 'comments-asc') ? 'selected' : '' ?>>Comments ↓</option>
            </select>
        </form>

        <div id="pages-buttons" class="container-fluid text-center row justify-content-center">
            
            <?php

                $current_page_number = max(1, $current_page_number); 

                if ($current_page_number > $number_of_posts) {
                    echo "<span>
                    <strong> No posts to display! </strong>
                    <p>Why don't you <a href='posts/upload.php'>upload</a> one?</p>";

                } else if ($current_page_number == $number_of_posts && $current_page_number == 1) {
                    echo '<span>
                    <strong> ' . $current_page_number . ' </strong>';
                    
                } else if ($current_page_number == $number_of_posts) {
                    echo '<span>
                    <a href="main.php?page=1">1</a> 
                    ... <a href="main.php?page=' . ($current_page_number - 1) . '&search='. $like .'&order_by='. $order_by .'"><<</a>
                    <strong> ' . $current_page_number . ' </strong>';
                    

                } else if ($current_page_number == 1) {
                    echo '<span>
                    <strong> ' . $current_page_number .  '</strong>
                    <a href="main.php?page=' . ($current_page_number + 1) . '&search='. $like .'&order_by='. $order_by .'">>></a>
                    ... <a href="main.php?page=' . ($number_of_posts) . '">'. ($number_of_posts) .'</a>';

                } else {
                    echo '<span>
                    <a href="main.php?page=1">1</a> 
                    ... <a href="main.php?page=' . ($current_page_number - 1) . '&search='. $like .'&order_by='. $order_by .'"><<</a>
                    <strong> ' . $current_page_number . ' </strong>
                    <a href="main.php?page=' . ($current_page_number + 1) . '&search='. $like .'&order_by='. $order_by .'">>></a>
                    ... <a href="main.php?page=' . ($number_of_posts) . '">'. ($number_of_posts) .'</a>';

                }

                // Select a random post
                $sql = "SELECT id FROM posts ORDER BY RAND() LIMIT 1;";
                $result = $mysqli->query($sql);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo '  <a href="/core/posts/view.php?post_id=' . $row['id'] . '">Random Post</a>';
                } 
                               

                echo '</span>';
            ?>

        </div>

        <?php include 'html-parts/footer.php'; ?>
    </body>

    <script>
        function sort_posts(orderValue, searchValue='') {

            document.location.href = ("main.php?order_by=" + orderValue + "&search=" + searchValue);

        }
    </script>
</html>