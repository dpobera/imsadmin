<?php

// IF Edit button Click from PO Main
if (isset($_GET['edit'])) {

    $stinId = $_GET['id'];

    require 'php/config.php';

    $result = mysqli_query(
        $db,
        "SELECT stin_tb.stin_id, stin_tb.stin_code, stin_tb.stin_title, stin_tb.stin_date, stin_tb.emp_id,
        stin_tb.stin_remarks, stin_product.product_id, stin_product.stin_temp_qty,  stin_product.stin_temp_cost, 
        stin_product.stin_temp_disamount, stin_product.stin_temp_tot, product.product_name, unit_tb.unit_name,
        employee_tb.emp_name,stin_product.stin_temp_remarks
 FROM stin_tb  
 LEFT JOIN stin_product ON stin_product.stin_id = stin_tb.stin_id
 LEFT JOIN product ON stin_product.product_id = product.product_id
 LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
 LEFT JOIN employee_tb ON stin_tb.emp_id = employee_tb.emp_id
 WHERE stin_tb.stin_id = '$stinId'
 ORDER BY stin_product.stin_product_id ASC"
    );


    // PO Details
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $stinId = $row['stin_id'];
            $stinCode = $row['stin_code'];
            $stinTitle = $row['stin_title'];
            $stinDate = $row['stin_date'];

            $empId = $row['emp_id'];
            $empName = $row['emp_name'];
            $stinRemarks = $row['stin_remarks'];
            $productId[] = $row['product_id'];
            $productName[] = $row['product_name'];
            $qtyIn[] = $row['stin_temp_qty'];
            $unitName[] = $row['unit_name'];
            $itemCost[] = $row['stin_temp_cost'];
            $itemRemarks[] = $row['stin_temp_remarks'];
        }
    } else {
        echo "0 results";
    }
}






// If po_edit-page.php update button is set
if (isset($_POST['update'])) {

    $stinId = $_POST['stinId'];
    $employeeId = $_POST['employeeId'];
    $stinTitle = $_POST['stinTitle'];
    $stinRemarks = $_POST['stinRemarks'];
    $stinDate = $_POST['stinDate'];
    $stinCode = $_POST['stinCode'];


    $productId = $_POST['productId'];
    $qtyIn = $_POST['qtyIn'];
    $itemCost = $_POST['itemCost'];
    $itemRemarks = $_POST['itemRemarks'];


    require '../php/config.php';

    // Update stin_tb
    if (!mysqli_query(
        $db,
        "UPDATE stin_tb SET emp_id ='$employeeId', stin_title = '$stinTitle', stin_code = '$stinCode', stin_remarks = '$stinRemarks',  stin_date = '$stinDate' 
    WHERE stin_id = '$stinId'"
    )) {
        printf("Error message: %s\n", mysqli_error($link));
    };


    // Update stin_tb
    $limit = 0;
    while (count($productId) !== $limit) {
        // Check product id from stin_product
        $checkResult = mysqli_query($db, "SELECT product_id FROM stin_product WHERE stin_id = $stinId AND product_id ='" . $productId[$limit] . "'");

        if (mysqli_num_rows($checkResult) > 0) {
            // If product id already exist on stin_product, UPDATE
            $sql = "UPDATE stin_product SET stin_temp_qty = '$qtyIn[$limit]', stin_temp_cost = '$itemCost[$limit]',stin_temp_remarks = '$itemRemarks[$limit]'  WHERE stin_id = '$stinId' AND product_id ='$productId[$limit]'";
        } else {
            // If product id dont exist on stin_product, INSERT
            if ($productId[$limit] != 0) {
                $sql = "INSERT INTO stin_product(product_id, stin_id, stin_temp_qty, stin_temp_cost) 
                VALUES ('$productId[$limit]','$stinId','$qtyIn[$limit]','$itemCost[$limit]')";
            }
        }

        mysqli_query($db, $sql);

        $limit++;
    }


    header("location: ../stin_edit.php?edit&updated&id=$stinId");
}








// If po_edit-page.php update button is set
if (isset($_POST['cancelupdate'])) {
    header('location: ../stin-index.php');
}


// If stin_edit-page.php delete button is set
if (isset($_POST['delete'])) {
    $poId = $_POST['stinId'];
    $productId = $_POST['productId'];

    require '../php/config.php';

    mysqli_query($db, "DELETE FROM stin_product WHERE stin_id = '$poId' AND product_id = '$productId'");

    echo "stinId" . $stinId . "productId" . $productId;
}

if (isset($_GET['updated'])) {
    echo
    '<script>
  alert("Successfully updated!");
  location.href = "stin_edit.php?edit&id=' . $_GET['id'] . '";
  </script>';
}
