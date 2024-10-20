<?php 
function compress($source, $destination) {
    $maxWidth = 800;
    $maxHeight = 640;
    $quality = 50;

    $info = getimagesize($source);

    if ($info === false) {
        die("Error: Invalid image file.");
    }

    if (!is_dir(dirname($destination))) {
        die("Error: Destination folder does not exist.");
    }

    // Create image from source
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    } else {
        die("Error: Unsupported image type.");
    }

    // Get original dimensions
    $width = imagesx($image);
    $height = imagesy($image);

    // Calculate new dimensions
    $aspectRatio = $width / $height;
    if ($width > $maxWidth || $height > $maxHeight) {
        if ($aspectRatio > 1) {
            $newWidth = $maxWidth;
            $newHeight = $maxWidth / $aspectRatio;
        } else {
            $newHeight = $maxHeight;
            $newWidth = $maxHeight * $aspectRatio;
        }
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    $newWidth = round($newWidth);
    $newHeight = round($newHeight);

    // Create a new blank image with the new dimensions
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    // Preserve transparency for PNG and GIF images
    if ($info['mime'] == 'image/png' || $info['mime'] == 'image/gif') {
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
        imagefill($newImage, 0, 0, $transparent);
    }

    // Resize the original image into the new image
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save the compressed image to the destination
    if (!imagejpeg($newImage, $destination, $quality)) {
        die("Error: Failed to write image to destination. Check permissions and path.");
    }

    // Free up memory
    imagedestroy($image);
    imagedestroy($newImage);

    return $destination;
}
?>
