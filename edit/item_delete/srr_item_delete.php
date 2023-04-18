
<?php

include "../../php/config.php";


if (isset($_GET['id'])) {

    $srrId = $_GET['srrId'];
    $id = $_GET['id'];


    $result = mysqli_query($db, "DELETE FROM srr_product 
                                 WHERE product_id = '$id' 
                                 AND
                                 srr_id = '$srrId'");
    if ($result == true)
        mysqli_close($db); // Close connection

    header('Location: ../../srr_main.php');

    exit;
}

?>