<?php

// IF Edit button Click from PO Main
if (isset($_GET['edit'])) {

    $rtId = $_GET['id'];

    require 'php/config.php';

    $result = mysqli_query(
        $db,
        "SELECT rt_tb.rt_id, rt_tb.rt_no, rt_tb.rt_date, rt_tb.rt_reason, rt_tb.rt_note, customers.customers_name, customers.customers_id, rt_tb.rt_driver, rt_tb.rt_guard, product.product_name, product.product_id, unit_tb.unit_name, rt_product.rt_qty
        FROM rt_tb 
        LEFT JOIN rt_product ON rt_product.rt_id = rt_tb.rt_id
        LEFT JOIN product ON rt_product.product_id = product.product_id 
        LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
        LEFT JOIN customers ON customers.customers_id = rt_tb.customers_id
        WHERE rt_tb.rt_id = '$rtId'"
    );


    // PO Details
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $rtId = $row['rt_id'];
            $rtNo = $row['rt_no'];
            $rtDriver = $row['rt_driver'];
            $rtGuard = $row['rt_guard'];
            $rtReason = $row['rt_reason'];
            $rtNote = $row['rt_note'];
            $rtDate = $row['rt_date'];
            $cusName = $row['customers_name'];
            $cusId = $row['customers_id'];

            $productId[] = $row['product_id'];
            $productName[] = $row['product_name'];
            $qtyIn[] = $row['rt_qty'];
            $unitName[] = $row['unit_name'];
        }
    } else {
        echo "0 results";
    }
}

// If po_edit-page.php update button is set
if (isset($_POST['update'])) {

    $rtId = number_format($_POST['rtId']);
    $rtNo = $_POST['rtNo'];
    $rtDriver = $_POST['rtDriver'];
    $rtGuard = $_POST['rtGuard'];
    $rtReason = $_POST['rtReason'];
    $rtNote = $_POST['rtNote'];
    $rtDate = $_POST['rtDate'];
    $cusId = $_POST['cusId'];

    $productId = $_POST['productId'];
    $qtyIn = $_POST['qtyIn'];
    // $itemCost = $_POST['itemCost'];


    require '../php/config.php';

    // Update stin_tb
    if (!mysqli_query(
        $db,
        "UPDATE rt_tb 
         SET rt_no = '$rtNo', rt_date = '$rtDate', rt_reason = '$rtReason', rt_note = '$rtNote', customers_id = '$cusId', rt_driver = '$rtDriver', rt_guard = '$rtGuard'
         WHERE rt_id = '$rtId'"
    )) {
        printf("Error message: %s\n", mysqli_error($link));
    };


    // Update stin_tb
    $limit = 0;
    while (count($productId) !== $limit) {
        // Check product id from stin_product
        $checkResult = mysqli_query($db, "SELECT product_id FROM rt_product WHERE rt_id = $rtId AND product_id ='" . $productId[$limit] . "'");

        if (mysqli_num_rows($checkResult) > 0) {
            // If product id already exist on stin_product, UPDATE
            $sql = "UPDATE rt_product SET rt_qty = '$qtyIn[$limit]'  WHERE rt_id = '$rtId' AND product_id ='$productId[$limit]'";
        } else {
            // If product id dont exist on stin_product, INSERT
            if ($productId[$limit] != 0) {
                $sql = "INSERT INTO rt_product(product_id, rt_id, rt_qty) 
                VALUES ('$productId[$limit]','$rtId','$qtyIn[$limit]')";
            }
        }

        mysqli_query($db, $sql);

        $limit++;
    }


    header("location: ../rt_edit.php?edit&updated&id=$rtId");
}

// If po_edit-page.php update button is set
if (isset($_POST['cancelupdate'])) {
    header('location: ../rt-index.php');
}


// If stin_edit-page.php delete button is set
if (isset($_POST['delete'])) {
    $rtId = $_POST['rtId'];
    $productId = $_POST['productId'];

    require '../php/config.php';

    mysqli_query($db, "DELETE FROM rt_product WHERE rt_id = '$rtId' AND product_id = '$productId'");

    echo "rtId" . $rtId . "productId" . $productId;
}

if (isset($_GET['updated'])) {
    echo
    '<script>
  alert("Successfully updated!");
  location.href = "rt_edit.php?edit&id=' . $_GET['id'] . '";
  </script>';
}
