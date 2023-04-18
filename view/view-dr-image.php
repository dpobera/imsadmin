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
$query = $db->query("SELECT * FROM dr_image WHERE id= $id ");

if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $imageURL = '../images/dr/' . $row["image"];
        $imageId = $row['id'];
        $image = $row["image"];
    }
}
echo '<img src="' . $imageURL . '" alt=" No Image Shown ">


';
