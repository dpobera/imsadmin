
<?php

include "../../php/config.php";


if (isset($_GET['id'])) {

    $poId = $_GET['poId'];
    $id = $_GET['id'];


    $result = mysqli_query($db, "DELETE FROM po_product 
                                 WHERE product_id = '$id' 
                                 AND
                                 po_id = '$poId'");
    if ($result == true)
        mysqli_close($db); // Close connection

    header('Location: ' . $_SERVER['HTTP_REFERER']);

    exit;
}



?>