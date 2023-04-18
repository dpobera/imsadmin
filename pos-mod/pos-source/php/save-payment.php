<?php
date_default_timezone_set("Asia/Manila");
include 'config.php';

$paymentDetails = json_decode($_POST['json']);
$paymentTendered = $paymentDetails->tendered;
$balance = $paymentDetails->balance;
$change = $paymentDetails->change;
$paymentStatus = $paymentDetails->status;
$paymentDate = date("Y-m-d H:i:s");
$paymentType = $paymentDetails->type;
$orderId = $paymentDetails->orderId;
$paymentId = $paymentDetails->id;
$onlinePlatformId = $paymentDetails->platform;
$onlineReference = $paymentDetails->reference;
$onlinePaymentDate = $paymentDetails->paymentDate;
$bankId = $paymentDetails->bank;
$chequeNumber = $paymentDetails->chequeNumber;
$chequeDate = $paymentDetails->chequeDate;




if ($balance > 0) {
  //status = 1 (account receivable)
  mysqli_query($db, "INSERT INTO order_payment (payment_type_id, order_id, order_payment_debit, order_payment_date, order_payment_balance, payment_status_id) 
    VALUES ('$paymentType','$orderId','$paymentTendered','$paymentDate','$balance','1');");
}

if ($balance <= 0) {
  //status = 2 (fully paid)
  mysqli_query($db, "INSERT INTO order_payment (payment_type_id, order_id, order_payment_debit, order_payment_date, order_payment_balance, payment_status_id) 
    VALUES ('" . $paymentType  . "','" . $orderId . "','" . $paymentTendered . "','" . $paymentDate . "','" . $balance . "','2');");

  mysqli_query($db, "UPDATE order_tb SET order_status_id = '3' WHERE order_id = '$orderId'");
}

//change status to archived (meaning: previous or old)
mysqli_query($db, "UPDATE order_payment SET payment_status_id = '0' WHERE order_payment_id ='" . $paymentId . "'");

// Save Online Details
if ($paymentType === 2) {
  mysqli_query($db, "INSERT INTO online_payment (online_platform_id, online_payment_reference, online_payment_amount, online_payment_date, order_payment_id)
    VALUES('$onlinePlatformId', '$onlineReference', '$paymentTendered', '$onlinePaymentDate', '$paymentId')");
}

// Save Cheque Details
if ($paymentType === 3) {
  mysqli_query($db, "INSERT INTO cheque_payment (bank_id, cheque_number, cheque_date, cheque_amount, order_payment_id)
    VALUES('$bankId', '$chequeNumber', '$chequeDate', '$paymentTendered', '$paymentId')");
}


//send result  
$query3 = "SELECT * FROM order_payment ORDER BY order_payment_id DESC LIMIT 1";
$result = mysqli_query($db, $query3);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $output =  $row;
  };
}

echo json_encode($output);
