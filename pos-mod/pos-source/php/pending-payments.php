<?php
include "config.php";

$output = [];

//   $query = "SELECT order_tb.order_id, order_tb.customer_id, order_tb.total, order_tb.pos_date, customers.customers_name
//   FROM order_tb 
//   INNER JOIN order_status ON order_status.status_id = order_tb.status_id 
//   INNER JOIN customers ON customers.customers_id = order_tb.customer_id
//   WHERE order_tb.status_id = 1 ORDER BY order_tb.pos_date DESC";

$query = "SELECT order_tb.order_status_id, order_tb.order_id, order_tb.customer_id, order_tb.total, order_tb.pos_date, 
  customers.customers_name, order_payment.order_payment_balance, order_payment_id
  FROM order_tb 
  INNER JOIN customers ON customers.customers_id = order_tb.customer_id
  INNER JOIN order_payment ON order_tb.order_id = order_payment.order_id
  WHERE order_payment.order_payment_balance > 0 AND order_payment.payment_status_id != 0 
  AND order_tb.order_status_id = 1 ORDER BY order_tb.order_id DESC";

$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $output[] = $row;
  }
} else {
  echo "No result";
}

echo json_encode($output);
