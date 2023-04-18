<?php
include('fetch/config.php');
$product_name = $_POST['product_name'];
$class_id = $_POST['class_id'];
$qty = $_POST['qty'];
$unit_id = $_POST['unit_id'];
$pro_remarks = $_POST['pro_remarks'];
$loc_id = $_POST['loc_id'];
$barcode = $_POST['barcode'];
$price = $_POST['price'];
$cost = $_POST['cost'];
$dept_id = $_POST['dept_id'];
$sup_id = $_POST['sup_id'];
$product_type_id = $_POST['product_type_id'];


$sql = "INSERT INTO product (product_name,class_id,qty,unit_id,pro_remarks,loc_id,barcode,price,cost,dept_id,sup_id,product_type_id) 
  			  VALUES('$product_name','$class_id','$qty','$unit_id','$pro_remarks','$location','$barcode','$price','$cost','$dept_id','$sup_id','$product_type_id')";
$query = mysqli_query($con, $sql);
$lastId = mysqli_insert_id($con);
if ($query == true) {

    $data = array(
        'status' => 'true',

    );

    echo json_encode($data);
} else {
    $data = array(
        'status' => 'false',

    );

    echo json_encode($data);
}
