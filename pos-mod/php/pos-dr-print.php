<?php

// IF Edit button Click from PO Main
if (isset($_GET['printPOS'])) {

    $id = $_GET['id'];

    require 'config.php';

    $result = mysqli_query(
        $db,
        "SELECT order_tb.order_id, customers.customers_name, order_tb.pos_date, customers.customers_address, user.user_name, jo_tb.jo_no
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

        // $date_format = date_format($row['pos_date'], "d/m/y");
    }
}

?>

<html>
<style>
    body {
        font-family: 'Courier New', Courier, monospace;
    }


    img {
        width: 8in;
        height: 10in;
        position: relative;
    }

    .container {
        position: relative;
        text-align: center;
        color: black;
        border: 1px solid black;
        width: 43%;


    }

    .bottom-left {
        position: absolute;
        bottom: 8px;
        left: 16px;
    }

    .ep--customer {
        /* border: 1px solid black; */

        position: absolute;
        top: 15px;
        /* left: 16px; */

    }

    .ep--customer--address {
        position: absolute;
        top: 7px;
        /* left: 16px; */
    }

    /* .ep--no {
        position: absolute;
        top: 12px;
        right: 16px;
    } */


    .ep--date {
        position: absolute;
        top: -10px;
        right: 16px;
    }

    .bottom-right {
        position: absolute;
        bottom: 8px;
        right: 16px;
    }

    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    p {
        font-size: 20px;
        line-height: 2em;
    }

    .ep--itemlist {
        position: absolute;
        top: 8px;
        left: 16px;
    }

    .ep_tb th,
    td {
        padding: 5px;
        /* border: 1px solid black; */
    }

    .ep_tb {
        margin-left: 10px;
        border-collapse: collapse;

    }



    @media print {
        body {
            font-family: 'Courier New', Courier, monospace;
        }

        .noprint {
            visibility: hidden;
        }
    }

    textarea {
        border: none;
        background-color: transparent;
        resize: none;
        outline: none;
        font-size: 12px;
    }


    input[type=button] {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        margin: 4px 2px;
        cursor: pointer;
        font-weight: bolder;
    }

    .ep--user {
        position: absolute;
        top: 575px;
        left: 100px;
    }

    .ep--joNo {
        position: absolute;
        top: 620px;
        left: 50px;
    }



    .button-print {
        position: absolute;
        margin-left: 1000px;
    }

    .button-print button {
        height: 50px;
        width: 200px;
        font-size: 20px;
    }
</style>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script language="javascript">
        function printdiv(printpage) {
            var headstr = "<html><head><title></title></head><body>";
            var footstr = "</body>";
            var newstr = document.all.item(printpage).innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = headstr + newstr + footstr;
            window.print();
            document.body.innerHTML = oldstr;
            return false;
        }
    </script>



</head>


<body>
    <div class="button-print">
        <button class="noprint" name="b_print" onClick="printdiv('div_print');"> <i class="fa fa-print"></i>&nbsp; Print Reciept</button>
    </div>


    <div class="container" id="div_print">
        <img src="../../img/drTemplate.jpg" class="noprint">

        <!-- <div class="ep--no"><br><br><br> <br>
            <p style=" margin-right:15px"><?php echo $ep_no; ?></p>

        </div> -->
        <!-- <div class="ep--drNo"><br><br><br> <br><br><br><br><br> <br>
            <p style=" margin-right:75px;font-weight:bold;font-size:15px;"><?php echo $date  ?></p>
        </div> -->


        <div class="ep--date"><br><br><br> <br><br><br><br><br> <br>
            <p style=" margin-right:75px;font-weight:bold;font-size:15px;"><?php echo $date  ?></p>
        </div>


        <div class="ep--customer"><br><br><br><br><br><br><br><br>
            <p style=" margin-left:80px;font-size:15px;font-weight:bold"><?php echo $customers_name; ?></p>

        </div>

        <div class="ep--customer--address"><br><br><br><br><br><br><br> <br> <br><br>
            <p style=" margin-left:55px;font-size:12px;font-weight:bold"><?php echo $customers_address; ?></p><br>

        </div>

        <div class="ep--itemlist"><br><br><br><br><br><br><br><br><br><br><br> <br> <br>
            <table class="ep_tb" width="100%">
                <tr>
                    <th>&nbsp;&nbsp;</th>
                    <th>&nbsp;&nbsp;</th>
                </tr>
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
                            <td style="width: 80px;"><?php echo $irow['pos_temp_qty'] ?></td>
                            <td style="width: 50px;"><?php echo $irow['unit_name'] ?></td>
                            <td style=" width: 300px;"><?php echo $irow['product_name'] ?></td>
                            <td style="width: 50px; text-align:left">&#8369;<?php echo number_format($irow['pos_temp_price'], 2) ?>/<?php echo $irow['unit_name'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td style="width: 60px; text-align:left">&#8369;<?php echo number_format($irow["pos_temp_qty"] * $irow["pos_temp_price"], 2)  ?></td>
                        </tr>
                <?php }
                } ?>

            </table>

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
                <!-- <tr>
                    <td>&nbsp;<textarea cols="30" rows="10"><?php echo $ep_remarks; ?></textarea></td>
                </tr> -->
            </table>


        </div>


        <div class="ep--user"><br><br><br><br><br><br><br> <br> <br><br>
            <p>/<?php echo $userName ?></p>

        </div>
        <div class="ep--joNo"><br><br><br><br><br><br><br> <br> <br><br>
            <p>JO<?php echo $joNo ?></p>
        </div>
</body>


</html>