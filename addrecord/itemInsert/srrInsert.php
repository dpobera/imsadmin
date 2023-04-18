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
$srrID = $_GET['srr_id'];
$productId = $_GET['product-id'];
$qty = $_GET['qty_order'];
$supId = $_GET['sup'];
$srrDate = $_GET['date'];
$srrNo = $_GET['srr_no'];
$empId = $_GET['emp_id'];
$srrRef = $_GET['srrRef'];



if (isset($_GET['btnsave']) && $productId[0] != "") { //Will not proceed if Products are Empty

  echo "<br>";

  foreach ($productId as $x) {
    echo "product id :" . $x . "<br>";
  }

  echo "Srr ID:" . $srrID . "<br>" . "<br>";

  $limit = 0;
  while (sizeof($productId) !== $limit) {

    $sql = "INSERT INTO srr_product (product_id,srr_id,srr_qty,srr_ref,sup_id,srr_date)

            VALUES ('" . $productId[$limit] . "','" . $srrID . "','" . $qty[$limit] . "','" . $srrRef . "','" . $supId[$limit] . "','" . $srrDate . "')";


    if (mysqli_query($db, $sql)) {
      echo "New record created successfully " . "<br>" . "<br>";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
    }

    $limit++;
  }


  $sql = "INSERT INTO srr_tb (srr_id,srr_no,emp_id)
            VALUES ('$srrID','$srrNo','$empId')";

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
