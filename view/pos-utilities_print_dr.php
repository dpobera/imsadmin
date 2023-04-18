<?php
session_start();
include('../php/config.php');
if (isset($_GET['dr_number']) && is_numeric($_GET['dr_number']) && $_GET['dr_number'] > 0) {

    $dr_number = $_GET['dr_number'];

    $result = mysqli_query($db, "SELECT delivery_receipt.dr_id,delivery_receipt.dr_number,delivery_receipt.user_id,delivery_receipt.dr_date,user.user_name,jo_tb.jo_no,customers.customers_name,customers.customers_address,jo_tb.jo_remarks
    FROM delivery_receipt
    LEFT JOIN dr_products ON dr_products.dr_number = delivery_receipt.dr_number
    LEFT JOIN jo_product ON dr_products.jo_product_id = jo_product.jo_product_id
    LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id
    LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id
    LEFT JOIN user ON user.user_id = delivery_receipt.user_id
    WHERE delivery_receipt.dr_number=" . $_GET['dr_number']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $dr_number = $row['dr_number'];
        $customerName = $row['customers_name'];
        $customerAdd = $row['customers_address'];
        $joNo = $row['jo_no'];
        $dateString = $row['dr_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
        $dateString2 = $row['dr_date'];
        $dateTimeObj2 = date_create($dateString2);
        $date2 = date_format($dateTimeObj2, 'F d, Y');



        $user_name = $row['user_name'];
        $remarks = $row['jo_remarks'];
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
    <title>View DR</title>
    <style>
        body {
            margin: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        .dr_paper {
            /* border: 1px solid black; */
            width: 21.3cm;
            height: 25.5cm;
        }

        .dr_table {
            position: absolute;
            /* border: 1px solid black; */
            width: 198mm;
            height: 120mm;
            top: 6.6cm;

            margin-right: .5cm;
            margin-left: 7mm;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            /* border: 1px solid black; */
        }

        .items td {
            /* border: 1px solid black; */
        }


        .ep_table table {
            width: 100%;
            /* border: 1px solid black; */
            border-collapse: collapse;
        }

        @media print {
            .hidden-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="dr_paper" style="position:relative">
        <p style="position: absolute;left:17cm;top:3.5cm;margin:0;"> <?php echo $dr_number ?></p>
        <p style="position: absolute;left:2.7cm;top:4.5cm;margin:0;"> <?php echo $customerName ?></p>
        <p style="position: absolute;left:2cm;top:5.3cm;margin:0;width:70%;letter-spacing: -0px;font-size:14px"> <?php echo $customerAdd ?></p>
        <p style="position: absolute;left:16.7cm;top:4.5cm;margin:0;letter-spacing: -1px;"> <?php echo $date ?></p>
    </div>

    <div class="dr_table">
        <table class="items" style="position: absolute;">
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
            $sql = "SELECT product.product_id, dr_products.dr_product_qty, dr_products.jo_product_id, product.product_name, jo_product.jo_product_price, unit_tb.unit_name, dr_products.dr_product_qty * jo_product.jo_product_price AS subTotal
                FROM dr_products
                LEFT JOIN delivery_receipt ON delivery_receipt.dr_number = dr_products.dr_number
                LEFT JOIN jo_product ON jo_product.jo_product_id = dr_products.jo_product_id
                LEFT JOIN product ON product.product_id = jo_product.product_id
                LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id
            
                WHERE delivery_receipt.dr_number='$dr_number'  ";

            $result = $db->query($sql);
            $count = 0;

            if ($result->num_rows >  0) {

                while ($irow = $result->fetch_assoc()) {
                    $total[] = $irow["subTotal"];

            ?>
                    <tr>
                        <td style="width: 1.9cm;height:0.7cm;text-align:center"><?php echo $irow['dr_product_qty'] ?></td>

                        <td style="width: 1.9cm;height:0.7cm"><?php echo $irow['unit_name'] ?></td>

                        <td style="font-size: 12.5px;width:9cm"><?php echo $irow['product_name'] ?></td>

                        <td>&#8369;<?php echo $irow['jo_product_price'] ?>/<?php echo $irow['unit_name'] ?></td>


                        <td style="width: 1cm;height:0.7cm"></td>

                        <td>&#8369;<?php echo number_format($irow['subTotal'], 2)   ?></td>
                    </tr>
            <?php }
            } ?>
            <?php
            $limit = 0;
            $subTot = 0;
            $disTot = 0;
            while ($limit != count($total)) {
                $subTot += $total[$limit];
                // $disTot += $totaldisamount[$limit];
                $limit += 1;
            }
            $grandTot = $subTot - $disTot;
            ?>
            <tr style="text-align: center;">



                <td></td>
                <td style="font-size: small; padding-top:-5px" colspan="4">
                    <center>****** NOTHING FOLLOWS *****</center>
                </td>
                <td style="text-decoration: overline;text-align:left;vertical-align:top">
                    &#8369;<?php echo number_format($grandTot, 2) ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="font-size: small;text-align:left" colspan="5">
                    <p>
                        <?php
                        $search = array(',', ':');
                        $replace = array('<br />', '');
                        echo $remarks = str_replace($search, $replace, $remarks);
                        ?></p>
                </td>
            </tr>
        </table>
        <p style="position: absolute;top:13.3cm;left:2.5cm">/<?php echo $user_name ?></p>
        <p style="position: absolute;top:15.4cm;left:2.5cm">JO<?php echo $joNo ?></p>
    </div>
    </div>
    </div>
</body>

</html>