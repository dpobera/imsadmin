<?php

// IF Edit button Click from PO Main
if (isset($_GET['printPOS'])) {

    $id = $_GET['id'];

    require 'config.php';

    $result = mysqli_query(
        $db,
        "SELECT order_tb.order_id, customers.customers_name, order_tb.pos_date, customers.customers_address, user.user_name, jo_tb.jo_no, order_tb.dr_number
        FROM order_tb
        LEFT JOIN user ON user.user_id = order_tb.user_id
        LEFT JOIN customers ON customers_id = order_tb.customer_id 
        LEFT JOIN jo_tb ON jo_tb.jo_id = order_tb.jo_id
        WHERE order_tb.order_id = '$id'"
    );
    $row = mysqli_fetch_array($result);
    if ($result) {
        $id = $row['order_id'];
        // $pos_date = $row['pos_date'];
        $customers_name = $row['customers_name'];
        $customers_address = $row['customers_address'];
        $dateString = $row['pos_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
        $userName = $row['user_name'];
        $joNo = $row['jo_no'];
        $drNumber = $row['dr_number'];

        // $date_format = date_format($row['pos_date'], "d/m/y");
    }
}

?>
<html>

<head>
    <title>Print Reciept</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 230mm;
            height: 100%;
            margin: 0 auto;
            padding: 0;
            font-size: 12pt;
            background: rgb(204, 204, 204);
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .main-page {
            position: absolute;
            width: 210mm;
            min-height: 253mm;
            margin: 10mm auto;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            background-image: url("../../img/drTemplate.jpg");
            background-repeat: no-repeat;
            background-size: 213mm 253mm;
        }

        .sub-page {
            position: absolute;
            width: 210mm;
            height: 253mm;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 213mm;
                height: 253mm;
            }

            .main-page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        .header {
            /* border: 1px solid black; */
            width: 100%;
            border-collapse: collapse;
            margin-top: 3mm;
        }

        /* .header td {
            border: 1px solid black;

        } */

        .items {
            /* border: 1px solid black; */
            width: 100%;
            border-collapse: collapse;
            margin-top: 3mm;
        }

        .items td {
            /* border: 1px solid black; */
            padding: 2.5px;

        }

        .sign {
            position: sticky;
            margin-left: 35px;
            margin-top: 5.2in;
        }
    </style>
</head>

<body>
    <div class="main-page" style="position: relative;">
        <div style="position: absolute; right: 100px; top: 150px;">
            <?php echo $drNumber ?>
        </div>
        <div class="sub-page">
            <br><br><br><br><br><br><br><br><br><br>
            <table class="header">
                <tr>
                    <td>&emsp;&nbsp;&nbsp;</td>
                    <td>&emsp;<b><?php echo $customers_name; ?></b></td>
                    <td>&emsp;</td>
                    <td style="text-align: right; font-size:small">&emsp;&emsp;<b><?php echo $date ?></b></td>
                </tr>
                <tr>
                    <td colspan="4">&emsp;&emsp;&emsp;&nbsp;<?php echo $customers_address; ?></td>
                </tr>
            </table>
            <br>
            <table class="items">
                <?php
                $sql = "SELECT product.product_id, product.product_name, order_product.pos_temp_qty, unit_tb.unit_name, order_product.pos_temp_price
                    FROM order_product
                    LEFT JOIN product ON product.product_id = order_product.product_id
                    LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id
                    WHERE order_product.order_id='$id'
 ";

                $result = $db->query($sql);
                $count = 0;

                if ($result->num_rows >  0) {

                    while ($irow = $result->fetch_assoc()) {
                        $count = $count + 1;
                        $total[] = $irow["pos_temp_qty"] * $irow["pos_temp_price"];
                ?>
                        <tr>
                            <td style="width: 10%; text-align:center"><?php echo $irow['pos_temp_qty'] ?></td>
                            <td style="width: 5%;"></td>
                            <td style="width: 5%;"><?php echo $irow['unit_name'] ?></td>
                            <td style="width: 3%;"></td>
                            <td style="width: 60%; font-size:4mm"><?php echo $irow['product_name'] ?></td>
                            <td>&#8369;<?php echo number_format($irow['pos_temp_price'], 2) ?>/<?php echo $irow['unit_name'] ?></td>
                            <td style="width: 5%;"></td>
                            <td><?php echo number_format($irow["pos_temp_qty"] * $irow["pos_temp_price"], 2)  ?></td>
                        </tr>
                <?php }
                } ?>
            </table>
            <br>
            <table style="float: right;">

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

                <tr>
                    <td></td>
                    <td style="text-decoration: overline;">
                        &#8369;<?php echo number_format($grandTot, 2)  ?>
                    </td>
                </tr>
                <td>--------------<i>NOTHING FOLLOWS</i>--------------
                </td>

            </table>

            <table class="sign">
                <tr>
                    <td>/<?php echo $userName ?></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td>JO<?php echo $joNo ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>