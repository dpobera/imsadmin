<?php

function getJoTotalQty($db, $joId)
{
    $totalJoQty = 0;

    $joSelect = mysqli_query(
        $db,
        "SELECT jo_product.product_id, jo_product.jo_product_qty, jo_product.jo_product_price,
        jo_tb.jo_id, jo_tb.jo_no, product.product_name, unit_tb.unit_name
        FROM jo_product
        LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id
        LEFT JOIN product ON jo_product.product_id = product.product_id
        LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id
        WHERE jo_tb.jo_id='$joId'"
    );

    if (mysqli_num_rows($joSelect) > 0) {
        while ($row = mysqli_fetch_assoc($joSelect)) {
            $totalJoQty += $row['jo_product_qty'];
        }
    }

    return (int)$totalJoQty;
}

function getOrderTotalQty($db, $joId)
{
    $totalOrderQty = 0;

    $orderSelect = mysqli_query(
        $db,
        "SELECT 
        order_tb.order_id, 
        order_product.product_id, 
        order_product.pos_temp_qty,
        order_tb.jo_id
        FROM order_product 
        LEFT JOIN order_tb AS order_tb ON order_tb.order_id = order_product.order_id
        WHERE order_tb.jo_id = '$joId'"
    );

    if (mysqli_num_rows($orderSelect) > 0) {
        while ($row = mysqli_fetch_assoc($orderSelect)) {
            $totalOrderQty += $row['pos_temp_qty'];
        }
    }

    return (int)$totalOrderQty;
}

function closeJo($db, $joId)
{
    mysqli_query($db, "UPDATE jo_tb SET closed ='1' WHERE jo_id ='$joId'");
}


function getOnlinePlatforms($db)
{
    $result = mysqli_query($db, 'SELECT * FROM online_platform');
    if (!$result) {
        echo 'Error on query';
        return;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $output[] = $row;
    }

    return $output;
}
