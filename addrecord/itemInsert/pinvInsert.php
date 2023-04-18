<?php
session_start();
include_once "../../../php/config.php";

//function for removing comma
function removeComma($str)
{
    $comma = "/,/i";
    if (preg_match($comma, $str)) {
        return str_replace(',', '', $str);
    } else {
        return $str;
    }
}
$pinvId = $_GET['newPinvId'];
$productId = $_GET['product-id'];
$qty = $_GET['qty_order'];
$location = $_GET['location'];

$pinvTitle = $_GET['pinv_title'];
$pinvDate = $_GET['pinv_date'];
$emp_id = $_GET['emp_id'];


if (isset($_GET['btnsave']) && $productId[0] != "") { //Will not proceed if Products are Empty

    echo "<br>";

    foreach ($productId as $x) {
        echo "product id :" . $x . "<br>";
    }

    echo "pinv id:" . $pinvId . "<br>" . "<br>";

    $limit = 0;
    while (sizeof($productId) !== $limit) {

        $sql = "INSERT INTO pinv_product (product_id,pinv_id, pinv_qty, loc_id)
            VALUES (" . $productId[$limit] . "," . $pinvId . "," . $qty[$limit] . "," . $location[$limit] .  ")";

        if (mysqli_query($db, $sql)) {
            echo "New record created successfully " . "<br>" . "<br>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
        }

        $limit++;
    }

    $sql = "INSERT INTO pinv_tb (pinv_id,pinv_title, pinv_date, emp_id , user_id)
            VALUES ('$pinvId','$pinvTitle','$pinvDate','$emp_id','" . $_SESSION['id'] . "')";

    if (mysqli_query($db, $sql)) {
        echo "<script>alert('New Record Added')</script>";
        echo "<script>window.close();</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>";
    }
} else {

    $url = "pos-main.html?";

    foreach ($productId as $urlId) {
        $url .= "product_id[]=" . $urlId . "&";
    }
    echo $url;
    // header("location: " .$url); //Go back to main page
}
