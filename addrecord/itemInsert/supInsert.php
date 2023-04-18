<?php

// connect to the database
include_once "../../php/config.php";
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


// Add item
if (isset($_POST['add_sup'])) {
    // receive all input values from the form

    $sup_name = mysqli_real_escape_string($db, $_POST['sup_name']);
    $sup_conper = mysqli_real_escape_string($db, $_POST['sup_conper']);
    $sup_tel = mysqli_real_escape_string($db, $_POST['sup_tel']);
    $sup_address = mysqli_real_escape_string($db, $_POST['sup_address']);
    $sup_email = mysqli_real_escape_string($db, $_POST['sup_email']);
    $sup_tin = mysqli_real_escape_string($db, $_POST['sup_tin']);
    $tax_type_id = mysqli_real_escape_string($db, $_POST['tax_type_id']);

    $query = "INSERT INTO sup_tb (sup_name,sup_conper,sup_tel,sup_address,sup_email,sup_tin,tax_type_id) 
  			  VALUES('$sup_name','$sup_conper','$sup_tel','$sup_address','$sup_email','$sup_tin','$tax_type_id')";

    if (mysqli_query($db, $query)) {
    } else {
        echo "<script>alert('Something wrong!!!');</script>";
    }
}
echo "<script>
alert('Record added successfully !');
location.href = '../../sup-index.php';
</script>";
