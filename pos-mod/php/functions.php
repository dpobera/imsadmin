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


function getPaymentBalance($db, $joId)
{
    $qry = "SELECT 
            order_payment.order_payment_balance,
            order_payment.order_payment_id  
            FROM order_payment 
            LEFT JOIN order_tb ON order_tb.order_id = order_payment.order_id
            WHERE order_payment.jo_id = '$joId' ORDER BY order_payment_id  DESC LIMIT 1";

    $result = mysqli_query($db, $qry);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        return $row['order_payment_balance'];
    } else {
        return 0;
    }
}

function getJobOrderData($db, $filter = '')
{


    $qry = "SELECT jo_tb.jo_id, jo_tb.jo_no, customers.customers_name, employee_tb.emp_name, jo_tb.jo_date, jo_tb.closed, user.user_name, jo_tb.jo_type_id, jo_type.jo_type_name, jo_tb.jo_status_id,customers_company
    FROM jo_tb
    LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id
    LEFT JOIN user ON user.user_id = jo_tb.user_id
    LEFT JOIN employee_tb ON employee_tb.emp_id = jo_tb.emp_id
    LEFT JOIN jo_type ON jo_type.jo_type_id = jo_tb.jo_type_id
    LEFT JOIN jo_status ON jo_status.jo_status_id = jo_tb.jo_status_id
    ";

    if ($filter != '') {
        $qry .= " " . "$filter";
    }

    $result = mysqli_query($db, $qry);

    if (mysqli_num_rows($result) > 0) {
        $output = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        return $output;
    } else {
        return [];
    }
}
