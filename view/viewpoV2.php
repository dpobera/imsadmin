<?php

include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT po_tb.po_code, po_tb.po_title, po_tb.po_date, po_tb.po_remarks, po_tb.po_terms, sup_tb.sup_id, po_tb.po_id, sup_tb.sup_name, sup_tb.sup_address,sup_tb.sup_tel, sup_tb.sup_tin, sup_tb.sup_email,sup_tb.sup_id, sup_tb.tax_type_id,po_tb.rec_date,po_tb.closed FROM sup_tb INNER JOIN po_tb ON sup_tb.sup_id = po_tb.sup_id  WHERE po_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['po_id'];
        $po_code = $row['po_code'];
        $closed = $row['closed'];
        $po_title = $row['po_title'];
        $po_remarks = $row['po_remarks'];
        $po_terms = $row['po_terms'];
        $sup_name = $row['sup_name'];
        $sup_address = $row['sup_address'];
        $sup_tel = $row['sup_tel'];
        $sup_tin = $row['sup_tin'];
        $sup_email = $row['sup_email'];
        $dateString = $row['po_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');
        $dateString1 = $row['rec_date'];
        $dateTimeObj1 = date_create($dateString1);
        $date1 = date_format($dateTimeObj1, 'm/d/Y');
        $sup_id = $row['sup_id'];
        $tax_type_id = $row['tax_type_id'];
    } else {
        echo "No results!";
    }
}
?>
<html>
<title>PACC IMS v2.0</title>

<head>
    <link rel="stylesheet" href="../css/viewpoV2.css" type="text/css" media="print">
    <link rel="stylesheet" href="../css/viewpoV2.css" type="text/css">
    <link rel="shortcut icon" href="../assets/brand/pacclogoWhite.ico" type="image/x-icon">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
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
<div class="p-3 sticky-sm-top">
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="row">
            <div class="col"> <button class="btn btn-secondary bg-gradient btn-sm d-print-none" onclick="window.print()"><i class="bi bi-printer-fill"></i> PRINT DOCUMENT</button> </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-5">
                &emsp;
            </div>
            <div class="col-7 align-right text-success">
                <?php
                if ($closed == 1) {
                    echo '  <div class="sticky-sm-top">
                                <h3 style="">RECEIVED<br>' . $date1 . '</h3>
                            </div>';
                } ?>
            </div>
        </div>

    </div>
</div>
</div>


