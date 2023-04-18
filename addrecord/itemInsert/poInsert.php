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
$poId = $_POST['po_id'];
$productId = $_POST['product-id'];
$qty = $_POST['qty_order'];
$cost = $_POST['cost'];
$disamount = $_POST['disamount'];
$total = $_POST['total'];
$poCode = $_POST['po_code'];
$poTitle = $_POST['po_title'];
$poDate = $_POST['po_date'];
$poRemarks = $_POST['po_remarks'];
$poTerms = $_POST['po_terms'];
$supId = $_POST['sup_id'];
$po_type_id = $_POST['po_type_id'];
$ref_num = $_POST['ref_num'];

if (isset($_POST['btnsave']) && $productId[0] != "") { //Will not proceed if Products are Empty

  echo "<br>";

  foreach ($productId as $x) {
    echo "product id :" . $x . "<br>";
  }

  echo "PO ID:" . $poId . "<br>" . "<br>";

  $limit = 0;
  while (sizeof($productId) !== $limit) {

    $sql = "INSERT INTO po_product (product_id, po_id, item_qtyorder,item_cost,item_disamount,po_temp_tot)
            VALUES (" . $productId[$limit] . "," . $poId . "," . $qty[$limit] . "," . removeComma($cost[$limit]) . "," . removeComma($disamount[$limit]) . "," . removeComma($total[$limit]) . ")";

    if (mysqli_query($db, $sql)) {
      echo "New record created successfully " . "<br>" . "<br>";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
    }

    $limit++;
  }

  $sql = "INSERT INTO po_tb (po_id,po_code, po_title ,po_date ,po_remarks, po_terms, po_type_id, sup_id, user_id,ref_num)
            VALUES ('$poId','$poCode','$poTitle','$poDate','$poRemarks','$poTerms','$po_type_id','$supId','" . $_SESSION['id'] . "','$ref_num')";

  if (mysqli_query($db, $sql)) {
    echo "<script>alert('New Record Added')
    location.href = '../../po-index.php'</script>";
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
