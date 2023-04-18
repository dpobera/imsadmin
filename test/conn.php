<?php
$conn = mysqli_connect("localhost", "root", "", "inventorymanagement");

if (!$conn) {
    die("Error: Failed to connect to database!");
}
