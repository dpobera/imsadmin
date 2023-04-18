<?php
session_start();
include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT order_tb.order_id, customers.customers_company, order_tb.pos_date, jo_tb.jo_no, jo_tb.jo_date, user.user_name,order_tb.dr_number,reason_tb.reason_name,reason_tb.reason_id,user.user_id,jo_tb.jo_id,customers.customers_address,user.user_name,jo_tb.jo_remarks
    FROM order_tb
    LEFT JOIN customers ON customers.customers_id = order_tb.customer_id
    LEFT JOIN jo_tb ON jo_tb.jo_id = order_tb.jo_id
    LEFT JOIN reason_tb ON reason_tb.reason_id = order_tb.reason_id
    LEFT JOIN user ON user.user_id = order_tb.user_id
    WHERE order_tb.order_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['order_id'];
        $customerName = $row['customers_company'];
        $customerAdd = $row['customers_address'];
        $joNo = $row['jo_no'];
        $joId = $row['jo_id'];
        $remarks = $row['jo_remarks'];

        $dateString = $row['pos_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
        $dateString2 = $row['jo_date'];
        $dateTimeObj2 = date_create($dateString2);
        $date2 = date_format($dateTimeObj2, 'F d, Y');
        $drNo = $row['dr_number'];
        $reasonId = $row['reason_id'];
        $reasonName = $row['reason_name'];
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
    <title>View DR</title>
    <link rel="stylesheet" href="../../css/dr_print.css">
</head>

<body>
    <div class="dr_paper" style="position: relative;">
        <p style="position: absolute;left:17cm;top:3.5cm;margin:0;"> <?php echo $drNo ?></p>

        <p style="position: absolute;left:2.7cm;top:4.5cm;margin:0;"> <?php echo $customerName ?></p>
        <p style="position: absolute;left:2cm;top:5.3cm;margin:0;width:70%;letter-spacing: 0px;font-size:14px"> <?php echo $customerAdd ?></p>
        <p style="position: absolute;left:16.7cm;top:4.5cm;margin:0;letter-spacing: -1px;"> <?php echo $date ?></p>
        <div class="dr_table">
            <table class="items" style="position: absolute;">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <?php
                $sql = "SELECT product.product_id, product.product_name, order_product.pos_temp_qty, unit_tb.unit_name, order_product.pos_temp_price, product.qty
                FROM order_product
                LEFT JOIN product ON product.product_id = order_product.product_id
                LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
            
                WHERE order_product.order_id='$id'  ";

                $result = $db->query($sql);
                $count = 0;

                if ($result->num_rows >  0) {

                    while ($irow = $result->fetch_assoc()) {
                        $total[] = $irow["pos_temp_qty"] * $irow["pos_temp_price"];

                ?>
                        <tr>
                            <td style="width: 1.9cm;height:0.7cm;text-align:center"><?php echo $irow['pos_temp_qty'] ?></td>
                            <td style="width: 1.9cm;height:0.7cm"><?php echo $irow['unit_name'] ?></td>
                            <td style="font-size: 12.5px;" colspan="4"><?php echo $irow['product_name'] ?></td>
                            <td style="text-align: right;">&#8369;<?php echo $irow['pos_temp_price'] ?>/<?php echo $irow['unit_name'] ?></td>
                            <td style="text-align: right;">&emsp;&#8369;<?php echo number_format($irow["pos_temp_qty"] * $irow["pos_temp_price"], 2)   ?></td>
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
                    <td></td>
                    <td style="font-size: small; padding-top:-5px" colspan="5">
                        <center>****** NOTHING FOLLOWS *****</center>
                    </td>
                    <td style="text-decoration: overline;text-align:right;vertical-align:top">
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