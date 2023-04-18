<?php

// connect to the database
include "../../php/config.php";
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


// Add item
if (isset($_GET['add'])) {
    // receive all input values from the form
    echo "connect";
    $prodId = mysqli_real_escape_string($db, $_GET['product_id']);
    $product_name = mysqli_real_escape_string($db, $_GET['product_name']);
    $class_id = mysqli_real_escape_string($db, $_GET['class_id']);
    $qty = mysqli_real_escape_string($db, $_GET['qty']);
    $unit_id = mysqli_real_escape_string($db, $_GET['unit_id']);
    $remarks = mysqli_real_escape_string($db, $_GET['remarks']);
    $location = mysqli_real_escape_string($db, $_GET['loc_id']);
    $barcode = mysqli_real_escape_string($db, $_GET['barcode']);
    $price = mysqli_real_escape_string($db, $_GET['price']);
    $cost = mysqli_real_escape_string($db, $_GET['cost']);
    $dept_id = mysqli_real_escape_string($db, $_GET['dept_id']);
    // $sup_id = mysqli_real_escape_string($db, $_GET['sup_id']);
    $product_type_id = mysqli_real_escape_string($db, $_GET['product_type_id']);
    $move_id = mysqli_real_escape_string($db, $_GET['move_id']);




    $query = "INSERT INTO product (product_id,product_name,class_id,qty,unit_id,pro_remarks,loc_id,barcode,price,cost,dept_id,sup_id,product_type_id) 
  			  VALUES('$prodId','$product_name','$class_id','$qty','$unit_id','$remarks','$location','$barcode','$price','$cost','$dept_id','14','$product_type_id')";


    if (mysqli_query($db, $query)) {
        $last_id = mysqli_insert_id($db);

        // product_id	bal_qty	in_qty	out_qty	mov_type_id	move_ref	mov_date	

        mysqli_query($db, "INSERT INTO move_product (move_id,product_id, bal_qty, in_qty, out_qty, mov_type_id, move_ref, mov_date)
    VALUES('$move_id','$prodId', '$qty', '$qty', '0', '5', 'Beginning','" . date('Y-m-d') . "')");

        echo date('Y-m-d');

        echo '<script type="text/javascript"> alert("Data Inserted Successfully!"); </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }
    echo "<script type='text/javascript'>alert('New Record Added!');
      location.href = '../../itemlist-index.php";
    header('location: ../../itemlist-index.php');
}
