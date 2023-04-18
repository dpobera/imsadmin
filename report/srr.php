<!-- <?php

        include('../php/config.php');
        if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

            $id = $_GET['id'];

            $result = mysqli_query($db, "SELECT po_tb.po_code, po_tb.po_title, po_tb.po_date, po_tb.po_remarks, po_tb.po_terms, sup_tb.sup_id, po_tb.po_id, sup_tb.sup_name, sup_tb.sup_address,sup_tb.sup_tel, sup_tb.sup_tin FROM sup_tb INNER JOIN po_tb ON sup_tb.sup_id = po_tb.sup_id  WHERE po_id=" . $_GET['id']);


            $row = mysqli_fetch_array($result);

            if ($row) {
                $id = $row['po_id'];
                $po_code = $row['po_code'];
                $po_title = $row['po_title'];
                $po_remarks = $row['po_remarks'];
                $po_terms = $row['po_terms'];
                $sup_name = $row['sup_name'];
                $sup_address = $row['sup_address'];
                $sup_tel = $row['sup_tel'];
                $sup_tin = $row['sup_tin'];
                $dateString = $row['po_date'];
                $dateTimeObj = date_create($dateString);
                $date = date_format($dateTimeObj, 'm/d/y');
            } else {
                echo "No results!";
            }
        }
        ?>
<html>
<title><?php echo $po_code; ?></title>

<head>
    <link rel="stylesheet" href="../css/viewpo.css" type="text/css" media="print">
    <link rel="stylesheet" href="../css/viewpo.css" type="text/css">
    <style>
        .potb {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }

        .potb th,
        td {
            border: 1px solid black;
            font-size: 13px;
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

<body>
    <div class="print-area">
        <page id="print" size="A4"> <br>
            <table class="potb">
                <tr style="text-align: left;">
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Ref. No.</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Remarks</th>
                </tr>
                <?php
                $sql = "SELECT po_tb.po_date, sup_tb.sup_name, po_tb.po_code, product.product_name, po_product.item_qtyorder, unit_tb.unit_name, product.pro_remarks
                FROM po_tb
                LEFT JOIN sup_tb ON sup_tb.sup_id = po_tb.sup_id
                LEFT JOIN po_product ON po_product.po_id = po_tb.po_id
                INNER JOIN product ON product.product_id = po_product.product_id
                LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
                ORDER BY sup_tb.sup_name ASC
                ";

                $result = $db->query($sql);
                $count = 0;
                if ($result->num_rows >  0) {
                    while ($irow = $result->fetch_assoc()) {

                        $dateString = $irow['po_date'];
                        $dateTimeObj = date_create($dateString);
                        $date = date_format($dateTimeObj, 'm/d/y');

                ?>
                        <tr>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $irow['sup_name']; ?></td>
                            <td><?php echo $irow['po_code']; ?></td>
                            <td><?php echo $irow['product_name']; ?></td>
                            <td><?php echo $irow['item_qtyorder']; ?></td>
                            <td><?php echo $irow['unit_name']; ?></td>
                            <td><?php echo $irow['pro_remarks']; ?></td>
                        </tr>
                <?php }
                } ?>
            </table>




        </page>
    </div>
</body>


</html>


<!-- 
SELECT * FROM po_tb WHERE po_date 
	BETWEEN '2021-11-16' AND LAST_DAY('2021-12-01') -->



<?php
require '../php/config.php';
if (isset($_POST['search'])) {
    $date1 = date("Y-m-d", strtotime($_POST['date1']));
    $date2 = date("Y-m-d", strtotime($_POST['date2']));
    $query = mysqli_query($db, "SELECT po_tb.po_date, sup_tb.sup_name, po_tb.po_code, product.product_name, po_product.item_qtyorder, unit_tb.unit_name, product.pro_remarks
    FROM po_tb
    LEFT JOIN sup_tb ON sup_tb.sup_id = po_tb.sup_id
    LEFT JOIN po_product ON po_product.po_id = po_tb.po_id
    INNER JOIN product ON product.product_id = po_product.product_id
    LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
    WHERE po_tb.po_date
     BETWEEN '$date1' AND '$date2'");
    $row = mysqli_num_rows($query);
    if ($row > 0) {
        while ($fetch = mysqli_fetch_array($query)) {
?>
            <tr>
                <td><?php echo $fetch['po_date'] ?></td>
                <td><?php echo $fetch['sup_name'] ?></td>
                <td><?php echo $fetch['po_code'] ?></td>
                <td><?php echo $fetch['product_name'] ?></td>
                <td><?php echo $fetch['item_qtyorder'] ?></td>
                <td><?php echo $fetch['unit_name'] ?></td>
                <td><?php echo $fetch['pro_remarks'] ?></td>

            </tr>
        <?php
        }
    } else {
        echo '
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
    }
} else {
    $query = mysqli_query($db, "SELECT po_tb.po_date, sup_tb.sup_name, po_tb.po_code, product.product_name, po_product.item_qtyorder, unit_tb.unit_name, product.pro_remarks
    FROM po_tb
    LEFT JOIN sup_tb ON sup_tb.sup_id = po_tb.sup_id
    LEFT JOIN po_product ON po_product.po_id = po_tb.po_id
    INNER JOIN product ON product.product_id = po_product.product_id
    LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id");
    while ($fetch = mysqli_fetch_array($query)) {
        ?>
        <tr>
            <td><?php echo $fetch['po_date'] ?></td>
            <td><?php echo $fetch['sup_name'] ?></td>
            <td><?php echo $fetch['po_code'] ?></td>
            <td><?php echo $fetch['product_name'] ?></td>
            <td><?php echo $fetch['item_qtyorder'] ?></td>
            <td><?php echo $fetch['unit_name'] ?></td>
            <td><?php echo $fetch['pro_remarks'] ?></td>
        </tr>
<?php
    }
}
?>