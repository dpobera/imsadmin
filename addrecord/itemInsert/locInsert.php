<?php

// connect to the database
include "../../php/config.php";
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


// Add item
if (isset($_POST['addLoc'])) {
    // receive all input values from the form
    // echo "connect";
    $loc_name = mysqli_real_escape_string($db, $_POST['loc_name']);
    $loc_id = mysqli_real_escape_string($db, $_POST['loc_id']);

    $query = "INSERT INTO loc_tb (loc_name) 
          VALUES('$loc_name')";

    if (mysqli_query($db, $query)) {
        echo "<script type='text/javascript'>alert('Update Records Successfully!');
                                    location.href ='../../loc-index.php'</script>";
    } else {
        echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }
}
