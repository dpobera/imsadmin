<?php

if (isset($_POST['save'])) {

    include './Invoice.php';

    session_start();
    $user_id = $_SESSION['id'];

    $dr_number = $_GET['dr_number'];
    $invoice = new Invoice($_POST['invoice_number']);

    // If invoice already exist, return to pos-si-items.php
    if ($invoice->checkDuplicateInvoice()) {
        $param = http_build_query(array('dr_number' => $dr_number));
        $error = 'duplicate_invoice';
        header("Location: ../pos-si-items.php?next&$param&error=$error&invoice_number=$invoice->invoice_number");
        exit();
    }


    // 1) Save Invoice number to Invoice_table
    // 2) Save dr number to invoice_dr table
    $invoice->saveInvoice($user_id, $dr_number);

    header("Location: ../print_si.php?" . http_build_query(array('dr_number' => $dr_number)));

    // // Back to Sales invoice Customer selection
    // echo "
    // <script>
    //     alert('Transaction Saved!');
    //     location.replace('../print-si.php?$');
    // </script>";
    // // header("Location: ../pos-si.php?status=saved");
}
