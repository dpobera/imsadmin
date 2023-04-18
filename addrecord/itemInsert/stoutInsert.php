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
$stoutID = $_POST['stout_id'];
$productId = $_POST['product-id'];
$qty = $_POST['qty_order'];
$cost = 0;
$disamount = 0;
$total = 0;
$stoutCode = $_POST['stout_code'];
$stoutRemarks = $_POST['stout_remarks'];
$stoutTitle = $_POST['stout_title'];
$stoutDate = $_POST['stout_date'];
$stout_temp_remarks = $_POST['stout_temp_remarks'];
$emp_id = $_POST['emp_id'];
$itemdesc = $_POST['itemdesc'];


if (isset($_POST['btnsave']) && $productId[0] != "") { //Will not proceed if Products are Empty

  echo "<br>";

  foreach ($productId as $x) {
    echo "product id :" . $x . "<br>";
  }

  echo "stout id:" . $stoutID . "<br>" . "<br>";

  $limit = 0;
  while (sizeof($productId) !== $limit) {

    $sql = "INSERT INTO stout_product (product_id, stout_id, stout_temp_qty, stout_temp_cost, stout_temp_disamount, stout_temp_tot)

            VALUES (" . $productId[$limit] . "," . $stoutID . "," . $qty[$limit] . ",0,0,0)";


    if (mysqli_query($db, $sql)) {
      echo "New record created successfully " . "<br>" . "<br>";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
    }

    $limit++;
  }

  $limiter = 0;
  while (sizeof($productId) !== $limiter) {
    $sql = "UPDATE stout_product 
                     SET stout_temp_remarks ='" . $stout_temp_remarks[$limiter]
      . "' WHERE product_id = " . $productId[$limiter] . " AND stout_id =" . $stoutID;





    if (mysqli_query($db, $sql)) {
      echo "New record created successfully " . "<br>" . "<br>";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
    }

    $limiter++;
  }



  $sql = "INSERT INTO stout_tb (stout_id,stout_code, stout_title, stout_date, stout_remarks, itemdesc, emp_id, user_id)
            VALUES ('$stoutID','$stoutCode','$stoutTitle','$stoutDate','$stoutRemarks','$itemdesc','$emp_id','" . $_SESSION['id'] . "')";

  if (mysqli_query($db, $sql)) {
    echo "<script>alert('New Record Added')
    location.href = '../../stout-index.php'</script>";
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
