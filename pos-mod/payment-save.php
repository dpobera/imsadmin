<?php

if (isset($_POST['submit'])) {

    include "./php/Payment.php";

    $payment = new Payments($_GET['jo_id']);

    if (!$payment->savePayment($_POST)) {
        echo "Something went wrong";
        return false;
    }

    return header("Location: index.php");
}
