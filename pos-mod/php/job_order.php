<?php

include 'config.php';

$joQry = "SELECT 
        jo_tb.jo_id, 
        jo_tb.jo_no, 
        jo_tb.customers_id, 
        jo_tb.emp_id, 
        jo_tb.jo_date, 
        jo_tb.user_id, 
        jo_tb.closed, 
        jo_tb.jo_type_id
        FROM jo_tb";

$joResult = mysqli_query($db, $joQry);

if (mysqli_num_rows($joResult) > 0) {
    while ($joRow = mysqli_fetch_assoc($joResult)) {

        $jo_id = $joRow['jo_id'];
        $jo_no = $joRow['jo_no'];
        $customers_id = $joRow['customers_id'];
        $emp_id = $joRow['emp_id'];
        $jo_date = $joRow['jo_date'];
        $user_id = $joRow['user_id'];
        $closed = $joRow['closed'];
        $jo_type_id = $joRow['jo_type_id'];
        $jo_items = [];
        $jo_amount = 0;
        $jo_balance = $jo_amount;

        // Query for JO Products
        $joProdQry = "SELECT 
                    jo_product.product_id, 
                    jo_product.jo_product_qty, 
                    jo_product.jo_product_price, 
                    jo_product.jo_remarks 
                    FROM jo_product  
                    WHERE jo_id =" . $joRow['jo_id'];

        $joProdResult = mysqli_query($db, $joProdQry);

        if (mysqli_num_rows($joProdResult) > 0) {
            while ($joProdRow = mysqli_fetch_assoc($joProdResult)) {
                $item_total = $joProdRow['jo_product_qty'] * $joProdRow['jo_product_price'];
                $jo_amount += $item_total;
                // Add JO product into JO JSON
                $joRow['items'][] = $joProdRow;
                $jo_items[] = $joProdRow;
            }
        }
        $joRow['jo_total'] = $jo_amount;



        // Query for Balance
        $balanceQry = "SELECT order_payment.order_payment_id, order_tb.jo_id, 
                    order_payment.order_id, order_payment.order_payment_balance
                    FROM order_tb 
                    LEFT JOIN order_payment ON order_payment.order_id = order_tb.order_id
                    WHERE order_tb.jo_id = '$jo_id' ORDER BY order_payment.order_payment_id DESC";

        $balanceResult = mysqli_query($db, $balanceQry);

        if (mysqli_num_rows($balanceResult) > 0) {
            $balanceRow = mysqli_fetch_assoc($balanceResult);
            $jo_balance = $balanceRow['order_payment_balance'];
        }
        $joRow['jo_balance'] = $jo_balance;

        // Output
        $output[] = $joRow;
    }
}

echo json_encode($output);