<body class="bg-light">





    <div class="print-area">
        <page id="print" size="A4">


            <div class="heading">
                <img src="../assets/brand/pacclogo2.ico">
                <p>
                    <b style="font-size: 20px;">Philippine Acrylic & Chemical Corporation</b> <br>
                    635 Mercedes Ave. Bo. San Miguel, Pasig City <br>
                    Tel. 8330-8847&nbsp;&nbsp;&nbsp;7501-6844 &nbsp;&nbsp;&nbsp;+63922838116 <br>
                    Email: acrychem@gmail.com

                </p>
            </div>

            <div class="sup-info">
                <table>
                    <tr>
                        <td><label class="tab-title"><b>SUPPLIER</b></label></td>
                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td><b style="font-size: 17px; "><?php echo $sup_name; ?></b></td>
                    </tr>
                    <tr>
                        <td>
                            <p><?php echo $sup_address; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td> <b>Contact:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                                            if ($sup_tel == "") {
                                                                                echo "N/A";
                                                                            } else {
                                                                                echo $sup_tel;
                                                                            }
                                                                            ?></td>
                    </tr>
                    <tr>
                        <td><b>TIN:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                                                                                if ($sup_tin == "") {
                                                                                                                    echo "N/A";
                                                                                                                } else {
                                                                                                                    echo $sup_tin;
                                                                                                                }
                                                                                                                ?></td>
                    </tr>
                    <tr>
                        <td> <b> Email: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                                                            if ($sup_email == "") {
                                                                                                echo "N/A";
                                                                                            } else {
                                                                                                echo $sup_email;
                                                                                            }
                                                                                            ?></td>
                    </tr>
                </table>
            </div>

            <div class="po-info">
                <table>
                    <tr>
                        <td><label class="tab-title" style="font-size: 30px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Purchase Order</label> </td>
                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td>
                            <b> Date:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $date; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td>
                            <b> PO # :</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $po_code; ?>

                        </td>
                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td> <b> ID :</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo str_pad($sup_id, 8, '0', STR_PAD_LEFT); ?></td>

                    </tr>
                    <tr>
                        <td>
                            <b> Terms:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                                            if ($po_terms == "") {
                                                                                echo "N/A";
                                                                            } else {
                                                                                echo $po_terms;
                                                                            }
                                                                            ?>
                        </td>
                    </tr>

                </table>
            </div>
            <br><br>
            <div class="item-order">
                <table>
                    <tr>
                        <th width="36%">Item Description</th>
                        <th width="7%">Qty</th>
                        <th width="5%">Unit</th>
                        <th width="7%">Cost</th>
                        <th width="10%">T. Cost</th>
                        <th width="10%"> %Disc.</th>
                        <th width="15%">Disc. Amount</th>
                        <th width="10%">Sub Total</th>
                    </tr>

                    <?php
                    $sql = "SELECT product.product_name, po_product.item_qtyorder, unit_tb.unit_name, product.cost, po_product.item_disamount, po_product.item_cost, po_product.item_discpercent
                                  FROM product
                                  LEFT JOIN po_product
                                  ON product.product_id = po_product.product_id
                                  LEFT JOIN unit_tb
                                  ON product.unit_id = unit_tb.unit_id
                                  WHERE po_product.po_id = '$id'";

                    $result = $db->query($sql);
                    $count = 0;
                    if ($result->num_rows >  0) {
                        while ($irow = $result->fetch_assoc()) {
                            $count = $count + 1;

                            $total[] = $irow["item_qtyorder"] * $irow["item_cost"];

                            $totaldisamount[] =  $irow["item_disamount"];

                    ?>
                            <tr>
                                <td><?php echo $irow['product_name'] ?></td>
                                <td><?php echo $irow['item_qtyorder'] ?></td>
                                <td><?php echo $irow['unit_name'] ?></td>
                                <td><?php echo number_format($irow['item_cost'], 2)  ?></td>
                                <td class="item_totcost"> <?php echo number_format($irow["item_qtyorder"] * $irow["item_cost"], 2); ?></td>
                                <td><?php echo number_format($irow['item_discpercent'], 2)  ?></td>
                                <td><?php echo number_format($irow['item_disamount'], 2)  ?></td>
                                <td class="po_temp_tot"><?php echo number_format($irow["item_qtyorder"] * $irow["item_cost"] - $irow["item_disamount"], 2); ?></td>
                            </tr>
                            <input type="hidden" name="product_id[]" value="<?php echo $irow['product_id'] ?>">
                    <?php }
                    } ?>
                </table>
                <div class="remarks">
                    <p> <b> Remarks:</b> <?php
                                            if ($po_remarks == "") {
                                                echo "N/A";
                                            } else {
                                                echo $po_remarks;
                                            }
                                            ?></td>
                    </p>
                </div>
                <br><br><br>
            </div>
            <div class="subtot">
                <table>
                    <?php


                    if ($tax_type_id == 3) {
                        $limit = 0;
                        $subTot = 0;
                        $disTot = 0;

                        while ($limit != count($total)) {
                            $subTot += $total[$limit];
                            $disTot += $totaldisamount[$limit];
                            $limit += 1;
                        }

                        $grandTot = $subTot - $disTot;
                        $ewt1 = $grandTot / 1.12;
                        $ewt2 = $ewt1 * 0.01;
                        $grandTot2 = $grandTot - $ewt2;
                        echo '<tr>
                        <td><label class="totDiv"> Sub Total</label>&nbsp;</td>
                        <td>: ' . number_format($subTot, 2) . '</td>
                    </tr>
                    <tr>
                        <td><label class="totDiv"> Total Discount</label></td>
                        <td>: ' . number_format($disTot, 2) . '</td>
                    </tr>
                    <tr>
                        <td><label class="totDiv">Gross &nbsp; </label></td>
                        <td><label class="totDiv">: ' . number_format($grandTot, 2) . '</label></td>
                    </tr>
                    <tr>
                    <td><label class="totDiv">EWT &nbsp; </label></td>
                    <td><label class="totDiv">: ' . number_format($ewt2, 2) . '</label></td>
                </tr>
                <tr>
                    <td><label class="totDivGrand">Grand Total &nbsp; </label></td>
                    <td><label class="totDivGrand">: ' . number_format($grandTot2, 2) . '</label></td>
                </tr>

                   ';
                    } elseif ($tax_type_id == 4) {
                        $limit = 0;
                        $subTot = 0;
                        $disTot = 0;
                        while ($limit != count($total)) {
                            $subTot += $total[$limit];
                            $disTot += $totaldisamount[$limit];
                            $limit += 1;
                        }

                        $grandTot = $subTot - $disTot;
                        $ewt2 = $grandTot * 0.01;
                        $grandTot2 = $grandTot - $ewt2;
                        echo '<tr>
                        <td><label class="totDiv"> Sub Total</label>&nbsp;</td>
                        <td>: ' . number_format($subTot, 2) . '</td>
                    </tr>
                    <tr>
                        <td><label class="totDiv"> Total Discount</label></td>
                        <td>: ' . number_format($disTot, 2) . '</td>
                    </tr>
                    <tr>
                        <td><label class="totDiv">Gross &nbsp; </label></td>
                        <td><label class="totDiv">: ' . number_format($grandTot, 2) . '</label></td>
                    </tr>
                    <tr>
                    <td><label class="totDiv">EWT</label></td>
                    <td><label class="totDiv">:  ' . number_format($ewt2, 2) . '</label></td>
                </tr>
                <tr>
                    <td><label class="totDivGrand">Grand Total &nbsp; </label></td>
                    <td><label class="totDivGrand">: ' . number_format($grandTot2, 2) . '</label></td>
                </tr>

                   ';
                    } else {

                        $limit = 0;
                        $subTot = 0;
                        $disTot = 0;

                        while ($limit != count($total)) {
                            $subTot += $total[$limit];
                            $disTot += $totaldisamount[$limit];
                            $limit += 1;
                        }

                        $grandTot = $subTot - $disTot;
                        echo '<tr>
                            <td><label class="totDiv"> Sub Total</label>&nbsp;</td>
                            <td>: ' . number_format($subTot, 2) . '</td>
                        </tr>
                        <tr>
                            <td><label class="totDiv"> Discount Total</label></td>
                            <td>: ' . number_format($disTot, 2) . '</td>
                        </tr>
                        <tr>
                            <td><label class="totDivGrand">Grand Total &nbsp; </label></td>
                            <td><label class="totDivGrand">: ' . number_format($grandTot, 2) . '</label></td>
                        </tr>

';
                    }

                    ?>






                </table>
            </div>

            <div class="footer">

                <table class="emptab">
                    <tr>
                        <td>___________________________<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepared by &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>___________________________<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved by &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</td>
                    </tr>
                </table>

            </div>



        </page>
    </div>

</body>


</html>