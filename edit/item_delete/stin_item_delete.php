
<?php

include "../../php/config.php";


if (isset($_GET['id'])) {

    $stinId = $_GET['stinId'];
    $id = $_GET['id'];


    $result = mysqli_query($db, "DELETE FROM stin_product 
                                 WHERE product_id = '$id' 
                                 AND
                                 stin_id = '$stinId'");
    if ($result == true)
        mysqli_close($db); // Close connection

    header('Location: ../stin_edit.php?id=' . $stinId);

    exit;
}



?>