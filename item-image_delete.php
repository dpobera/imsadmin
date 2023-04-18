<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventorymanagement";

$imageId = $_GET['imageId'];
$id = $_GET['prodId'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// sql to delete a record
$sql = "DELETE FROM images WHERE id=$imageId";

if ($conn->query($sql) === TRUE) {

    header("Location: item-image.php?id=" . $id);
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
