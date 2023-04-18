<?php
include '../../php/config.php';
$product_id = $_GET['id'];
$product_qty = $_GET['qty'];
$item_price = $_GET['price'];
$item_fee = $_GET['fee'];


$sql = "SELECT * FROM product WHERE product_id = '$product_id' LIMIT 1";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {

        $total_amount =  floatval($product_qty) * floatval($item_price) - floatval($item_fee);

        echo "<tr>
        <td class='hidden'><input id='product" . $row['product_id'] . "' name='product-id[]' class='hidden' value='" . $row['product_id'] . "'></td>
        <td>&emsp;" . $row['product_name'] . "</td>
        <td><input type='hidden' name='qty_order[]' style='border:none;' value='" . $product_qty . "' readonly>" . number_format($product_qty, 2)  . "</td>
        <td><input type='hidden' name='price[]' style='border:none;' style='border:none;' value='" . $item_price . "' readonly>" .  number_format($item_price, 2) . "</td>
        <td><input type='hidden' name='fee[]' style='border:none;' style='border:none;' value='" . $item_fee . "' readonly>" . number_format($item_fee, 2) . "</td>
        <td><input type='hidden' name='total[]' style='border:none;' value='" . number_format($total_amount, 2) . "' readonly>" . number_format($total_amount, 2) . "</td>
        <td style='text-align:center;'><span><a href='#' class='delete' id='" . $row['product_id'] . " title='remove' ><font color='red'><i class='bi bi-trash3-fill' style='font-size:20px'></i></font></a></span></td>
        </tr>";
    }
} else {

    echo '<script>
    alert("No Item Selected !");
    ;
    </script>';
}
