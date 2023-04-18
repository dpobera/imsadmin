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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var doc = new jsPDF();

        function changeImage() {
            var choice = document.getElementById('choice').value;
            if (choice == "") {
                alert("No Image Selected!");
            } else {
                var image = choice;
            }

            var result = document.getElementById('result');
            result.removeAttribute('style');
            result.innerHTML = "<img src='../assets/brand/" + image + ".png' width='21.3cm' height='25.5cm'/>";

        }
    </script>
    <style>
        body {
            margin: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;


            /* background-color: #; */
            /* overflow: hidden; */
        }

        .dr_paper {
            /* border: 1px solid black; */
            /* background-image: url('../assets/brand/WHT_dr.png'); */
            /* background-size: 100% 100%; */


        }

        img {

            /* border: 1px solid black; */
            /* width: 21.3cm;
            height: 25.5cm; */
            width: 215mm;
            height: 297mm;
            margin-left: -0.2cm;
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

        .ep_table table {
            width: 100%;
            /* border: 1px solid black; */
            border-collapse: collapse;
        }
    </style>

</head>

<body class="bg-light bg-gradient">

    <div class="row">
        <div class="col" id="dr-paper">
            <div id="result">
            </div>
            <div class="dr_paper">
                <p style="position: absolute;left:17cm;top:3.4cm;margin:0;font-size:26px;font-weight:bold;color:red;position:absolute">
                    <?php echo $dr_number ?>
                </p>
                <p style="position: absolute;left:2.6cm;top:5.5cm;margin:0;font-size:13px">
                    <?php echo $customerName ?>
                </p>
                <p style="position: absolute;left:2cm;top:6.2cm;margin:0;width:100%;letter-spacing: -0px;font-size:12px;">
                    <?php echo $customerAdd ?>
                </p>
                <p style="position: absolute;left:16.8cm;top:5.4cm;margin:0;letter-spacing: -1px;width:auto;">
                    <?php echo $date ?>
                </p>


                <div class="dr_table">
                    <table class="items" style="position: absolute;top: 1.2cm;">
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
                                    <td style="width: 1.9cm;height:0.7cm;text-align:center;vertical-align:top">
                                        <?php echo $irow['dr_product_qty'] ?>
                                    </td>

                                    <td style="width: 1.9cm;height:0.7cm;vertical-align:top">
                                        <?php echo $irow['unit_name'] ?>
                                    </td>

                                    <td style="font-size: 12px;width:10cm;vertical-align:top">&nbsp;
                                        <?php echo $irow['product_name'] ?>
                                    </td>

                                    <td style="width:3.2cm;vertical-align:top;">&#8369;
                                        <?php echo $irow['jo_product_price'] ?>/
                                        <?php echo $irow['unit_name'] ?>
                                    </td>


                                    <td style="width: .01cm;height:0.7cm;vertical-align:top;"></td>

                                    <td>&#8369;
                                        <?php echo number_format($irow['subTotal'], 2)   ?>
                                    </td>
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
                                &#8369;
                                <?php echo number_format($grandTot, 2) ?>
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
                                    ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <p style="position: absolute;top:17.5cm;left:2.1cm">/
                        <?php echo $user_name ?>
                    </p>
                    <p style="position: absolute;top:18.6cm;left:1cm">JO
                        <?php echo $joNo ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-4 mt-3">
            <div class="row">
                <div class="col-11">
                    <div class="container bg-white p-5 shadow" style="border:1px solid lightgrey">
                        <label for="select">Select DR Color to export</label>
                        <select id="choice" class="form-select" onchange="changeImage()()">
                            <option value="">-- Select an option --</option>
                            <option value="WHT_dr">WHITE</option>
                            <option value="GRN_dr">GREEN</option>
                            <option value="YLW_dr">YELLOW</option>
                            <option value="PNK_dr">PINK</option>
                        </select> <br> <button id="download-button" class="btn btn-secondary btn-gradient btn-sm"><i class="bi bi-download"></i> Export File</button>
                        <a href="../receipt_dr-index.php"> <button class="btn btn-secondary btn-gradient btn-sm">Cancel</button></a>
                    </div>
                </div>
                <div class="col-1">

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

    <script>
        const button = document.getElementById('download-button');


        function generatePDF() {
            // Document of 210mm wide and 297mm high
            new jsPDF('p', 'mm', [297, 210]);
            // Document of 297mm wide and 210mm high
            new jsPDF('l', 'mm', [297, 210]);
            // Document of 5 inch width and 3 inch high
            new jsPDF('l', 'in', [3, 5]);
            // Choose the element that your content will be rendered to.
            const element = document.getElementById('dr-paper');
            // Choose the element and save the PDF for your user.
            html2pdf().from(element).save();
        }

        button.addEventListener('click', generatePDF);
    </script>
</body>

</html>