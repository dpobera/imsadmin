<?php

// connect to the database
include "../../php/config.php";
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


// Add item
if (isset($_POST['addDept'])) {
    // receive all input values from the form
    // echo "connect";
    $dept_name = mysqli_real_escape_string($db, $_POST['dept_name']);
    $dept_id = mysqli_real_escape_string($db, $_POST['dept_id']);

    $query = "INSERT INTO dept_tb (dept_name) 
          VALUES('$dept_name')";

    if (mysqli_query($db, $query)) {
        echo "<script type='text/javascript'>alert('Update Records Successfully!');
                                    location.href ='../../dept-index.php'</script>";
    } else {
        echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }
}
