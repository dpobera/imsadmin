<?php
session_start();
include_once "../../php/config.php";

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
$stinId = $_POST['stin_id'];
$productId = $_POST['product-id'];
$qty = $_POST['qty_order'];
$cost = 0;
$disamount = 0;
$total = 0;
$stinCode = $_POST['stin_code'];
$stinTitle = $_POST['stin_title'];
$stinDate = $_POST['stin_date'];
$stin_temp_remarks = $_POST['stin_temp_remarks'];
$stinRemarks = $_POST['stin_remarks'];
$emp_id = $_POST['emp_id'];


if (isset($_POST['btnsave']) && $productId[0] != "") { //Will not proceed if Products are Empty

  echo "<br>";

  foreach ($productId as $x) {
    echo "product id :" . $x . "<br>";
  }

  echo "stin id:" . $stinId . "<br>" . "<br>";

  $limit = 0;
  while (sizeof($productId) !== $limit) {

    $sql = "INSERT INTO stin_product (product_id,stin_id, stin_temp_qty)
            VALUES (" . $productId[$limit] . "," . $stinId . "," . $qty[$limit] . ")";

    if (mysqli_query($db, $sql)) {
      echo "New record created successfully " . "<br>" . "<br>";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
    }

    $limit++;
  }

  $limiter = 0;
  while (sizeof($productId) !== $limiter) {
    $sql = "UPDATE stin_product 
                     SET stin_temp_remarks ='" . $stin_temp_remarks[$limiter]
      . "' WHERE product_id = " . $productId[$limiter] . " AND stin_id =" . $stinId;

    if (mysqli_query($db, $sql)) {
      echo "New record created successfully " . "<br>" . "<br>";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
    }

    $limiter++;
  }




  $sql = "INSERT INTO stin_tb (stin_id,stin_code, stin_title ,stin_date ,stin_remarks, emp_id, user_id)
            VALUES ('$stinId','$stinCode','$stinTitle','$stinDate','$stinRemarks','$emp_id','" . $_SESSION['id'] . "')";

  if (mysqli_query($db, $sql)) {
    echo "<script>alert('New Record Added')
    location.href = '../../stin-index.php'</script>";
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
