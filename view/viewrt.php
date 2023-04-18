<?php

include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT rt_tb.rt_id, rt_tb.rt_no, rt_tb.rt_date, customers.customers_name, rt_tb.rt_reason, rt_tb.rt_note, rt_tb.rt_driver, rt_tb.rt_guard
                                FROM rt_tb
                                LEFT JOIN customers ON customers.customers_id = rt_tb.customers_id
                                  WHERE rt_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['rt_id'];
        $rt_no = $row['rt_no'];
        $customer = $row['customers_name'];
        $rt_note = $row['rt_note'];
        $rt_reason = $row['rt_reason'];
        $rt_driver = $row['rt_driver'];
        $rt_guard = $row['rt_guard'];
        $dateString = $row['rt_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
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
    <style>
        body {
            margin: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        .base {
            /* border: 1px solid black; */
            width: 21.6cm;
            height: 27.9cm;
        }

        .ep_paper {
            /* border: 1px solid black; */
            width: 21.6;
            height: 14.85cm;
        }


        .rt-header {
            margin: 0%;
        }

        .rt-subHead {
            padding: 2%;
        }

        .rt-table {
            padding: 2%;
        }

        label {
            font-weight: bold;
        }

        .ep_table {
            position: relative;
            border: 1px solid black;
            border-collapse: collapse;

            /* margin-top: 42mm;
            margin-bottom: 12mm;
            margin-right: 7mm;
            margin-left: 7mm; */
        }

        .ep_table td {
            border: transparent;
            border: 1px solid lightgray;
            padding: 5px;

        }

        .ep_table th {
            border: transparent;
            border: 1px solid lightgray;
            padding: 5px;

        }

        .ep_table table {
            width: 100%;
            border: transparent;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div class="base">
        <!-- <button  style="position: absolute;left:26cm">Print</button> -->
        <div class="ep_paper">
            <br>
            <center>
                <div class="rt-header">
                    <h4 style="letter-spacing: 4px;font-size:larger">PHILIPPINE ACRYLIC & CHEMICAL CORPORATION</h4>
                    <h5 style="letter-spacing: 3px;font-size:large; margin-top:-20px">RETURN SLIP</h5>
                    <hr style="width:90%;margin-top:-20px">
                </div>
            </center>
            <div class="rt-subHead">
                <table style="width: 100%;">
                    <tr>
                        <td><label for="">RT #:</label> <?php echo $rt_no; ?></td>
                        <td style="text-align: right;"><label for="">Date:</label> <?php echo $date; ?></td>
                    </tr>
                    <tr>
                        <td><label for="">Company:</label> <?php echo $customer; ?></td>
                    </tr>
                </table>
            </div>
            <div style="padding:2%;">
                <table style="width:100%;" class="ep_table">
                    <tr style="text-align: left;">
                        <th style="text-align: center;">Quantity</th>
                        <th>Item Description</th>
                    </tr>
                    <?php
                    $sql = "SELECT product.product_name, rt_product.rt_qty, unit_tb.unit_name
                                  FROM product
                                  LEFT JOIN rt_product
                                  ON product.product_id = rt_product.product_id
                                  LEFT JOIN unit_tb
                                  ON product.unit_id = unit_tb.unit_id
                                  WHERE rt_product.rt_id = '$id' ";

                    $result = $db->query($sql);
                    $count = 0;
                    if ($result->num_rows >  0) {
                        while ($irow = $result->fetch_assoc()) {
                            $count = $count + 1;

                    ?>
                            <tr>
                                <td style="text-align: center;"><?php echo number_format($irow['rt_qty'], 2); ?> <?php echo $irow['unit_name']; ?></td>
                                <td><?php echo $irow['product_name']; ?></td>
                            </tr>
                    <?php }
                    } ?>
                </table>

                <div style="position: absolute;top:11cm">
                    <table style="width:20cm">
                        <tr>
                            <td><label for="">Reason:</label> <?php echo $rt_reason ?></td>
                        </tr>
                        <tr>
                            <td><label for="">Note:</label> <?php echo $rt_note ?></td>
                        </tr>
                    </table>
                </div>

                <!-- <p style=""><?php echo $rt_driver ?></p> -->

                <table style="position: absolute;top:13cm;left:1cm;">
                    <tr style="text-align:center;">
                        <td><?php echo $rt_driver ?></td>
                    </tr>
                    <tr style="text-align:center;">
                        <td>
                            <label style="text-decoration: overline"> DRIVER/TRUCK</label>
                        </td>
                    </tr>
                </table>

                <table style="position: absolute;top:13cm;left:15cm;">
                    <tr style="text-align:center;">
                        <td><?php echo $rt_guard ?></td>
                    </tr>
                    <tr style="text-align:center;">
                        <td>
                            <label style="text-decoration: overline">GUARD ON DUTY</label>
                        </td>
                    </tr>
                </table>





            </div>



</body>

</html>