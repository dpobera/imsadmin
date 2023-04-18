<?php
session_start();
include('../php/config.php');
if (isset($_GET['inv_number']) && is_numeric($_GET['inv_number']) && $_GET['inv_number'] > 0) {

    $inv_number = $_GET['inv_number'];

    $result = mysqli_query($db, "SELECT invoice.invoice_id,invoice.invoice_number,dr_inv.dr_number,customers.customers_name,customers.customers_address,invoice.invoice_date,user.user_name,customers.customers_tin,customers.tax_type_id
    FROM invoice 
    LEFT JOIN user ON user.user_id = invoice.user_id 
    LEFT JOIN dr_inv ON dr_inv.inv_number = invoice.invoice_number 
    LEFT JOIN dr_products ON dr_products.dr_number = dr_inv.dr_number 
    LEFT JOIN jo_product ON dr_products.jo_product_id = jo_product.jo_product_id 
    LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id 
    LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id 
    LEFT JOIN tax_type_tb ON customers.tax_type_id = tax_type_tb.tax_type_id
    WHERE invoice.invoice_number=" . $_GET['inv_number']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $dr_number[] = $row['dr_number'];
        $invoice_number = $row['invoice_number'];
        $customerName = $row['customers_name'];
        $customerAdd = $row['customers_address'];
        $customerTin = $row['customers_tin'];
        $taxId = $row['tax_type_id'];

        $dateString = $row['invoice_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
        $user_name = $row['user_name'];
    } else {
        echo "No results!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Invoice</title>
    <link rel="stylesheet" href="../css/si_print.css">
</head>

<body>
    <div class="dr_paper" style="position: relative;">
        <p style="position: absolute;left:2.5cm;top:4cm;margin:0;"><?php echo $customerName ?></p>
        <p style="position: absolute;left:2.5cm;top:4.6cm;margin:0;"><?php echo $customerTin ?> </p>
        <p style="position: absolute;left:2.5cm;top:5.3cm;margin:0; font-size:small;width:60%"><?php echo $customerAdd ?></p>
        <p style="position: absolute;left:16cm;top:4cm;margin:0;"><?php echo $date ?></p>
        <!-- dr No. -->
        <p style="position: absolute;left:16cm;top:4.6cm;margin:0;width:4cm;height:1.2cm;"><?php echo implode(", ", $dr_number) ?></p>

        <div class="dr_table">
            <table class="items" style="position: absolute;">

                <tbody>

                    <?php

                    $dr_number = implode(",", $dr_number);
                    $sql = "SELECT jo_product.jo_product_id,product.product_name,dr_products.dr_product_qty,jo_product.jo_product_price,unit_tb.unit_name
                    FROM dr_products
                    LEFT JOIN jo_product ON dr_products.jo_product_id = jo_product.jo_product_id
                    LEFT JOIN product ON product.product_id = jo_product.product_id
                    LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id
                    WHERE dr_products.dr_number IN ('$dr_number')";
                    $result = $db->query($sql);
                    $count = 0;

                    if ($result->num_rows >  0) {

                        while ($irow = $result->fetch_assoc()) {

                            $limit = 0;
                            $qty = $irow["dr_product_qty"];
                            $price = $irow["jo_product_price"];
                            // $productId = $irow["product_id"];
                            $total[] = $qty * $price;





                    ?>
                            <tr>
                                <td style="width: 2.2cm;height:0.7cm;text-align:left"><?php echo number_format($qty, 2) ?><?php echo $irow['unit_name'] ?>
                                </td>
                                <td style="font-size: 12.8px;width: 12.8cm;"><?php echo $irow['product_name'] ?></td>
                                <td class='label--price' style="width: 1.9cm;text-align:right;font-size: 12.8px">
                                    <?php echo number_format($price, 0)  ?></td>
                                <td>/<?php echo $irow['unit_name'] ?></td>
                                <td style="width: 0.95cm;"></td>
                                <td class='label--subtotal text-end' style="width: 2.5cm;;font-size: 12.8px">
                                    <?php echo number_format($qty * $price, 2) ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>

                <!-- <tr>
                    <td style="width: 2.2cm;height:0.7cm;text-align:center">1pcs</td>
                    <td style="font-size: 12.8px;width: 12.8cm;">Test Item</td>
                    <td style="width: 1.9cm;text-align:right;font-size: 12.8px">99/pcs</td>
                    <td style="width: 0.95cm;"></td>
                    <td style="width: 2.5cm;;font-size: 12.8px">&#8369;99.00</td>
                </tr> -->

            </table>
        </div>
        <?php
        if ($taxId == 1) {
            $subTot = 0;
            $disTot = 0;

            while ($limit != count($total)) {
                $subTot += $total[$limit];
                // $disTot += $totaldisamount[$limit];
                $limit += 1;
            }

            $grandTotal = $subTot - $disTot;
            // $anv = $grandTot / 112;
            // $anvv = $anv * 100;
            // $av = $grandTot - $anvv;
            $amountNetVat  = $grandTotal / 1.12;
            $addVat = $grandTotal - $amountNetVat;


            echo ' <p style="position: absolute;top:15.1cm;left:18cm;font-size: 12.8px">' . number_format($amountNetVat, 2) . '</p>
            <p style="position: absolute;top:16.3cm;left:18cm;font-size: 12.8px">' . number_format($addVat, 2) . '</p>
            <p style="position: absolute;top:16.9cm;left:18cm;font-size: 12.8px">' . number_format($grandTotal, 2) . '</p>';
        } else {
            $grandTotal = $total[$limit];
            echo ' <p style="position: absolute;top:15.9cm;left:12cm;font-size: 12.8px">' . number_format($grandTotal, 2) . '</p>';
        }
        ?>


    </div>
    </div>
</body>

</html>