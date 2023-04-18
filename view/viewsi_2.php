<?php
session_start();
include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT ol_tb.ol_id, ol_type.ol_type_id, ol_type.ol_type_name, ol_product.ol_price, ol_product.ol_priceTot, ol_tb.ol_title, ol_tb.ol_date, ol_product.ol_qty, product.product_id, product.product_name, unit_tb.unit_name, unit_tb.unit_id, user.user_name
    FROM ol_tb
    LEFT JOIN ol_product ON ol_product.ol_id = ol_tb.ol_id
    LEFT JOIN ol_type ON ol_type.ol_type_id = ol_tb.ol_type_id
    LEFT JOIN product ON ol_product.product_id = product.product_id
    LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
    LEFT JOIN user ON user.user_id = ol_tb.user_id
    WHERE ol_tb.ol_id = '$id'");


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['ol_id'];
        $olTitle = $row['ol_title'];
        $oltypeId = $row['ol_type_id'];
        $olTypeName = $row['ol_type_name'];
        $dateString = $row['ol_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
        $userName = $row['user_name'];
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
<title><?php echo $olTitle; ?></title>

<body>
    <div class="dr_paper" style="position: relative;">
        <p style="position: absolute;left:2.5cm;top:4cm;margin:0;"> <?php echo $olTypeName ?></p>
        <p style="position: absolute;left:2.5cm;top:4.6cm;margin:0;"> </p>
        <p style="position: absolute;left:2.5cm;top:5.3cm;margin:0; font-size:small;width:60%"> </p>
        <p style="position: absolute;left:16cm;top:4cm;margin:0;"> <?php echo $date ?></p>


        <div class="dr_table">
            <table class="items" style="position: absolute;">
                <?php
                $sql = "SELECT product.product_id, product.product_name, product.qty, unit_tb.unit_name, product.price, ol_product.ol_qty, ol_product.ol_price, ol_product.ol_priceTot, ol_product.ol_fee
                FROM product 
                LEFT JOIN ol_product ON product.product_id = ol_product.product_id
                LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id WHERE ol_product.ol_id='$id' ORDER BY ol_product.ol_product_id ASC";
                $result = $db->query($sql);
                $count = 0;

                if ($result->num_rows >  0) {

                    while ($irow = $result->fetch_assoc()) {

                        $limit = 0;
                        $olQty = $irow["ol_qty"];
                        $olPrice = $irow["ol_price"];
                        $olfc = $irow["ol_fee"];
                        $productId = $irow["product_id"];
                        $total[] = $olQty * $olPrice;





                ?>
                        <tr>
                            <td style="width: 2.2cm;height:0.7cm;text-align:center"><?php echo $irow['ol_qty'] ?>&nbsp;<?php echo $irow['unit_name'] ?></td>
                            <td style="font-size: 12.8px;width: 12.8cm;"><?php echo $irow['product_name'] ?></td>
                            <td style="width: 1.9cm;text-align:right;font-size: 12.8px"><?php echo number_format($irow['ol_price'], 2)  ?>/<?php echo $irow['unit_name']; ?></td>
                            <td style="width: 0.95cm;"></td>
                            <td style="width: 2.5cm;;font-size: 12.8px">&#8369;<?php echo number_format($olQty * $olPrice, 2) ?></td>
                        </tr>
                <?php }
                } ?>

            </table>
        </div>
        <?php


        $subTot = 0;
        $disTot = 0;

        while ($limit != count($total)) {
            $subTot += $total[$limit];
            // $disTot += $totaldisamount[$limit];
            $limit += 1;
        }

        $grandTot = $subTot - $disTot;
        // $anv = $grandTot / 112;
        // $anvv = $anv * 100;
        // $av = $grandTot - $anvv;
        $amountNetVat  = $grandTot / 1.12;
        $addVat = $grandTot - $amountNetVat;

        ?>
        <p style="position: absolute;top:15.1cm;left:18.1cm"><?php echo number_format($amountNetVat, 2)  ?></p>
        <p style="position: absolute;top:16.3cm;left:18.1cm"><?php echo number_format($addVat, 2)  ?></p>
        <p style="position: absolute;top:16.9cm;left:18.1cm"><?php echo number_format($grandTot, 2)  ?></p>
    </div>
    </div>
</body>

</html>