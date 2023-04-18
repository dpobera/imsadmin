<?php

include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT order_tb.order_id, customers.customers_name, order_tb.pos_date, jo_tb.jo_no, jo_tb.jo_date, user.user_name
    FROM order_tb
    LEFT JOIN customers ON customers.customers_id = order_tb.customer_id
    LEFT JOIN jo_tb ON jo_tb.jo_id = order_tb.jo_id
    LEFT JOIN user ON user.user_id = order_tb.user_id
                                WHERE order_tb.order_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['order_id'];
        $customerName = $row['customers_name'];
        $joNo = $row['jo_no'];
        $dateString = $row['pos_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
        $dateString2 = $row['jo_date'];
        $dateTimeObj2 = date_create($dateString2);
        $date2 = date_format($dateTimeObj2, 'F d, Y');
    } else {
        echo "No results!";
    }
}
?>
<style>
    body {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        padding: 10%;
        background-color: lightgray;
    }

    .container {
        background-color: white;
        padding: 2%;
        -webkit-box-shadow: 5px 4px 15px 2px rgba(0, 0, 0, 0.39);
        box-shadow: 5px 4px 15px 2px rgba(0, 0, 0, 0.39);
    }

    .header {
        width: 100%;
    }

    label {
        font-weight: bold;
    }

    .itemtb {
        width: 100%;
        border: 1px solid black;
        padding: 2px;
        border-collapse: collapse;
    }

    .itemtb td {

        border-right: 1px solid black;
        padding: 3px;
    }

    .itemtb th {

        border: 1px solid black;
        padding: 4px;
    }

    button {
        height: 35px;
        width: 120px;
        font-weight: bolder;
    }
</style>
<title>POS REPORT</title>

<body>

    <div class="container" id="printDiv">
        <h2>Transaction Details</h2>
        <table class="header">
            <tr>
                <td><label for="">Transaction ID :</label> <?php echo str_pad($id, 8, 0, STR_PAD_LEFT); ?></td>
                <td><label for="">POS Date :</label> <?php echo $date; ?></td>
            </tr>
            <tr>
                <td><label for="">Customer :</label> <?php echo $customerName; ?></td>
                <td><label for="">Job Order No. :</label> <?php echo $joNo; ?></td>
                <td><label for="">JO Date :</label> <?php echo $date2; ?></td>
            </tr>
        </table>
        <br>
        <hr>
        <br>
        <h3>Item Order Details</h3>
        <table class="itemtb">
            <tr style="text-align: left;">
                <th>Prod. ID</th>
                <th>Item Description</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $sql = "SELECT product.product_id, product.product_name, order_product.pos_temp_qty, unit_tb.unit_name, order_product.pos_temp_price
                FROM order_product
                LEFT JOIN product ON product.product_id = order_product.product_id
                LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
            
                WHERE order_product.order_id='$id'  ";

            $result = $db->query($sql);
            $count = 0;

            if ($result->num_rows >  0) {

                while ($irow = $result->fetch_assoc()) {
                    $count = $count + 1;
                    $total[] = $irow["pos_temp_qty"] * $irow["pos_temp_price"];

            ?>
                    <tr>
                        <td><?php echo str_pad($irow["product_id"], 8, 0, STR_PAD_LEFT) ?></td>
                        <td><?php echo $irow["product_name"] ?></td>
                        <td><?php echo $irow["pos_temp_qty"] ?></td>
                        <td><?php echo $irow["unit_name"] ?></td>
                        <td><?php echo $irow["pos_temp_price"] ?></td>
                        <td><?php echo number_format($irow["pos_temp_qty"] * $irow["pos_temp_price"], 2)  ?></td>
                    </tr>
            <?php }
            } ?>
        </table>
        <br>
        <table style="float: right;" class="totAmount">
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
                <td>
                    <label for="">Grand Total: &emsp;</label><b><?php echo number_format($grandTot, 2)  ?></b>
                </td>
            </tr>
            <!-- <tr>
                    <td>&nbsp;<textarea cols="30" rows="10"><?php echo $ep_remarks; ?></textarea></td>
                </tr> -->
        </table>
    </div>
    <br>
    <a href="../pos_report.php"><button style="float: right;">Cancel</button></a> <button style="float: left;" id="doPrint">Print Record</button>
</body>

<script>
    document.getElementById("doPrint").addEventListener("click", function() {
        var printContents = document.getElementById('printDiv').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    });
</script>