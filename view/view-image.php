<style>
    img {
        width: auto;
        height: 20cm;
    }
</style>

<?php
// Get images from the database
include '../php/config.php';
$id = $_GET['id'];
$query = $db->query("SELECT * FROM images WHERE id= $id ");

if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $image = file_get_contents('D:/images/ITEMS/' . $row["image"]);
        $image_codes = base64_encode($image);
        $imageId = $row['id'];
    }
}
echo '<img src="data:image/jpg;charset=utf-8;base64,' . $image_codes . '"  alt=" No Image Shown ">


';
