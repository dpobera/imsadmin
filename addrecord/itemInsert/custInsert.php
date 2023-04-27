<?php
include '../../php/config.php';
if (isset($_POST['addcus'])) {
    // receive all input values from the form
    echo "connect";
    $customers_company = mysqli_real_escape_string($db, $_POST['customers_company']);
    $customers_name = mysqli_real_escape_string($db, $_POST['customers_name']);
    $customers_address = mysqli_real_escape_string($db, $_POST['customers_address']);
    $customers_contact = mysqli_real_escape_string($db, $_POST['customers_contact']);
    $customers_note = mysqli_real_escape_string($db, $_POST['customers_note']);
    $customers_tin = mysqli_real_escape_string($db, $_POST['customers_tin']);
    $tax_type_id = mysqli_real_escape_string($db, $_POST['tax_type_id']);


    $query = "INSERT INTO customers (customers_company,customers_name,customers_address,customers_contact,customers_note,customers_tin,tax_type_id) 
                  VALUES('$customers_company','$customers_name','$customers_address','$customers_contact','$customers_note','$customers_tin','$tax_type_id')";

    if (mysqli_query($db, $query)) {

        echo "<script>
        alert('Record Created Successfully!');
        location.href = '../../cust-index.php';
        </script>";
    } else {
        echo "<script>alert('Failed to create record !');</script>";
    }
}
