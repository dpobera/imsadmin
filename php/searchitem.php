<?php
include 'config.php';


$query = "SELECT product.pro_remarks,
            product.product_id, 
            product.product_name, 
            product.price, 
            product.qty,
            unit_tb.unit_name,
            product.barcode, 
            loc_tb.loc_name,
            loc_tb.loc_id,
            product.unit_id,
            product.cost
            FROM product 
            LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
            LEFT JOIN loc_tb ON product.loc_id = loc_tb.loc_id
            WHERE product_name LIKE '%" . $_GET['q'] . "%' ORDER BY product_id LIMIT 100";

$output = [];

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $output[] = $row;
  }
} else {
  echo "No result";
}

echo json_encode($output);
