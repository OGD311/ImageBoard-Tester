<?php
require_once '../../config.php';


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("POST request method required");
}

if (empty($_FILES)) {
    exit('$_FILES is empty - is file_uploads enabled in php.ini?');
}

if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {

    switch ($_FILES["image"]["error"]) {
        case UPLOAD_ERR_PARTIAL:
            exit("File only partially uploaded");
            break;
        case UPLOAD_ERR_NO_FILE:
            exit("No file was uploaded");
            break;
        case UPLOAD_ERR_EXTENSION:
            exit("File upload stopped by a PHP extension");
            break;
        case UPLOAD_ERR_FORM_SIZE:
            exit("File exceeds MAX_FILE_SIZE");
            break;
        case UPLOAD_ERR_INI_SIZE:
            exit("File exceeds upload_max_filesize in php.ini");
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            exit("Temporary folder not found");
            break;
        case UPLOAD_ERR_CANT_WRITE:
            exit("Failed to write file");
            break;
        default:
            exit("Upload error");
            break;

    }

}


if ($_FILES["image"]["size"] > 8388608 ) {
    exit("File too large (max 1MB)");
}

$finfo = new finfo(FILEINFO_MIME_TYPE);

$mime_type = $finfo->file($_FILES["image"]["tmp_name"]);


$mime_types = ["image/gif", "image/png", "image/jpeg"];

if ( ! in_array($_FILES["image"]["type"], $mime_types)) {
    exit("Invalid file type");
}

// Get details of file (put here as putting after filemove conflicts)
list($file_width, $file_height, $type, $attr) = getimagesize($_FILES["image"]["tmp_name"]); 


// Create safe path and hash for file
$pathinfo = pathinfo($_FILES["image"]["name"]);

$base = $pathinfo["filename"];

$base = preg_replace("/[^\w-]/", "_", $base);


$filename = $base . "." . $pathinfo['extension'];

$filehash = md5($_FILES["image"]["name"]);

$destination = $_UPLOADPATH . $filehash . "." . $pathinfo['extension'];

if ( ! move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
    exit("Can't move uploaded file");
}

// Other variables needed for SQL upload
$title = $_POST['title'];

$user_id = $_POST['user_id'];

$extension = $pathinfo['extension'];

$filesize = $_FILES["image"]["size"];

$uploaded_at = time();

// Upload to SQL

$mysqli = $_DBPATH;

$sql = "INSERT INTO posts (title, user_id, extension, filesize, filehash, file_height, file_width, uploaded_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (! $stmt->prepare($sql)) {
    die("SQL Error " . $mysqli->error);
}

$stmt->bind_param('sisisiis' , $title, $user_id, $extension, $filesize, $filehash, $file_height, $file_width, $uploaded_at);

$stmt->execute();

// Redirect to new post

$sql = sprintf("SELECT id FROM posts WHERE filehash = '%s'", $filehash);

$result = $mysqli->query($sql);

$postID = ($result->fetch_assoc())['id'];


header('Location: /core/posts/view.php?post_id=' . $postID);
exit();