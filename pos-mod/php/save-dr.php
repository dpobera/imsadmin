<?php


if (isset($_GET['saveDr'])) {
    $drNumber = $_GET['drNumber'];
    $orderId = $_GET['orderId'];

    require_once "config.php";

    // Insert new DR
    $qryInsertDr = "INSERT INTO delivery_receipt (dr_number) VALUES ('$drNumber')";
    mysqli_query($db, $qryInsertDr);

    // Update order table
    $qryUpdateOrder = "UPDATE order_tb SET dr_number = '$drNumber' WHERE order_id = '$orderId'";
    mysqli_query($db, $qryUpdateOrder);

    echo $orderId;
}
