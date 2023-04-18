<?php

include '../../php/config.php';

$product_id = $_GET['id'];
$product_qty = $_GET['qty'];
$item_discount = 0;
$item_remarks = $_GET['remarks'];
$sql = "SELECT * FROM product WHERE product_id = '$product_id' LIMIT 1";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while ($row = mysqli_fetch_assoc($result)) {

    $total_amount = floatval($row['cost']) * floatval($product_qty) - floatval($item_discount);

    echo "<tr>
        <td class='hidden'><input id='product" . $row['product_id'] . "' name='product-id[]' class='hidden' value='" . $row['product_id'] . "'></td>
        <td style='width:40%;'>&emsp;&nbsp;" . $row['product_name'] . "</td>
        <td><input name='qty_order[]' style='border:none;' value='" . $product_qty . "' readonly></td>
        <td><input name='stin_temp_remarks[]' style='border:none;' value='" . $item_remarks . "' readonly></td>
        
        <td style='text-align:center;'><span><a href='#' class='delete' id='" . $row['product_id'] . " title='remove' ><font color='red'><i class='bi bi-trash3-fill' style='font-size:18px'></i></font></a></span></td>
        </tr>";
  }
} else {

  echo '<script>
  alert("No Item Selected !");
  ;
  </script>';
}
