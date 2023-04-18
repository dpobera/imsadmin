<?php

// connect to the database
include "../../php/config.php";
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


// Add item
if (isset($_POST['addUnit'])) {
    // receive all input values from the form
    // echo "connect";
    $unit_name = mysqli_real_escape_string($db, $_POST['unit_name']);
    $unit_id = mysqli_real_escape_string($db, $_POST['unit_id']);

    $query = "INSERT INTO unit_tb (unit_name) 
          VALUES('$unit_name')";

    if (mysqli_query($db, $query)) {
        echo "<script type='text/javascript'>alert('Update Records Successfully!');
                                    location.href ='../../unit-index.php'</script>";
    } else {
        echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }
}
