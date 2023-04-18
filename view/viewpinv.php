<?php

include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT pinv_tb.pinv_id, pinv_tb.pinv_title, employee_tb.emp_name, pinv_tb.pinv_date
                                 FROM pinv_tb
                                 LEFT JOIN employee_tb ON employee_tb.emp_id = pinv_tb.emp_id
                                 WHERE pinv_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['pinv_id'];
        $pinv_title = $row['pinv_title'];
        $emp_name = $row['emp_name'];
        $dateString = $row['pinv_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'm/d/y');
    } else {
        echo "No results!";
    }
}
?>

<?php include('../headerv2.php') ?>
<STYLE type="text/css" media="print">
    label {
        font-weight: bold;
    }

    @media print {
        div {
            background-color: blueviolet;
        }
    }
</style>
<div class="container-sm">
    <div class="shadow-lg p-5 mt-5 bg-body rounded printPage" style="width:100%;border:5px solid #cce0ff" id="printDiv">
        <div class="top">
            <center>
                <h2>PHILIPPINE ACRYLIC & CHEMICAL CORPORATION</h2>
                <h3>PHYSICAL INVENTORY</h3>
                <hr>
            </center>
        </div>

        <div class="row">
            <div class="col">
                <label for="">PINV ID:</label> <?php echo str_pad($id, 8, 0, STR_PAD_LEFT); ?>
            </div>
            <div class="col">
                <label for="">PINV Title:</label> <?php echo $pinv_title; ?>
            </div>
            <div class="col">
                <label for="">Check By:</label> <?php echo $emp_name; ?>
            </div>
            <div class="col">
                <label for="">PINV Date:</label> <?php echo $date; ?>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table">
                <tr style="text-align: left;">
                    <th width="10%">Product ID</th>
                    <th width="30%">Item Description</th>
                    <th width="10%">Sys. Count</th>
                    <th width="10%">P. Count</th>
                    <th width="5%">Location</th>

                </tr>
                <tr>
                    <?php
                    $sql = "SELECT pinv_product.pinv_id, pinv_product.product_id, pinv_product.pinv_qty, product.product_name, unit_tb.unit_name, product.qty, loc_tb.loc_name
                                FROM pinv_product
                                LEFT JOIN product ON product.product_id = pinv_product.product_id
                                LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id
                                LEFT JOIN pinv_tb ON pinv_tb.pinv_id = pinv_product.pinv_id
                                LEFT JOIN loc_tb ON loc_tb.loc_id = pinv_product.loc_id
                                WHERE pinv_tb.pinv_id = '$id'
                                ORDER BY product.product_name ASC";

                    $result = $db->query($sql);
                    $count = 0;

                    if ($result->num_rows >  0) {

                        while ($irow = $result->fetch_assoc()) {
                            $count = $count + 1;
                            $prodId = str_pad($irow['product_id'], 8, 0, STR_PAD_LEFT);
                    ?>
                            <td><?php echo $prodId ?></td>
                            <td><?php echo $irow['product_name'] ?></td>
                            <td><?php echo number_format($irow['qty'], 2)  ?></td>
                            <td>
                                <font color="red"><?php echo number_format($irow['pinv_qty'], 2) ?></font>
                            </td>
                            <td><?php echo $irow['loc_name'] ?></td>


                </tr>
        <?php }
                    } ?>
            </table>

        </div>

    </div>
    <br>

</div>

<div class="row" style="position:absolute;top:5cm;right:2cm;">
    <div class="col">
        <button class="btn btn-primary" id="doPrint">Print Record</button>
        <a href="../pinv_main2.php"><button class="btn btn-danger"> Cancel</button></a>
    </div>
</div>



<script>
    document.getElementById("doPrint").addEventListener("click", function() {
        var printContents = document.getElementById('printDiv').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    });
</script>