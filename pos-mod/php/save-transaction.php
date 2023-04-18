<?php

require "./functions.php";


if ($_POST['json']) {
  session_start();
  date_default_timezone_set("Asia/Manila");
  include 'config.php';

  $transDetails = json_decode($_POST['json']);
  $customerId = $transDetails->customerId;
  $productId = $transDetails->productId;
  $productQty = $transDetails->qty;
  $productPrice = $transDetails->price;
  $discount = $transDetails->discount;
  $orderId = $transDetails->transactionId;
  $total = $transDetails->total;
  $joId = $transDetails->joId;
  $userId = $_SESSION['id'];

  $lastQty = [];

  // Check total Qty
  $totalQty = 0;
  foreach ($productQty as $qty) {
    $totalQty += $qty;
  }
  // Exit if total qty <= 0
  if ($totalQty <= 0) {
    exit();
  }

  $query = "INSERT INTO order_tb (customer_id, total, order_status_id, user_id, jo_id) 
    VALUES ('$customerId','$total','1', '$userId', '$joId');";

  $query2 = "INSERT INTO order_payment (order_id, payment_type_id, order_payment_credit, order_payment_balance,  payment_status_id)
    VALUES ('$orderId','0','$total','$total', '1');";

  mysqli_query($db, $query);
  mysqli_query($db, $query2);

  $limit = 0;
  while (sizeof($productId) != $limit) {

    if ($productQty[$limit] == 0) {
      $limit++;
      continue;
    }
    // Insert order details on order_product
    $query3 = "INSERT INTO order_product (product_id, order_id, pos_temp_qty, pos_temp_price, pos_temp_disamount) 
    VALUES ('" . $productId[$limit] . "','" . $orderId . "','" . $productQty[$limit] . "','" . $productPrice[$limit] . "','" . $discount[$limit] . "');";

    mysqli_query($db, $query3);

    // Subract qty ordered from product table
    $query4 = "SELECT qty FROM product WHERE product_id=" . $productId[$limit];
    $result = mysqli_query($db, $query4);

    // Run Loop for each product 
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $currentQty = $row['qty'];

        // Update current product qty
        $sqlUpdateQty = "UPDATE product SET qty=" . ($currentQty - $productQty[$limit]) . " WHERE product_id =" . $productId[$limit];

        mysqli_query($db, $sqlUpdateQty);

        // Record item movement
        $sqlItemMov = "INSERT INTO move_product(product_id, bal_qty, out_qty, mov_type_id, move_ref)
        VALUES('" . $productId[$limit] . "','" . $currentQty . "','" . $productQty[$limit] . "','4','" . $orderId . "')";

        mysqli_query($db, $sqlItemMov);
      };
    }


    $limit++;
  }

  // Close the jo_tb if Order_tb and Jo_tb are equal qty
  $totaJoQty = getJoTotalQty($db, $joId);
  $totalOrderQty = getOrderTotalQty($db, $joId);

  if ($totalOrderQty >= $totaJoQty) {
    closeJo($db, $joId);
  }
  // echo $query;
}
