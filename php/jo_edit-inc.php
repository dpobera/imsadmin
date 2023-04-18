<?php

// IF Edit button Click from PO Main
if (isset($_GET['editJo'])) {

    $joId = $_GET['id'];


    require 'config.php';

    $result = mysqli_query(
        $db,
        "SELECT jo_tb.jo_id, jo_tb.jo_no, jo_tb.jo_date, customers.customers_name, customers.customers_id, jo_product.product_id, jo_product.jo_product_qty, jo_product.jo_product_price, product.product_name, unit_tb.unit_name, unit_tb.unit_id, employee_tb.emp_name, employee_tb.emp_id, jo_tb.jo_type_id, jo_type.jo_type_name, jo_type.jo_type_id,customers_company,jo_tb.jo_remarks
        FROM jo_tb
        LEFT JOIN jo_product ON jo_product.jo_id = jo_tb.jo_id
        LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id
        LEFT JOIN product ON jo_product.product_id = product.product_id
        LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
        LEFT JOIN employee_tb ON employee_tb.emp_id = jo_tb.emp_id
        LEFT JOIN jo_type ON jo_type.jo_type_id = jo_tb.jo_type_id
        WHERE jo_tb.jo_id ='$joId'
        ORDER BY jo_product.jo_product_id DESC"
    );



    // PO Details
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $customerName = $row['customers_company'];
            $customerId = $row['customers_id'];
            $joNo = $row['jo_no'];
            $empName = $row['emp_name'];
            $empId = $row['emp_id'];
            $joDate = $row['jo_date'];
            $jo_type_id = $row['jo_type_id'];
            $jo_type_name = $row['jo_type_name'];
            $productId[] = str_pad($row['product_id'], 8, 0, STR_PAD_LEFT);
            $productName[] = $row['product_name'];
            $qtyIn[] = $row['jo_product_qty'];
            $unitId[] = $row['unit_id'];
            $unitName[] = $row['unit_name'];
            $itemPrice[] = $row['jo_product_price'];
            $remarks = $row['jo_remarks'];
        }
    } else {
        echo "0 results";
    }
}

// If po_edit-page.php update button is set
if (isset($_POST['update'])) {
    $joId = $_POST['joId'];
    $customerId = $_POST['customerId'];
    $joNo = $_POST['joNo'];
    $joDate = $_POST['joDate'];
    $empId = $_POST['empId'];
    $remarks = $_POST['jo_remarks'];
    $jo_type_id = $_POST['jo_type_id'];
    $productId = $_POST['productId'];
    $qtyIn = $_POST['qtyIn'];
    $itemPrice = $_POST['itemPrice'];


    require 'config.php';

    // Update po_tb
    mysqli_query(
        $db,
        "UPDATE jo_tb SET jo_no='$joNo', customers_id='$customerId', emp_id='$empId',  jo_date='$joDate', jo_type_id='$jo_type_id', jo_remarks='$remarks'
        WHERE jo_id='$joId' "
    );


    // Update po_product
    $limit = 0;
    while (count($productId) !== $limit) {
        // Check product id from po_product
        $checkResult = mysqli_query($db, "SELECT product_id FROM jo_product WHERE jo_id = $joId AND product_id ='" . $productId[$limit] . "'");

        if (mysqli_num_rows($checkResult) > 0) {
            // If product id already exist on po_product, UPDATE
            mysqli_query($db, "UPDATE jo_product SET jo_product_qty = '$qtyIn[$limit]', jo_product_price = '$itemPrice[$limit]' WHERE jo_id = '$joId' AND product_id ='$productId[$limit]'");
        } else {
            // If product id dont exist on po_product, INSERT
            // If product id dont exist on po_product, INSERT
            mysqli_query($db, "INSERT INTO jo_product(product_id, jo_id, jo_product_qty, jo_product_price) 
            VALUES ('$productId[$limit]','$joId','$qtyIn[$limit]','$itemPrice[$limit]')");
        }
        $limit++;
    }

    // editpo&id=2&supId=107&supName=A.F.%20SA

    header("location: ../jo_edit.php?editJo&updated&id=$joId&update=success");
}

// If po_edit-page.php update button is set
if (isset($_POST['cancelupdate'])) {
    header('location: ../jo_main.php');
}


// If stout_edit-page.php delete button is set
if (isset($_POST['delete'])) {
    $joId = $_POST['joId'];
    $productId = $_POST['productId'];

    require '../php/config.php';

    mysqli_query($db, "DELETE FROM jo_product WHERE jo_id = '$joId' AND product_id = '$productId'");

    echo "joId" . $joId . "productId" . $productId;
}

if (isset($_GET['updated'])) {
    echo
    '<script>
      alert("Record updated !");
      location.href = "jo_edit.php?editJo&id=' . $_GET['id'] . '";
      </script>';
}
