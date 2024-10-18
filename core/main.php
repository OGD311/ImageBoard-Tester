<?php
require_once '../config.php';
require_once '../core/retrieve-posts.php';
session_start();

$mysqli = $_DB;



if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET['search'])) {
        $searchList = (explode('+', $_GET['search']));
    } else {
        $searchList = [];
    }
  

    if (isset($_GET['order_by'])) {
        $order_by = $_GET['order_by'];
        switch ($order_by) {
            case 'upload-asc':
                $order_by_statement = 'uploaded_at asc';
                break;
            case 'upload-desc':
                $order_by_statement = 'uploaded_at desc';
                break;

            case 'updated-asc':
                $order_by_statement = 'updated_at asc';
                break;
            case 'updated-desc':
                $order_by_statement = 'updated_at desc';
                break;

            case 'comments-asc':
                $order_by_statement = 'comment_count asc';
                break;
            case 'comments-desc':
                $order_by_statement = 'comment_count desc';
                break;

            default:
            $order_by_statement = 'uploaded_at desc';
        }
    } else {
        $order_by_statement = 'uploaded_at desc';
        $order_by = 'upload-desc';
    }

    if (isset($_GET['page'])) {
        $current_page_number = intval($_GET['page']);
    } else {
        $current_page_number = 1;
    }
    
    $result = get_posts($searchList, $current_page_number, true); 

    $posts = $result['posts'];      
    $total_posts = $result['total_posts'];


    $number_of_pages = number_of_pages($total_posts);

    if ($current_page_number > $number_of_pages) {
        header('Location: main.php?page='. $number_of_pages .'&search=' . $_GET['search']);
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
        <link rel="stylesheet" href="/static/css/ratings.css">
        <link rel="stylesheet" href="/static/css/tags.css">
        <meta charset="UTF-8">
    </head>

    <body>
        <?php include 'html-parts/nav.php'; ?>
        
        <br>

        <div id="headings" class="contain container-fluid d-flex justify-content-between align-items-center">
            
            <h1 class="mb-0">Latest Posts</h1>

            <form name="order_by" class="d-flex">
                <label for="sort-options">Sort posts by:</label>
                <select id="sort-options" style="margin-left: 10px;" onchange="sort_posts(this.value, <?= join("+", $searchList) ?>)">
                    <option value="upload-desc" <?= ($order_by == 'upload-desc') ? 'selected' : '' ?>>Upload date ↑</option>
                    <option value="upload-asc" <?= ($order_by == 'upload-asc') ? 'selected' : '' ?>>Upload date ↓</option>

                    <option value="updated-desc" <?= ($order_by == 'updated-desc') ? 'selected' : '' ?>>Updated at ↑</option>
                    <option value="updated-asc" <?= ($order_by == 'updated-asc') ? 'selected' : '' ?>>Updated at ↓</option>

                    <option value="comments-desc" <?= ($order_by == 'comments-desc') ? 'selected' : '' ?>>Comments ↑</option>
                    <option value="comments-asc" <?= ($order_by == 'comments-asc') ? 'selected' : '' ?>>Comments ↓</option>
                </select>
            </form>

        </div>
        <br>

        <div class='contain'>

        <div class="left-div">
            <?php include 'tags/tag-all.php'; ?>
        </div>


        <div id="posts" class=" right-div container-main text-center row justify-content-center">
            <?php
                if ($result) {
                    foreach ($posts as $post) {

                        $apply_blur = '';

                        if ($post['rating'] == 2) {
                            $apply_blur = 'blur-explicit';
                        }

                        echo '
                        <div class="card justify-content-center border-2 m-1" style="width: 12rem;">
                        <a href="/core/posts/view.php?post_id=' . $post['id'] . '">
                        <img class="card-img-top ' . $apply_blur . '" src="/storage/uploads/' . htmlspecialchars($post['filehash'] . "." . $post['extension']) . '" alt="Post Image" width=200 height=200 style="object-fit: contain; padding-top: 10px; padding-bottom: 2px;">
                        </a>
                        <span style="display: flex; align-items: center; gap: 10px;">
                            <img src="/static/svg/comment-icon.svg" alt="Description of the icon" width="16" height="16">
                            <p style="margin: 0;">'. $post['comment_count'] . '</p>
                            <p style="margin: 0;" class="rating-' . $post['rating'] . '">' . substr(get_rating_text($post['rating']), 0, 1) . '</p>
                        </span>
                        </div>';
                    }
                } else {
                    echo "<p>Error: " . htmlspecialchars($mysqli->error) . "</p>";
                }
                if ($current_page_number == $number_of_pages && ($total_posts > 0)) {
                    echo "<p>You've reached the end!<br>If you got here from just scrolling I would be concerned...<br><a href='main.php?page=1'>Go Home</a></p>";
                }
            ?>
        
        
        <br>

        <div id="pages-buttons" class="container-fluid text-center row justify-content-center">
            
            <?php

                $current_page_number = max(1, $current_page_number); 

                if ($current_page_number > $number_of_pages) {
                    echo "<span>
                    <strong> No posts to display! </strong>
                    <p>Why don't you <a href='posts/upload.php'>upload</a> one?</p>";

                } else if ($current_page_number == $number_of_pages && $current_page_number == 1) {
                    echo '<span>
                    <strong> ' . $current_page_number . ' </strong>';
                    
                } else if ($current_page_number == $number_of_pages) {
                    echo '<span>
                    <a href="main.php?page=1">1</a> 
                    ... <a href="main.php?page=' . ($current_page_number - 1) . '&search='. join("+", $searchList) .'&order_by='. $order_by .'"><<</a>
                    <strong> ' . $current_page_number . ' </strong>';
                    

                } else if ($current_page_number == 1) {
                    echo '<span>
                    <strong> ' . $current_page_number .  '</strong>
                    <a href="main.php?page=' . ($current_page_number + 1) . '&search='. join("+", $searchList) .'&order_by='. $order_by .'">>></a>
                    ... <a href="main.php?page=' . ($number_of_pages) . '">'. ($number_of_pages) .'</a>';

                } else {
                    echo '<span>
                    <a href="main.php?page=1">1</a> 
                    ... <a href="main.php?page=' . ($current_page_number - 1) . '&search='. join("+", $searchList) .'&order_by='. $order_by .'"><<</a>
                    <strong> ' . $current_page_number . ' </strong>
                    <a href="main.php?page=' . ($current_page_number + 1) . '&search='. join("+", $searchList) .'&order_by='. $order_by .'">>></a>
                    ... <a href="main.php?page=' . ($number_of_pages) . '">'. ($number_of_pages) .'</a>';

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

        </div>

        
        </div>

        <?php include 'html-parts/footer.php'; ?>
    </body>

    <script>
        function sort_posts(orderValue, searchValue = '') {
            const url = new URL(window.location.href);
            
            // Set or replace the order_by parameter
            url.searchParams.set('order_by', orderValue);
            
            // Set the search parameter if provided
            if (searchValue) {
                url.searchParams.set('search', searchValue);
            } else {
                url.searchParams.delete('search'); // Remove if no search value is provided
            }

            // Redirect to the updated URL
            document.location.href = url.toString();
        }
    </script>
</html>