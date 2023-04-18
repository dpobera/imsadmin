<?php
require_once 'conn.php';

if (isset($_POST['insert'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $address = $_POST['address'];

    mysqli_query($conn, "INSERT INTO `member` VALUES('', '$firstname', '$lastname', '$gender', '$age', '$address')") or die(mysqli_error());
    header("location: index.php");
}
