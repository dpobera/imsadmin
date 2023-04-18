<?php
session_start();
$userLevel = $_SESSION['level'];

// if ($userLevel > 1) {
//     echo "Unauthorized";
//     exit();
// }

$orderId = number_format($_POST['orderId']);
require 'config.php';


// Change status of order on order_tb
if (!mysqli_query($db, "UPDATE order_tb SET order_status_id = '4' WHERE order_id = '$orderId'")) {
  echo "Error Order Table Update";
  exit();
}


// Change qty of products in product_tb based on order_product
//  - SELECT product_id, qty from order_product where order_id = $orderId
$result =  mysqli_query(
  $db,
  "SELECT order_product.product_id, order_product.pos_temp_qty, product.qty
  FROM order_product 
  LEFT JOIN product ON order_product.product_id = product.product_id
  WHERE order_product.order_id = $orderId"
);

if (!$result) {
  echo "Error Item Fetch";
  exit();
}

//  - For each product add the qty to product_tb 
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $productId[] = $row['product_id'];
    $orderQty[] = $row['pos_temp_qty'];
    $productQty[] = $row['qty'];
  }
}

foreach ($productId as $index => $id) {
  $newQty = $orderQty[$index] + $productQty[$index];
  $balQty = $productQty[$index];
  $inQty = $orderQty[$index];

  if (!mysqli_query($db, "UPDATE product SET qty='$newQty' WHERE product_id = '$id'")) {
    echo "Error updating product table.";
    exit();
  };

  if (!mysqli_query(
    $db,
    "INSERT INTO move_product(product_id, bal_qty, in_qty, mov_type_id, move_ref)
    VALUES('$id', '$balQty', '$inQty', '7', '$orderId')"
  )) {
    echo "Error updating movement table.";
    exit();
  };
}


echo "Order Successfully Cancelled!";
