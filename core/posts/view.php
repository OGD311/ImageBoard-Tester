<?php

require_once '../../config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $mysqli = $_DB;

    if (isset($_GET['post_id'])) {
        $postId = (int)$_GET['post_id']; // Casting to integer for safety
    
        // Combined SQL query using LEFT JOIN
        $sql = sprintf("
            SELECT p.*, u.id AS uploader_id, u.username, u.is_admin 
            FROM posts p 
            LEFT JOIN users u ON p.user_id = u.id 
            WHERE p.id = '%s'", 
            $mysqli->real_escape_string($postId)
        );
    
        $result = $mysqli->query($sql);
    
        $post = $result->fetch_assoc();
        
    
        if (!$post) {
            header("Location: ../errors/post-view.php");
            exit();
        }

        $uploader = [
            "id" => $post['uploader_id'],
            "username" => $post['username'],
            "is_admin" => $post['is_admin']
        ];
    }

    
    
    
} else {
    header('Location: /core/main.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post <?= $post['id'] ?></title>
    <link rel="stylesheet" href="/static/css/tags.css">
    <?php include '../html-parts/header-elems.php' ?>
</head>
<body>
    <?php include '../html-parts/nav.php'; ?>

    <div class="contain">
        
        <div class="left-div">
            <?php include '../tags/tag-view.php'; ?>
            <hr>
            <h4>Details</h4>
            <div id="details" class="">
                <ul>
                    <p>Uploaded on: <br><?= date("d/m/Y", $post['uploaded_at']) ?></p>
                        
                    <?php if ($post['updated_at']): ?>
                        <p>Last updated on: <br> <?= date("d/m/Y", $post['updated_at']) ?></p>
                    <?php endif ?>
                        
                    
                    <p>File type: <?=  $post['extension'] ?></P>
                    <p>File Resolution: <br><?= $post['file_height'] . " x " . $post['file_width'] ?></p>
                    <?php if ($uploader): ?>
                        <p>Uploaded by:<br> <a href="../users/user.php?user_id=<?php echo htmlspecialchars($uploader['id']); ?>"><?= $uploader['username'] ?></a>
                        </a></p>
                    <?php endif ?>
                    <p>Rating: <?= get_rating_text($post['rating']) ?></p>
                    <p>Post ID: <?= $post['id'] ?></p>

                    <?php if (!empty($_SESSION['user_id']) && ($uploader['id'] == $_SESSION['user_id'] || is_admin($_SESSION['user_id']))) : ?>
                        <button class="btn btn-secondary" onclick="location.href='edit.php?post_id=<?= $post['id'] ?>'">Edit Post</button>

                        <form action="delete-post.php" method="post" onsubmit="return confirm('Delete Post?');">
                            <input type="hidden" name="user_id" value="<?= $uploader['id'] ?>">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <br>

                            <button  class="btn btn-danger">Delete Post</button>
                        </form>
                    <?php endif ?>

                </ul>
                
            </div>
            <hr>
        </div>

        <div class="right-div container-fluid text-center justify-content-center">
            <h1><?= $post['title'] ?></h1>
            <img id="image" class="" src="<?= '/storage/uploads/' . $post['filehash'] . '.' . $post['extension'] ?>" height="<?= $post['file_height'] ?>" width="<?= $post['file_width'] ?>" style="border-width: 1px;">
                        
            

            <div id="scalingInfo"></div>
            <select id="widthSelect">
                <option value="850">Sample (850 px)</option>
                <option value="fitWidth">Fit Width</option>
                <option value="fitHeight">Fit Height</option>
                <option value="original">Original Size</option>
            </select>
            <br>

        

            <?php include '../comments/comment-view.php'; ?>
            
            <?php include '../comments/comment-form.php'; ?>
        </div>

        

    </div>

    

    <?php include '../html-parts/footer.php'; ?>
    

    <script>
        const widthSelect = document.getElementById('widthSelect');
        const image = document.getElementById('image'); // Ensure this matches your image ID
        const scalingInfo = document.getElementById('scalingInfo');

        // Store original dimensions
        const originalWidth = <?= $post['file_width'] ?>;

        function updateScalingInfo(currentWidth) {
            const percentage = Math.min(((currentWidth / originalWidth) * 100).toFixed(0), 100);
            scalingInfo.innerHTML = `Viewing sample resized to ${percentage}% of original size.`;
        }

        widthSelect.addEventListener('change', function() {
            const option = this.value;

            switch(option) {
                case '850':
                    image.style.height = '850px';
                    image.style.width = 'auto';
                    updateScalingInfo(850);  
                case 'fitWidth':
                    image.style.width = '100%';  
                    image.style.height = 'auto';
                    scalingInfo.innerHTML = '';  
                    break;
                case 'fitHeight':
                    image.style.height = '100%';  
                    image.style.width = 'auto';
                    scalingInfo.innerHTML = '';  
                    break;
                case 'original':
                    image.style.height = '';  
                    image.style.width = ''; 
                    scalingInfo.innerHTML = '';  
                    break;
            }
        });

       
        window.onload = function() {
            image.style.height = '850px';
            image.style.width = 'auto';
            updateScalingInfo(850);
        };
    </script>



</body>