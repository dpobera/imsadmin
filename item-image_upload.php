<?php
include "php/config.php";
$id = $_GET['id'];
if (isset($_POST['upload'])) {
    // Get image name
    $image = $_FILES['image']['name'];
    // Get text
    // $image_text = mysqli_real_escape_string($db, $_POST['image_text']);

    // image file directory
    $target = "images/" . basename($image);

    $sql = "INSERT INTO images (image, image_text,product_id) VALUES ('$image', ' ', '$id')";
    // execute query
    mysqli_query($db, $sql);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }
}
