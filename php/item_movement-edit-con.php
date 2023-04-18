<?php

if (isset($_GET['update'])) {
    $prodId = $_GET['prodId'];
    $balQty = $_GET['balQty'];
    $inQty = $_GET['inQty'];
    $outQty = $_GET['outQty'];
    $ref = $_GET['ref'];
    $movId = $_GET['movId'];


    require '../php/config.php';

    // Update po_tb
    mysqli_query(
        $db,
        "UPDATE move_product
        SET product_id='$prodId', 
            bal_qty='$balQty',
            in_qty='$inQty',
            out_qty='$outQty',
            move_ref='$ref'
            
            WHERE move_id='$movId' "
    );
}


header("location: ../itemlist-index.php");


// If stout_edit-page.php delete button is set
// if (isset($_POST['delete'])) {
//     $epId = $_POST['epId'];
//     $productId = $_POST['productId'];

//     require '../php/config.php';

//     mysqli_query($db, "DELETE FROM ep_product WHERE ep_id = '$epId' AND product_id = '$productId'");

//     echo "epId" . $epId . "productId" . $productId;
// }
