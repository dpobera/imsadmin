<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/brand/pacclogoWhite.ico" type="image/x-icon">



    <title>PACC IMS</title>

    <!-- bs5 icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="assets/brand/pacclogoWhite.ico" type="image/x-icon">


    <script src="styles/sidebars.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/dataTableStyle/css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/dataTableStyle/css/datatables-1.10.25.min.css" />

    <!-- Custom styles for this template -->
    <link href="styles/sidebars.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index-style.css">

    <title>Official Reciept</title>
    <style>
        body {
            margin: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        .or_paper {
            /* border: 1px solid black; */
            width: 19cm;
            height: 13.5cm
        }

        td {
            /* border: 1px solid black; */
            height: .6cm;
            padding: 0;
        }
    </style>

<body>

    <div class="or_paper" style="position: relative;">

        <p style="position: absolute;top:3.2cm;left:9.2cm;font-size:small"> <?php echo $_GET['custName'] ?></p>
        <p style="position: absolute;top:3.9cm;left:7.7cm;font-size:11px"><?php echo $_GET['custAdd']  ?></p>
        <p style="position: absolute;top:2.4cm;left:15cm"> <?php
                                                            $dateString = $_GET['orDate'];
                                                            $dateTimeObj = date_create($dateString);
                                                            $date = date_format($dateTimeObj, 'M d, Y');
                                                            echo $date ?></p>

        <!-- table breakdown -->
        <table style="top:2.2cm;width:5.6cm;left:.9cm;position:absolute;border-collapse: collapse;">
            <?php
            include '../php/config.php';
            if (isset($_GET['save'])) {


                $total = $_GET['total'];
                $tax = $_GET['taxType'];


                foreach ($_GET['id'] as $id) :

                    $sq = mysqli_query($db, "SELECT invoice.invoice_id,invoice.invoice_number,dr_inv.dr_number,customers.customers_name,invoice.invoice_date,user.user_name,tax_type_tb.tax_type_id,dr_products.dr_product_qty,jo_product.jo_product_price,
                                SUM(jo_product.jo_product_price*dr_products.dr_product_qty) AS tot
                                FROM invoice 
                                LEFT JOIN user ON user.user_id = invoice.user_id 
                                LEFT JOIN dr_inv ON dr_inv.inv_number = invoice.invoice_number 
                                LEFT JOIN dr_products ON dr_products.dr_number = dr_inv.dr_number 
                                LEFT JOIN jo_product ON dr_products.jo_product_id = jo_product.jo_product_id 
                                LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id 
                                LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id 
                                LEFT JOIN tax_type_tb ON tax_type_tb.tax_type_id = customers.tax_type_id 
                                WHERE invoice_id='$id'
                                GROUP BY customers.customers_name
                                
                                ");
                    $srow = mysqli_fetch_array($sq);

                    $totAmount[] = $srow['tot'];
                    $limit = 0;

                    echo  " 
                    <tr>

                        <td>
                            SI#" . $srow['invoice_number'] . "
                        </td>
                        <td>
                       " . number_format($srow['tot'], 2)   . "
                        </td>
                    </tr>
                    
                    ";

                endforeach;
            }



            ?>

        </table>

        <p style="position: absolute;top:9.3cm;left:7.5cm">
            <?php

            foreach ($_GET['id'] as $id) :

                $sq = mysqli_query($db, "SELECT invoice.invoice_id,invoice.invoice_number,dr_inv.dr_number,customers.customers_name,invoice.invoice_date,user.user_name,tax_type_tb.tax_type_id,dr_products.dr_product_qty,jo_product.jo_product_price,
                        SUM(jo_product.jo_product_price*dr_products.dr_product_qty) AS tot
                        FROM invoice 
                        LEFT JOIN user ON user.user_id = invoice.user_id 
                        LEFT JOIN dr_inv ON dr_inv.inv_number = invoice.invoice_number 
                        LEFT JOIN dr_products ON dr_products.dr_number = dr_inv.dr_number 
                        LEFT JOIN jo_product ON dr_products.jo_product_id = jo_product.jo_product_id 
                        LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id 
                        LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id 
                        LEFT JOIN tax_type_tb ON tax_type_tb.tax_type_id = customers.tax_type_id 
                        WHERE invoice_id='$id'
                        GROUP BY customers.customers_name
                        
                        ");
                $srow = mysqli_fetch_array($sq);


                echo
                " 
                    <tr>

                        <td>
                       
                        </td>
                       
                    </tr>";



            endforeach; ?>

        </p>

        <!-- table grand total -->
        <p style="position: absolute;top:9.2cm;left:2.7cm">
            <?php
            $limit = 0;
            $subTot = 0;
            $disTot = 0;

            while ($limit != count($totAmount)) {
                $subTot += $totAmount[$limit];

                // $disTot += $totaldisamount[$limit];
                $limit += 1;
            }

            $wvat = $subTot / 1.12;
            $wvat2 = $wvat * 0.01;
            $gTotwVat = $subTot - $wvat2;

            if ($tax == 3) {

                $str = $gTotwVat;
                echo " 
                <p style='position: absolute;top:8.2cm;left:1.1cm'>LESS EWT
                 - " . number_format($wvat2, 2) . "
            </p>";
            } else {
                $str = $subTot;
            } ?>
        </p>

        <p style="position: absolute;top:9.2cm;left:2.7cm"><?php echo "₱ " . number_format($str, 2); ?></p>


        <?php
        function number_to_word($num = '')
        {
            $num = (string) ((int) $num);

            if ((int) ($num) && ctype_digit($num)) {
                $words = array();

                $num = str_replace(array(',', ' '), '', trim($num));

                $list1 = array(
                    '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                    'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                    'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
                );

                $list2 = array(
                    '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                    'seventy', 'eighty', 'ninety', 'hundred'
                );

                $list3 = array(
                    '', 'thousand', 'million', 'billion', 'trillion',
                    'quadrillion', 'quintillion', 'sextillion', 'septillion',
                    'octillion', 'nonillion', 'decillion', 'undecillion',
                    'duodecillion', 'tredecillion', 'quattuordecillion',
                    'quindecillion', 'sexdecillion', 'septendecillion',
                    'octodecillion', 'novemdecillion', 'vigintillion'
                );

                $num_length = strlen($num);
                $levels = (int) (($num_length + 2) / 3);
                $max_length = $levels * 3;
                $num = substr('00' . $num, -$max_length);
                $num_levels = str_split($num, 3);

                foreach ($num_levels as $num_part) {
                    $levels--;
                    $hundred = (int) ($num_part / 100);
                    $hundred = ($hundred ? ' ' . $list1[$hundred] . ' Hundred' . ($hundred == 1 ? '' : '') . ' ' : '');
                    $tens = (int) ($num_part % 100);
                    $singles = '';

                    if ($tens < 20) {
                        $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                    } else {
                        $tens = (int) ($tens / 10);
                        $tens = ' ' . $list2[$tens] . ' ';
                        $singles = (int) ($num_part % 10);
                        $singles = ' ' . $list1[$singles] . ' ';
                    }
                    $words[] = $hundred . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
                }
                $commas = count($words);
                if ($commas > 1) {
                    $commas = $commas - 1;
                }

                $words = implode(', ', $words);

                $words = trim(str_replace(' ,', ',', ucwords($words)), ', ');
                if ($commas) {
                    $words = str_replace(',', ' and', $words);
                }

                return $words;
            } else if (!((int) $num)) {
                return 'Zero';
            }
            return '';
        }

        $words = "<p style='position:absolute;left:8.3cm;top:5.3cm;margin:0;font-size:small'>" . number_to_word("$str") . "</p>";

        echo strtoupper($words);


        ?>

        <p style="position: absolute;top:5.5cm;left:15.9cm"><?php echo number_format($str, 2)  ?></p>
        <p style="position: absolute;top:11.3cm;left:15.9cm"><?php echo number_format($str, 2)  ?></p>




    </div>

</body>