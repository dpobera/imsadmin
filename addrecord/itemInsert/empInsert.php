<?php

// connect to the database
include "../../php/config.php";
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


// Add item
if (isset($_POST['addEmp'])) {
    // receive all input values from the form
    // echo "connect";
    $emp_name = mysqli_real_escape_string($db, $_POST['emp_name']);
    $dept_id = mysqli_real_escape_string($db, $_POST['dept_id']);

    $query = "INSERT INTO employee_tb (emp_name, dept_id) 
    VALUES('$emp_name','$dept_id')";

    if (mysqli_query($db, $query)) {
        echo "<script type='text/javascript'>alert('Update Records Successfully!');
                                    location.href ='../../emp-index.php'</script>";
    } else {
        echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }
}
