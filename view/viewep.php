<?php

include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT ep_tb.ep_id, ep_tb.ep_no, ep_tb.ep_title, ep_tb.ep_remarks, ep_tb.ep_date, customers.customers_name, user.user_name
                                 FROM ep_tb
                                 LEFT JOIN user ON user.user_id = ep_tb.user_id
                                 LEFT JOIN customers ON ep_tb.customers_id = customers.customers_id
                                WHERE ep_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['ep_id'];
        $ep_no = $row['ep_no'];
        $ep_title = $row['ep_title'];
        $ep_remarks = $row['ep_remarks'];
        $customers_name = $row['customers_name'];
        $user_name = $row['user_name'];
        $dateString = $row['ep_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
    } else {
        echo "No results!";
    }
}


?>
<html>
<style>
    body {
        font-family: 'Courier New', Courier, monospace;
    }


    img {
        width: 213mm;
        height: 175mm;
        position: relative;
    }

    .container {
        position: relative;
        text-align: center;
        color: black;
        /* border: 1px solid black; */
        width: 43%;


    }

    .bottom-left {
        position: absolute;
        bottom: 8px;
        left: 16px;
    }

    .ep--customer {
        position: absolute;
        top: 8px;
        left: 16px;
    }

    .tb--sign {
        position: absolute;
        margin-left: 50px;
        top: 580px;
        /* border: 1px solid black; */
    }

    .tb--user {
        position: absolute;
        margin-left: 80px;
        top: 540px;
        /* border: 1px solid black; */
    }

    .ep--customer--address {
        position: absolute;
        top: 8px;
        left: 16px;
    }

    .ep--no {
        position: absolute;
        top: 8px;
        right: 16px;
    }


    .ep--date {
        position: absolute;
        top: 8px;
        right: -35px;

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

    .ep_tb td {
        /* border: 1px solid red; */
        padding-top: 6px;
        padding-bottom: 3px;
        vertical-align: top;
    }

    .ep_tb {
        margin-left: 10px;
        margin-top: 5px;
        border-collapse: collapse;
        /* border: 1px solid red; */
        width: 100%;

    }

    .items {
        font-size: 4mm;
        height: 7mm !important;

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
        margin-left: 150px;
        border: none;
        background-color: transparent;
        resize: none;
        outline: none;
        font-size: 12px;
        overflow-y: hidden;
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

    .print--button {
        position: absolute;
        margin-left: 5%;
        float: right;
    }
</style>
<title>EP No. <?php echo $ep_no; ?></title>

<head>
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



    <div class="container" id="div_print">
        <img src="../img/eptemplate.jpg" class="noprint">

        <div class="ep--no"><br><br><br> <br>
            <p style=" margin-right:50px"><?php echo $ep_no; ?></p>

        </div>

        <div class="ep--date"><br><br><br> <br><br><br><br><br> <br>
            <p style=" margin-right:100px"><?php echo $date; ?></p>
        </div>


        <div class="ep--customer"><br><br><br><br><br><br> <br>
            <p style=" margin-left:120px"><?php echo $customers_name; ?></p>

        </div>

        <div class="ep--customer--address"><br><br><br><br><br><br><br> <br> <br>
            <p style=" margin-left:100px"></p><br>

        </div>

        <div class="ep--itemlist"><br><br><br><br><br><br><br><br><br><br><br> <br> <br>
            <table class="ep_tb" width="100%">
                <tr>
                    <th>&nbsp;&nbsp;</th>
                    <th>&nbsp;&nbsp;</th>
                </tr>
                <?php
                $sql = "SELECT product.product_id, product.product_name, product.qty, unit_tb.unit_name, product.price, ep_product.ep_qty, ep_product.ep_price, ep_product.ep_totPrice, ep_tb.ep_remarks, ep_tb.ep_no
                FROM ep_tb
                LEFT JOIN ep_product ON ep_product.ep_id = ep_tb.ep_id
                LEFT JOIN product ON product.product_id = ep_product.product_id
                LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
            
                WHERE ep_tb.ep_no='$ep_no'";

                $result = $db->query($sql);
                $count = 0;

                if ($result->num_rows >  0) {

                    while ($irow = $result->fetch_assoc()) {
                        $count = $count + 1;
                        $total[] = $irow["ep_qty"] * $irow["ep_price"];

                ?>
                        <tr class="items">
                            <td style="width: 165px;">&emsp;&emsp;<?php echo $irow['ep_qty'] ?>&nbsp;<?php echo $irow['unit_name'] ?></td>
                            <td style="width: 550px;"><?php echo $irow['product_name'] ?></td>
                            <td style="width: 60px; text-align:left">&#8369;<?php echo $irow['ep_price'] ?>/<?php echo $irow['unit_name'] ?></td>
                            <td style="width: 60px; text-align:left">&#8369;<?php echo number_format($irow['ep_totPrice'], 2)  ?></td>
                        </tr>
                <?php }
                } ?>
                <tr style="text-align: center;">
                    <td></td>
                    <td style="font-size: small; padding-top:-5px">****** NOTHING FOLLOWS *****</td>
                </tr>
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

                    <td style="text-decoration: overline;">
                        &#8369;<?php echo number_format($grandTot, 2) ?>
                    </td>
                </tr>
            </table>
            &emsp;&emsp;<textarea cols="65" rows="10"><?php echo $ep_remarks; ?></textarea>
        </div>
        <table class="tb--user">
            <tr style="text-align: center;">
                <td style="width:20%">/<?php echo $user_name ?></td>
            </tr>
        </table>
        <table class="tb--sign" style="width: 100%;">
            <tr style="text-align: center;">
                <td style="width:20%">/CTG</td>
                <td style="width:15%">/RE</td>
                <td></td>
            </tr>
        </table>


</body>

<div class="print--button">
    <input name="b_print" type="button" class="noprint" onClick="printdiv('div_print');" value=" Print Document ">
</div>

</html>