<?php
require_once '../../config.php';

session_start();

$mysqli = $_DBPATH;

if (isset($_SESSION['user_id'])) {

    $sql = "SELECT * FROM users WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

} else {
    header('Location: /core/users/login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <?php include '../html-parts/header-elems.php' ?>
</head>
<body>
    <?php include '../html-parts/nav.php'; ?>

    <form class="container-flex" action="upload-post.php" method="post" enctype="multipart/form-data">

        <!-- <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> -->
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
        <label for="title">Post title</label><br>
        <input type="text" id="title" name="title" value="">
        <br>
        <label for="image">Image file</label><br>
        <input type="file" id="image" name="image" onchange="updateTitle();">
        <br>
        <button>Upload</button>

    </form>


    <script>
        function updateTitle() {
            const files = event.target.files;
            const fileName = files[0].name.replace(/\.[^/.]+$/, "");

            document.getElementById('title').value = fileName;
        }
    </script>

    <?php include '../html-parts/footer.php'; ?>
    
</body>
</html>