<?php

include "./php/Delivery.php";

$dr_number = $_GET['dr_number'];

$dr = new Delivery();
$customer = $dr->getCustomerDetails(implode(",", $dr_number));
$taxId = $customer['tax_type_id'];
// echo $taxId;
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
        <p style="position: absolute;left:2.5cm;top:4cm;margin:0;"><?php echo $customer['customers_name'] ?></p>
        <p style="position: absolute;left:2.5cm;top:4.6cm;margin:0;"><?php echo $customer['customers_tin'] ?> </p>
        <p style="position: absolute;left:2.5cm;top:5.3cm;margin:0; font-size:small;width:60%"><?php echo $customer['customers_address'] ?></p>
        <p style="position: absolute;left:16cm;top:4cm;margin:0;"><?php echo date("F d, Y") ?></p>
        <!-- dr No. -->
        <p style="position: absolute;left:16cm;top:4.6cm;margin:0;width:4cm;height:1.2cm;"><?php echo implode(", ", $dr_number) ?></p>

        <div class="dr_table">
            <table class="items" style="position: absolute;">

                <tbody>

                    <?php

                    $drItemsResult = $dr->getDrItems(implode(",", $dr_number));

                    $grandTotal = 0;
                    if ($drItemsResult->num_rows > 0) {
                        while ($itemRows = $drItemsResult->fetch_assoc()) {
                            $grandTotal += $itemRows['totalRowAmount'];
                            $total[] =  $grandTotal;
                            $limit = 0;
                    ?>
                            <tr>
                                <td style="width: 2.2cm;height:0.7cm;text-align:left"><?php echo number_format($itemRows['totalQty'], 0) ?><?php echo $itemRows['unit_name'] ?>
                                </td>
                                <td style="font-size: 12.8px;width: 12.8cm;"><?php echo $itemRows['product_name'] ?></td>
                                <td class='label--price' style="width: 1.9cm;text-align:right;font-size: 12.8px">
                                    <?php echo number_format($itemRows['jo_product_price'], 0)  ?></td>
                                <td>/<?php echo $itemRows['unit_name'] ?></td>
                                <td style="width: 0.95cm;"></td>
                                <td class='label--subtotal text-end' style="width: 2.5cm;;font-size: 12.8px">
                                    <?php echo number_format($itemRows['totalRowAmount'], 2) ?></td>
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
            echo ' <p style="position: absolute;top:15.9cm;left:12cm;font-size: 12.8px">' . number_format($grandTotal, 2) . '</p>';
        }
        ?>


    </div>
    </div>
</body>

</html>