<?php

require 'config.php';

$joResult = mysqli_query($db, "SELECT jo_tb.jo_id, jo_tb.jo_no, jo_tb.customers_id, customers.customers_name , jo_tb.jo_date 
FROM jo_tb 
LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id
LEFT JOIN jo_type ON jo_type.jo_type_id = jo_tb.jo_type_id
WHERE jo_tb.jo_type_id = '1' AND jo_tb.closed = '0' 
ORDER BY jo_tb.jo_date DESC ");

if (mysqli_num_rows($joResult) > 0) {
  while ($row = mysqli_fetch_assoc($joResult)) {
    $joId[] = $row['jo_id'];
    $joNum[] = $row['jo_no'];
    $joCustomerId[] = $row['customers_id'];
    $joCustomerName[] = $row['customers_name'];
    $joDate[] = $row['jo_date'];
  }
}


// For selecting   Customer details of JO
if (isset($_GET['selectCustomer'])) {
  $joNo = $_GET['joNo'];
  $joSelect = mysqli_query(
    $db,
    "SELECT jo_tb.customers_id, jo_tb.jo_id, customers.customers_name, customers.customers_address, customers.customers_contact
    FROM jo_tb 
    LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id
    WHERE jo_tb.jo_no='$joNo'"
  );

  if (mysqli_num_rows($joSelect) > 0) {
    while ($row = mysqli_fetch_assoc($joSelect)) {
      $output[] = $row;
    }
  }

  echo json_encode($output);
}


// For selecting Order details of JO
if (isset($_GET['selectOrders'])) {


  $joId = $_GET['joId'];

  // Select qry for jo_tb
  $joSelect = mysqli_query(
    $db,
    "SELECT jo_product.product_id, jo_product.jo_product_qty, jo_product.jo_product_price,
   jo_tb.jo_id, jo_tb.jo_no, product.product_name, unit_tb.unit_name
  FROM jo_product 
  LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id
  LEFT JOIN product ON jo_product.product_id = product.product_id
  LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id
  WHERE jo_tb.jo_id='$joId'"
  );


  $output = [];

  if (mysqli_num_rows($joSelect) > 0) {
    while ($row = mysqli_fetch_assoc($joSelect)) {


      $orderSelect = mysqli_query(
        $db,
        "SELECT 
        order_tb.order_id, 
        order_product.product_id, 
        order_product.pos_temp_qty,
        order_tb.jo_id
        FROM order_product 
        LEFT JOIN order_tb AS order_tb ON order_tb.order_id = order_product.order_id
        WHERE order_tb.jo_id = '$joId' AND order_product.product_id =" . $row['product_id']
      );

      $orderReleased = 0;
      if (mysqli_num_rows($orderSelect) > 0) {
        while ($orderRow = mysqli_fetch_assoc($orderSelect)) {
          $orderReleased += $orderRow['pos_temp_qty'];
        }
      }
      $row['jo_product_qty'] -= $orderReleased;

      $output[] = $row;
    }
  }


  echo json_encode($output);
}

// Searching Jo
if (isset($_POST['joSearch'])) {
  require 'config.php';

  $joSearch = $_POST['joSearch'];

  $joResult = mysqli_query($db, "SELECT jo_tb.jo_id, jo_tb.jo_no, jo_tb.customers_id, customers.customers_name , jo_tb.jo_date 
FROM jo_tb 
LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id 
LEFT JOIN jo_type On jo_type.jo_type_id = jo_tb.jo_type_id
WHERE jo_tb.jo_no LIKE '%$joSearch%' AND jo_tb.closed = '0' AND jo_tb.jo_type_id = '1'
ORDER BY jo_tb.jo_no LIMIT 20");

  $output = [];


  if (mysqli_num_rows($joResult) > 0) {
    while ($row = mysqli_fetch_assoc($joResult)) {
      $output[] = $row;
    }
  }

  echo json_encode($output);
}
