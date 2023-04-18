
<?php

include "../../php/config.php";


if (isset($_GET['id'])) {

    $stoutId = $_GET['stoutId'];
    $id = $_GET['id'];


    $result = mysqli_query($db, "DELETE FROM stout_product 
                                 WHERE product_id = '$id' 
                                 AND
                                 stout_id = '$stoutId'");
    if ($result == true)
        mysqli_close($db); // Close connection

    header('Location: ../stout_edit.php?id=' . $stoutId);


    exit;
}



?>