<?php

// IF Edit button Click from STOUT Main
if (isset($_GET['edit'])) {

    $stoutId = $_GET['id'];

    require 'php/config.php';

    $result = mysqli_query(
        $db,
        "SELECT stout_tb.stout_id, stout_tb.stout_code, stout_tb.stout_title, stout_tb.stout_date, stout_tb.emp_id,
        stout_tb.stout_remarks, stout_product.product_id, stout_product.stout_temp_qty,  stout_product.stout_temp_cost, 
        stout_product.stout_temp_disamount, stout_product.stout_temp_tot, product.product_name, unit_tb.unit_name, product.barcode,
        employee_tb.emp_name, stout_product.stout_temp_remarks
 FROM stout_tb  
 LEFT JOIN stout_product ON stout_product.stout_id = stout_tb.stout_id
 LEFT JOIN product ON stout_product.product_id = product.product_id
 LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
 LEFT JOIN employee_tb ON stout_tb.emp_id = employee_tb.emp_id
 WHERE stout_tb.stout_id = '$stoutId' 
 ORDER BY stout_product.stout_product_id ASC"
    );


    // STOUT Details
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $stoutId = $row['stout_id'];
            $stoutCode = $row['stout_code'];
            $stoutTitle = $row['stout_title'];
            $stoutDate = $row['stout_date'];
            $empId = $row['emp_id'];
            $empName = $row['emp_name'];
            $stoutRemarks = $row['stout_remarks'];
            $productId[] = $row['product_id'];
            $productName[] = $row['product_name'];
            $qtyIn[] = $row['stout_temp_qty'];
            $barcode[] = $row['barcode'];
            $itemCost[] = $row['stout_temp_cost'];
            $itemRemarks[] = $row['stout_temp_remarks'];
            $unitName[] = $row['unit_name'];
        }
    } else {
        echo "0 results";
    }
}

// If stout_edit-page.php update button is set
if (isset($_POST['update'])) {

    $stoutId = $_POST['stoutId'];
    $empId = $_POST['empId'];
    $stoutTitle = $_POST['stoutTitle'];
    $stoutRemarks = $_POST['stoutRemarks'];
    $stoutDate = $_POST['stoutDate'];
    $stoutCode = $_POST['stoutCode'];


    $productId = $_POST['productId'];
    $qtyIn = $_POST['qtyIn'];
    $itemCost = $_POST['itemCost'];
    $itemRemarks = $_POST['itemRemarks'];


    require '../php/config.php';

    // Update stout_tb
    if (!mysqli_query(
        $db,
        "UPDATE stout_tb SET emp_id ='$empId', stout_title = '$stoutTitle', stout_code = '$stoutCode', stout_remarks = '$stoutRemarks',  stout_date = '$stoutDate' 
    WHERE stout_id = '$stoutId'"
    )) {
        printf("Error message: %s\n", mysqli_error($link));
    };


    // Update stout_tb
    $limit = 0;
    while (count($productId) !== $limit) {
        // Check product id from stout_product
        $checkResult = mysqli_query($db, "SELECT product_id FROM stout_product WHERE stout_id = $stoutId AND product_id ='" . $productId[$limit] . "'");

        if (mysqli_num_rows($checkResult) > 0) {
            // If product id already exist on stout_product, UPDATE
            $sql = "UPDATE stout_product SET stout_temp_qty = '$qtyIn[$limit]', stout_temp_cost = '$itemCost[$limit]', stout_temp_remarks = '$itemRemarks[$limit]'  WHERE stout_id = '$stoutId' AND product_id ='$productId[$limit]'";
        } else {
            // If product id dont exist on stout_product, INSERT
            if ($productId[$limit] != 0) {
                $sql = "INSERT INTO stout_product(product_id, stout_id, stout_temp_qty, stout_temp_cost) 
                VALUES ('$productId[$limit]','$stoutId','$qtyIn[$limit]','$itemCost[$limit]')";
            }
        }

        mysqli_query($db, $sql);

        $limit++;
    }


    header("location: ../stout_edit.php?edit&updated&id=$stoutId");
}

// If po_edit-page.php update button is set
if (isset($_POST['cancelupdate'])) {
    header('location: ../stout-index.php');
}


// If stout_edit-page.php delete button is set
if (isset($_POST['delete'])) {
    $stoutId = $_POST['stoutId'];
    $productId = $_POST['productId'];

    require '../php/config.php';

    mysqli_query($db, "DELETE FROM stout_product WHERE stout_id = '$stoutId' AND product_id = '$productId'");

    echo "stoutId" . $stoutId . "productId" . $productId;
}

if (isset($_GET['updated'])) {
    echo
    '<script>
  alert("Successfully updated!");
  location.href = "stout_edit.php?edit&id=' . $_GET['id'] . '";
  </script>';
}
