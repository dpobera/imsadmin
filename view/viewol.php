<?php

// IF Edit button Click from PO Main
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    require '../php/config.php';

    $result = mysqli_query(
        $db,
        "SELECT ol_tb.ol_id, ol_type.ol_type_id, ol_type.ol_type_name, ol_product.ol_price, ol_product.ol_priceTot, ol_tb.ol_title, ol_tb.ol_date, ol_product.ol_qty, product.product_id, product.product_name, unit_tb.unit_name, unit_tb.unit_id, user.user_name
        FROM ol_tb
        LEFT JOIN ol_product ON ol_product.ol_id = ol_tb.ol_id
        LEFT JOIN ol_type ON ol_type.ol_type_id = ol_tb.ol_type_id
        LEFT JOIN product ON ol_product.product_id = product.product_id
        LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
        LEFT JOIN user ON user.user_id = ol_tb.user_id
        WHERE ol_tb.ol_id = '$id'"
    );
    $row = mysqli_fetch_array($result);
    if ($result) {
        $id = $row['ol_id'];
        $olTitle = $row['ol_title'];
        $oltypeId = $row['ol_type_id'];
        $olTypeName = $row['ol_type_name'];
        $dateString = $row['ol_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
        $userName = $row['user_name'];
    }
}

?>
<html>
<title><?php echo $olTitle; ?></title>

<head>
    <link rel="stylesheet" href="../css/viewpoV2.css" type="text/css" media="print">
    <link rel="stylesheet" href="../css/viewpoV2.css" type="text/css">
    <style>
        SELECT {
            height: 40px;
            width: 400px;
        }
    </style>
</head>

<script>
    function printDiv() {
        var divContents = document.getElementById("print-area").innerHTML;
        var a = window.open('', '', 'height=1000, width=1300');
        a.document.write(divContents);
        a.document.close();
        a.print();
    }
</script>
<script language="javascript">
    function SelectRedirect() {
        // ON selection of section this function will work
        //alert( document.getElementById('s1').value);

        switch (document.getElementById('s1').value) {
            case "SI":
                window.location = "viewol-si.php?&id=<?php echo $id ?>";
                break;

            case "DR":
                window.location = "viewol-dr.php?&id=<?php echo $id ?>";
                break;

                /// Can be extended to other different selections of SubCategory //////
            default:
                window.location = "../"; // if no selection matches then redirected to home page
                break;
        } // end of switch 
    }
    ////////////////// 
</script>



<body>

    <div class="print-area">
        <page id="print" size="A4">
            <label>Generate Reciept</label> <br>
            <SELECT id="s1" NAME="section" onChange="SelectRedirect();">
                <Option value="">Select Reciept</option>
                <Option value="SI">Sales Invoice</option>
                <Option value="DR">Delivery Reciept</option>
                <Option value="OR">Official Reciept</option>
            </SELECT> <br><br>
            <table style="border: 1px solid black; padding:1%;" width="100%">
                <tr style="text-align: left;">
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Product Name</th>
                    <th>Price/Unit</th>
                    <th>Sub Total</th>
                </tr>
                <?php
                $sql = "SELECT product.product_id, product.product_name, product.qty, unit_tb.unit_name, product.price, ol_product.ol_qty, ol_product.ol_price, ol_product.ol_priceTot
                FROM product 
                LEFT JOIN ol_product ON product.product_id = ol_product.product_id
                LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
                WHERE ol_product.ol_id='$id'
 ";

                $result = $db->query($sql);
                $count = 0;

                if ($result->num_rows >  0) {

                    while ($irow = $result->fetch_assoc()) {
                        $count = $count + 1;
                        $total[] = $irow["ol_qty"] * $irow["ol_price"];


                ?>

                        <tr>
                            <td style="width: 80px;"><?php echo $irow['ol_qty'] ?></td>
                            <td style="width: 50px;"><?php echo $irow['unit_name'] ?></td>
                            <td style=" width: 300px;"><?php echo $irow['product_name'] ?></td>
                            <td style="width: 50px; text-align:left">&#8369;<?php echo number_format($irow['ol_price'], 2) ?>/<?php echo $irow['unit_name'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td style="width: 60px; text-align:left">&#8369;<?php echo number_format($irow["ol_qty"] * $irow["ol_price"], 2)  ?></td>
                        </tr>
                <?php }
                } ?>
            </table>

        </page>
    </div>
</body>


</html>