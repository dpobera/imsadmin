<?php

if (isset($_GET['checkDr'])) {
    $orderId = $_GET['orderId'];

    require_once "config.php";

    $qry = "SELECT * FROM order_tb WHERE order_id = '$orderId' LIMIT 1";
    $result = mysqli_query($db, $qry);


    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output =  $row['dr_number'];
        }
    }

    echo $output;
}
