<?php
include '../../php/config.php';
$product_id = $_GET['id'];
$product_qty = $_GET['qty'];

$sql = "SELECT product.product_id, product.product_name, unit_tb.unit_name FROM product LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id WHERE product_id = '$product_id' LIMIT 1";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {

        echo "<tr >
        <td class='hidden'><input id='product" . $row['product_id'] . "' name='product-id[]' class='hidden' value='" . $row['product_id'] . "'></td>
        <td>&emsp;" . $row['product_name'] . "</td>
        <td><input name='qty_order[]' style='border:none;' value='" . number_format($product_qty, 2)  . "' readonly></td>
        <td>" . $row['unit_name'] . "</td>
        <td style='text-align:center;'><span><a href='#' class='delete' id='" . $row['product_id'] . " title='remove' ><font color='red'><i class='bi bi-trash3-fill' style='font-size:20px'></i></font></a></span></td>
        </tr>";
    }
} else {
    echo '<script>
    alert("No Item Selected !");
    ;
    </script>';
}
