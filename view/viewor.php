<?php
session_start();
include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT order_tb.order_id, customers.customers_name, order_tb.pos_date, jo_tb.jo_no, jo_tb.jo_date, user.user_name,order_tb.dr_number,reason_tb.reason_name,reason_tb.reason_id,user.user_id,jo_tb.jo_id,customers.customers_address,user.user_name,customers_tin
    FROM order_tb
    LEFT JOIN customers ON customers.customers_id = order_tb.customer_id
    LEFT JOIN jo_tb ON jo_tb.jo_id = order_tb.jo_id
    LEFT JOIN reason_tb ON reason_tb.reason_id = order_tb.reason_id
    LEFT JOIN user ON user.user_id = order_tb.user_id
    WHERE order_tb.order_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['order_id'];
        $customerName = $row['customers_name'];
        $customerAdd = $row['customers_address'];
        $joNo = $row['jo_no'];
        $joId = $row['jo_id'];
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
        $custin = $row['customers_tin'];
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
    <title>Official Reciept</title>
    <style>
        body {
            margin: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        .or_paper {
            border: 1px solid black;
            width: 19cm;
            height: 13.5cm
        }

        /* .or_table {
            position: absolute;
            border: 1px solid black;
            width: 20.4cm;
            height: 6.9cm;
            margin-left: 0.3cm;
            margin-right: 0.4cm;
            margin-top: 7.5cm;
        } */

        .items {
            width: 100%;
            border-collapse: collapse;
            /* border: 1px solid black; */
        }

        /* .items td {
    border: 1px solid black;
} */

        /* .ep_table table {
    width: 100%;
    border: 1px solid black;
    border-collapse: collapse;
} */
    </style>
</head>

<body>
    <div class="or_paper" style="position: relative;">
        <p style="position: absolute;left:9cm;top:4.3cm;margin:0;"> <?php echo $customerName ?></p>
        <p style="position: absolute;left:2.5cm;top:4.6cm;margin:0;"><?php echo $custin ?> </p>
        <p style="position: absolute;left:7.5cm;top:4.8cm;margin:0; font-size:small;width:60%"> <?php echo $customerAdd ?></p>
        <p style="position: absolute;left:14.8cm;top:3.6cm;margin:0;"> <?php echo $date ?></p>




        <?php
        $sql = "SELECT product.product_id, product.product_name, order_product.pos_temp_qty, unit_tb.unit_name, order_product.pos_temp_price, product.qty,order_product.pos_temp_tot
                FROM order_product
                LEFT JOIN product ON product.product_id = order_product.product_id
                LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
                WHERE order_product.order_id='$id'  ";
        $result = $db->query($sql);
        $count = 0;

        if ($result->num_rows >  0) {

            while ($irow = $result->fetch_assoc()) {

                $limit = 0;
                $posQty = $irow["pos_temp_qty"];
                $posPrice = $irow["pos_temp_price"];
                $productId = $irow["product_id"];
                $total[] = $posQty * $posPrice;




        ?>
                <?php
                function numberTowords($num)
                {

                    $ones = array(
                        0 => "ZERO",
                        1 => "ONE",
                        2 => "TWO",
                        3 => "THREE",
                        4 => "FOUR",
                        5 => "FIVE",
                        6 => "SIX",
                        7 => "SEVEN",
                        8 => "EIGHT",
                        9 => "NINE",
                        10 => "TEN",
                        11 => "ELEVEN",
                        12 => "TWELVE",
                        13 => "THIRTEEN",
                        14 => "FOURTEEN",
                        15 => "FIFTEEN",
                        16 => "SIXTEEN",
                        17 => "SEVENTEEN",
                        18 => "EIGHTEEN",
                        19 => "NINETEEN",
                        "014" => "FOURTEEN"
                    );
                    $tens = array(
                        0 => "ZERO",
                        1 => "TEN",
                        2 => "TWENTY",
                        3 => "THIRTY",
                        4 => "FORTY",
                        5 => "FIFTY",
                        6 => "SIXTY",
                        7 => "SEVENTY",
                        8 => "EIGHTY",
                        9 => "NINETY"
                    );
                    $hundreds = array(
                        "HUNDRED",
                        "THOUSAND",
                        "MILLION",
                        "BILLION",
                        "TRILLION",
                        "QUARDRILLION"
                    ); /*limit t quadrillion */
                    $num = number_format($num, 2, ".", ",");
                    $num_arr = explode(".", $num);
                    $wholenum = $num_arr[0];
                    $decnum = $num_arr[1];
                    $whole_arr = array_reverse(explode(",", $wholenum));
                    krsort($whole_arr, 1);
                    $rettxt = "";
                    foreach ($whole_arr as $key => $i) {

                        while (substr($i, 0, 1) == "0")
                            $i = substr($i, 1, 5);
                        if ($i < 20) {
                            /* echo "getting:".$i; */
                            $rettxt .= $ones[$i];
                        } elseif ($i < 100) {
                            if (substr($i, 0, 1) != "0")  $rettxt .= $tens[substr($i, 0, 1)];
                            if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
                        } else {
                            if (substr($i, 0, 1) != "0") $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                            if (substr($i, 1, 1) != "0") $rettxt .= " " . $tens[substr($i, 1, 1)];
                            if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
                        }
                        if ($key > 0) {
                            $rettxt .= " " . $hundreds[$key] . " ";
                        }
                    }
                    if ($decnum > 0) {
                        $rettxt .= " and ";
                        if ($decnum < 20) {
                            $rettxt .= $ones[$decnum];
                        } elseif ($decnum < 100) {
                            $rettxt .= $tens[substr($decnum, 0, 1)];
                            $rettxt .= " " . $ones[substr($decnum, 1, 1)];
                        }
                    }
                    return $rettxt;
                }
                extract($_POST);

                $words = "<p style='position:absolute;left:8cm;top:5.9cm;margin:0;'>" . numberTowords("$total[$limit]") . "</p>";

                ?>

        <?php }
        } ?>

        <?php echo $words ?>

    </div>
    </div>
</body>

</html>