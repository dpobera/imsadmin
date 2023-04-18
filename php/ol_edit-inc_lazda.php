<?php

// IF Edit button Click from PO Main
if (isset($_GET['editOl'])) {

    $olId = $_GET['id'];

    require 'php/config.php';

    $result = mysqli_query(
        $db,
        "SELECT ol_tb_lazada.ol_id, ol_type.ol_type_id, ol_type.ol_type_name, ol_product.ol_price, ol_product.ol_priceTot, ol_tb_lazada.ol_title, ol_tb_lazada.ol_date, ol_product.ol_qty, product.product_id, product.product_name, unit_tb.unit_name, unit_tb.unit_id, ol_tb_lazada.ol_si, ol_product.ol_fee, ol_tb_lazada.ol_adjustment
        FROM ol_tb_lazada
        LEFT JOIN ol_product ON ol_product.ol_id = ol_tb_lazada.ol_id
        LEFT JOIN ol_type ON ol_type.ol_type_id = ol_tb_lazada.ol_type_id
        LEFT JOIN product ON ol_product.product_id = product.product_id
        LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
        WHERE ol_tb_lazada.ol_id ='$olId' AND ol_product.ol_type_id = 1 
        ORDER BY ol_product.ol_product_id DESC"
    );



    // PO Details
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $oltypeId = $row['ol_type_id'];
            $olTypeName = $row['ol_type_name'];
            $olTitle = $row['ol_title'];
            $olSi = $row['ol_si'];
            $olDate = $row['ol_date'];
            $olAdjustment = $row['ol_adjustment'];
            $productId[] = str_pad($row['product_id'], 8, 0, STR_PAD_LEFT);
            $productName[] = $row['product_name'];
            $qtyIn[] = $row['ol_qty'];
            $unitId[] = $row['unit_id'];
            $unitName[] = $row['unit_name'];
            $itemPrice[] = $row['ol_price'];
            $itemFee[] = $row['ol_fee'];
            $itemTotal[] = $row['ol_priceTot'];
        }
    } else {
        echo "0 results";
    }
}

// If po_edit-page.php update button is set
if (isset($_POST['update'])) {
    $olId = $_POST['olId'];
    $oltypeId = $_POST['oltypeId'];
    $olTitle = $_POST['olTitle'];
    $olSi = $_POST['olSi'];
    $olDate = $_POST['olDate'];
    $olAdjustment = $_POST['olAdjustment'];

    $productId = $_POST['productId'];
    $qtyIn = $_POST['qtyIn'];
    $itemPrice = $_POST['itemPrice'];
    $itemFee = $_POST['itemFee'];
    $itemTotal = $_POST['itemTotal'];

    require '../php/config.php';

    // Update po_tb
    mysqli_query(
        $db,
        "UPDATE ol_tb_lazada SET ol_title='$olTitle',ol_si='$olSi',  ol_date='$olDate', ol_adjustment = '$olAdjustment' WHERE ol_id='$olId' "
    );


    // Update po_product
    $limit = 0;
    while (count($productId) !== $limit) {
        // Check product id from po_product
        $checkResult = mysqli_query($db, "SELECT product_id FROM ol_product WHERE ol_id = $olId AND product_id ='" . $productId[$limit] . "'");

        if (mysqli_num_rows($checkResult) > 0) {
            // If product id already exist on po_product, UPDATE
            mysqli_query($db, "UPDATE ol_product SET ol_qty = '$qtyIn[$limit]', ol_price = '$itemPrice[$limit]', ol_fee = '$itemFee[$limit]', ol_priceTot= '$itemTotal[$limit]' WHERE ol_id = '$olId' AND product_id ='$productId[$limit]'");
        } else {
            // If product id dont exist on po_product, INSERT
            mysqli_query($db, "INSERT INTO ol_product(product_id, ol_id, ol_qty, ol_price, ol_fee, ol_priceTot) 
      VALUES ('$productId[$limit]','$olId','$qtyIn[$limit]','$itemPrice[$limit]','$itemFee[$limit]','$itemTotal[$limit]')");
        }
        $limit++;
    }

    // editpo&id=2&supId=107&supName=A.F.%20SA

    header("location: ../ol_edit.php?editOl&updated&id=$olId&update=success");
}

// If po_edit-page.php update button is set
if (isset($_POST['cancelupdate'])) {
    header('location: ../ol-index.php');
}


// If stout_edit-page.php delete button is set
if (isset($_POST['delete'])) {
    $olId = $_POST['olId'];
    $productId = $_POST['productId'];

    require '../php/config.php';

    mysqli_query($db, "DELETE FROM ol_product WHERE ol_id = '$olId' AND product_id = '$productId'");

    echo "epId" . $epId . "productId" . $productId;
}

if (isset($_GET['updated'])) {
    echo
    '<script>
  alert("Successfully updated!");
  location.href = "ol_edit.php?editOl&id=' . $_GET['id'] . '";
  </script>';
}
