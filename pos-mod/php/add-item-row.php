<?php 

    include 'config.php';

    $product_id = $_GET['id'];
    // $qty = $_GET['qty'];
    // $discount = $_GET['discount'];
    
    $sql = "SELECT * FROM product WHERE product_id = '$product_id' LIMIT 1";
    $result = mysqli_query($db, $sql);
    
    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {

        echo "<tr class='product-row' id='product" .$row['product_id'] ."'>
        <td class='hidden'><input id='product".$row['product_id'] ."' name='product-id[]' class='hidden' value='" .$row['product_id'] ."'></td>
        <td class='qty'><input  name='qty_order[]' class='qty-order' value='1'></td>
        <td class='item'>" .$row['product_name'] ."</td>
        <td class='price'>" .number_format($row['price'],2) ."</td>
        <td class='disamount'><input class='disamount' name='disamount[]' value='" .number_format(0,2)  ."'></td>
        <td class='total'>" .number_format($row['price'],2) ."</td>
        <td class='delete'><span type='button' class='delete'>&times;</span></td>
        </tr>";
      }
    } else {

      echo '0 results';
    }

?>
