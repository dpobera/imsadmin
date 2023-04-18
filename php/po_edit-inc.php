<?php

// IF Edit button Click from PO Main
if (isset($_GET['editpo'])) {

    $poId = $_GET['id'];

    require 'php/config.php';

    $result = mysqli_query(
        $db,
        "SELECT po_tb.po_id, po_tb.po_terms, po_tb.po_remarks, po_tb.po_code,
  po_tb.po_date, po_tb.po_title, po_tb.sup_id, po_product.item_qtyorder, po_product.item_cost, 
  po_product.item_disamount, po_product.item_discpercent, po_product.po_temp_tot, product.product_name, product.product_name,
  product.class_id, product.unit_id, product.product_id, sup_tb.sup_name, unit_tb.unit_name, po_type.po_type_id, po_type.po_type_name,po_tb.ref_num
 FROM po_tb  
 LEFT JOIN po_product ON po_product.po_id = po_tb.po_id
 LEFT JOIN product ON po_product.product_id = product.product_id
 LEFT JOIN sup_tb ON sup_tb.sup_id = po_tb.sup_id
 LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
 LEFT JOIN po_type ON po_type.po_type_id = po_tb.po_type_id
 WHERE po_tb.po_id ='$poId'
 ORDER BY po_product.po_product_id DESC"
    );


    // PO Details
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $supId = $row['sup_id'];
            $supName = $row['sup_name'];
            $poTerms = $row['po_terms'];
            $poRemarks = $row['po_remarks'];
            $poDate = $row['po_date'];
            $poCode = $row['po_code'];
            $poTitle = $row['po_title'];
            $refNum = $row['ref_num'];
            $po_type_id = $row['po_type_id'];
            $po_type_name = $row['po_type_name'];
            $productId[] = str_pad($row['product_id'], 8, 0, STR_PAD_LEFT);
            $productName[] = $row['product_name'];
            $qtyIn[] = $row['item_qtyorder'];
            $unitId[] = $row['unit_id'];
            $unitName[] = $row['unit_name'];
            $itemCost[] = $row['item_cost'];
            $itemDisamount[] = $row['item_disamount'];
            $itemDiscpercent[] = $row['item_discpercent'];
            $itemTotal[] = $row['po_temp_tot'];
        }
    } else {
        echo "0 results";
    }
}

// If po_edit-page.php update button is set
if (isset($_POST['updatepo'])) {

    $poId = $_POST['poId'];
    $supId = $_POST['supplierId'];
    $poTitle = $_POST['poTitle'];
    $poTerms = $_POST['poTerms'];
    $poRemarks = $_POST['poRemarks'];
    $poDate = $_POST['poDate'];
    $poCode = $_POST['poCode'];
    $refNum = $_POST['refNum'];
    $po_type_id = $_POST['po_type_id'];


    $productId = $_POST['productId'];
    $qtyIn = $_POST['qtyIn'];
    $itemCost = $_POST['itemCost'];
    $itemDisamount = $_POST['itemDisamount'];
    $itemDiscpercent = $_POST['itemDiscpercent'];
    $itemTotal = $_POST['itemTotal'];

    require '../php/config.php';

    // Update po_tb
    mysqli_query(
        $db,
        "UPDATE po_tb SET sup_id ='$supId', po_title = '$poTitle',po_code = '$poCode', po_terms = '$poTerms', po_remarks = '$poRemarks',  po_date = '$poDate' , po_type_id='$po_type_id' , ref_num='$refNum'
    WHERE po_id = '" . number_format($poId) . "'"
    );


    // Update po_product
    $limit = 0;
    while (count($productId) !== $limit) {
        // Check product id from po_product
        $checkResult = mysqli_query($db, "SELECT product_id FROM po_product WHERE po_id = $poId AND product_id ='" . $productId[$limit] . "'");

        if (mysqli_num_rows($checkResult) > 0) {
            // If product id already exist on po_product, UPDATE
            $sql = "UPDATE po_product SET item_qtyorder = '$qtyIn[$limit]', item_cost = '$itemCost[$limit]' , item_disamount = '$itemDisamount[$limit]', item_discpercent='$itemDiscpercent[$limit]', po_temp_tot= '$itemTotal[$limit]' WHERE po_id = '$poId' AND product_id ='$productId[$limit]'";
        } else {
            // If product id dont exist on po_product, INSERT
            if ($productId[$limit] != 0) {
                $sql = "INSERT INTO po_product(product_id, po_id, item_qtyorder, item_cost, item_disamount, item_discpercent, po_temp_tot) 
        VALUES ('$productId[$limit]','$poId','$qtyIn[$limit]','$itemCost[$limit]','$itemDisamount[$limit]','$itemDiscpercent[$limit]','$itemTotal[$limit]')";
            }
        }

        mysqli_query($db, $sql);

        $limit++;
    }

    // editpo&id=2&supId=107&supName=A.F.%20SA

    header("location: ../po_edit.php?editpo&updated&id=$poId");
}

// If po_edit-page.php update button is set
if (isset($_POST['cancelupdate'])) {
    header('location: ../po_main.php');
}


// If po_edit-page.php delete button is set
if (isset($_POST['delete'])) {
    $poId = $_POST['poId'];
    $productId = $_POST['productId'];

    require '../php/config.php';

    mysqli_query($db, "DELETE FROM po_product WHERE po_id = '$poId' AND product_id = '$productId'");
}

if (isset($_GET['updated'])) {
    echo
    '<script>
  alert("Successfully updated!");
  location.href = "po_edit.php?editpo&id=' . $_GET['id'] . '";
  </script>';
}
