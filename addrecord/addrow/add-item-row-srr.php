<?php
include '../../../php/config.php';
$product_id = $_GET['id'];
$product_qty = $_GET['qty'];
$srrRef = $_GET['srrRef'];
$supplier = $_GET['supplier'];
$srrDate = $_GET['srrDate'];

$sql = "SELECT product.product_name, product.product_id, unit_tb.unit_name, product.pro_remarks
    FROM product
    INNER JOIN unit_tb ON product.unit_id = unit_tb.unit_id
    WHERE product_id = '$product_id' LIMIT 1";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while ($row = mysqli_fetch_assoc($result)) {



    echo "<tr>
        <td class='hidden'><input id='product" . $row['product_id'] . "' name='product-id[]' class='hidden' value='" . $row['product_id'] . "'></td>
        <td>" . $row['product_name'] . "</td>
        <td><input name='qty_order[]' style='border:none;' value='" . $product_qty . "' readonly></td>
        <td>" . $row['unit_name'] . "</td>
        <td>" . $row['pro_remarks'] . "</td>
        <td><input name='srrRef' style='border:none;' value='" . $srrRef . "' readonly></td>
        <td><input name='sup' style='border:none;' value='" . $supplier . "' readonly></td>
        <td><input name='date' style='border:none;' value='" . $srrDate . "' readonly></td>
        <td style='text-align:center;'><span><a href='#' class='delete' id='" . $row['product_id'] . " title='remove' ><font color='red'><i class='fa fa-trash-o' style='font-size:20px'></i></font></a></span></td>
        </tr>";
  }
} else {

  echo '<script>
    alert("No Item Selected !");
    ;
    </script>';
}
