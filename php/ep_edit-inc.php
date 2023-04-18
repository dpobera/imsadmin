<?php

// IF Edit button Click from PO Main
if (isset($_GET['editEp'])) {

    $epId = $_GET['id'];

    require 'php/config.php';

    $result = mysqli_query(
        $db,
        "SELECT ep_tb.ep_id, ep_tb.ep_no, ep_tb.ep_title, ep_tb.ep_remarks, ep_tb.ep_date, customers.customers_name, customers.customers_id, ep_product.product_id, ep_product.ep_qty, ep_product.ep_price, ep_product.ep_totPrice, product.product_name, unit_tb.unit_name, unit_tb.unit_id
        FROM ep_tb
        LEFT JOIN ep_product ON ep_product.ep_id = ep_tb.ep_id
        LEFT JOIN customers ON customers.customers_id = ep_tb.customers_id
        LEFT JOIN product ON ep_product.product_id = product.product_id
        LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
        WHERE ep_tb.ep_id ='$epId' ORDER BY ep_product.ep_product_id ASC"
    );



    // PO Details
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $customerName = $row['customers_name'];
            $customerId = $row['customers_id'];
            $epNo = $row['ep_no'];
            $epTitle = $row['ep_title'];
            $epRemarks = $row['ep_remarks'];
            $epDate = $row['ep_date'];
            $customerName = $row['customers_name'];
            $productId[] = str_pad($row['product_id'], 8, 0, STR_PAD_LEFT);
            $productName[] = $row['product_name'];
            $qtyIn[] = $row['ep_qty'];
            $unitId[] = $row['unit_id'];
            $unitName[] = $row['unit_name'];
            $itemPrice[] = $row['ep_price'];
            $itemTotal[] = $row['ep_totPrice'];
        }
    } else {
        echo "0 results";
    }
}

// If po_edit-page.php update button is set
if (isset($_POST['update'])) {
    $epId = $_POST['epId'];
    $customerId = $_POST['customerId'];
    $epTitle = $_POST['epTitle'];
    $epNo = $_POST['epNo'];
    $epRemarks = $_POST['epRemarks'];
    $epDate = $_POST['epDate'];

    $productId = $_POST['productId'];
    $qtyIn = $_POST['qtyIn'];
    $itemPrice = $_POST['itemPrice'];
    $itemTotal = $_POST['itemTotal'];

    require '../php/config.php';

    // Update po_tb
    mysqli_query(
        $db,
        "UPDATE ep_tb SET ep_no='$epNo', ep_title='$epTitle',customers_id='$customerId',  ep_date='$epDate', ep_remarks='$epRemarks' WHERE ep_id='$epId' "
    );


    // Update po_product
    $limit = 0;
    while (count($productId) !== $limit) {
        // Check product id from po_product
        $checkResult = mysqli_query($db, "SELECT product_id FROM ep_product WHERE ep_id = $epId AND product_id ='" . $productId[$limit] . "'");

        if (mysqli_num_rows($checkResult) > 0) {
            // If product id already exist on po_product, UPDATE
            mysqli_query($db, "UPDATE ep_product SET ep_qty = '$qtyIn[$limit]', ep_price = '$itemPrice[$limit]', ep_totPrice= '$itemTotal[$limit]' WHERE ep_id = '$epId' AND product_id ='$productId[$limit]'");
        } else {
            // If product id dont exist on po_product, INSERT
            mysqli_query($db, "INSERT INTO ep_product(product_id, ep_id, ep_qty, ep_price, ep_totPrice) 
      VALUES ('$productId[$limit]','$epId','$qtyIn[$limit]','$itemPrice[$limit]','$itemTotal[$limit]')");
        }
        $limit++;
    }

    // editpo&id=2&supId=107&supName=A.F.%20SA

    header("location: ../ep_edit.php?editEp&updated&id=$epId&update=success");
}

// If po_edit-page.php update button is set
if (isset($_POST['cancelupdate'])) {
    header('location: ../ep-index.php');
}


// If stout_edit-page.php delete button is set
if (isset($_POST['delete'])) {
    $epId = $_POST['epId'];
    $productId = $_POST['productId'];

    require '../php/config.php';

    mysqli_query($db, "DELETE FROM ep_product WHERE ep_id = '$epId' AND product_id = '$productId'");

    echo "epId" . $epId . "productId" . $productId;
}

if (isset($_GET['updated'])) {
    echo
    '<script>
  alert("Successfully updated!");
  location.href = "ep_edit.php?editEp&id=' . $_GET['id'] . '";
  </script>';
}
