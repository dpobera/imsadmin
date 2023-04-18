<link rel="stylesheet" href="../source/css/bootstrap.min.css">

<?php
include('../php/config.php');


$joId = $_GET['id'];
$tot = $_GET['tot'];

require 'php/config.php';

$result = mysqli_query(
    $db,
    "SELECT jo_tb.jo_id, jo_tb.jo_no, jo_tb.jo_date, customers.customers_name,customers.customers_contact,customers.customers_address,customers.customers_id, jo_product.product_id, jo_product.jo_product_qty, jo_product.jo_product_price, product.product_name, unit_tb.unit_name, unit_tb.unit_id, employee_tb.emp_name, employee_tb.emp_id, jo_tb.jo_type_id, jo_type.jo_type_name, jo_type.jo_type_id,customers_company,jo_tb.jo_remarks
        FROM jo_tb
        LEFT JOIN jo_product ON jo_product.jo_id = jo_tb.jo_id
        LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id
        LEFT JOIN product ON jo_product.product_id = product.product_id
        LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
        LEFT JOIN employee_tb ON employee_tb.emp_id = jo_tb.emp_id
        LEFT JOIN jo_type ON jo_type.jo_type_id = jo_tb.jo_type_id
        WHERE jo_tb.jo_id ='$joId'
        ORDER BY jo_product.jo_product_id ASC"
);



// PO Details
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $customerName = $row['customers_company'];
        $customerId = $row['customers_id'];
        $customerCon = $row['customers_contact'];
        $customerAdd = $row['customers_address'];
        $joNo = $row['jo_no'];
        $empName = $row['emp_name'];
        $empId = $row['emp_id'];
        $dateString = $row['jo_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'F d, Y');

        $jo_type_id = $row['jo_type_id'];
        $jo_type_name = $row['jo_type_name'];
        $productId[] = str_pad($row['product_id'], 8, 0, STR_PAD_LEFT);
        $productName[] = $row['product_name'];
        $qtyIn[] = $row['jo_product_qty'];
        $unitId[] = $row['unit_id'];
        $unitName[] = $row['unit_name'];
        $itemPrice[] = $row['jo_product_price'];
        $total[] = $row["jo_product_qty"] * $row["jo_product_price"];
        $remarks = $row['jo_remarks'];
    }
} else {
    echo "0 results";
}

?>
<style>
    * {
        font-family: 'Courier New', Courier, monospace;
    }

    label {
        font-weight: bold;
    }

    .paperSize {
        width: 22cm;
        height: 14cm;
        /* border: 1px solid black; */
    }

    .paperSize img {
        height: 1cm;
    }


    @media print {
        body {
            font-size: 14pt;
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
        }



        .report--content {

            border: 1px solid black;
        }
    }

    @media screen {}

    @media print {
        body {
            line-height: .5;
        }
    }

    @media only screen and (min-width: 320px) and (max-width: 480px) and (resolution: 150dpi) {
        body {
            line-height: .5;
        }
    }
</style>

<div class="paperSize">
    <div class="header">
        <center>
            <h5 style="font-weight: bold;letter-spacing:2px">Philippine Acrylic & Chemical Corporation</h5>
            <h6 style="margin-top:-.2cm">635 Mercedes Ave. Bo. San Miguel, Pasig City</h6>
            <h5 style="margin-top:0.5cm;font-weight: bold;letter-spacing:4px">ACKNOWLEDGEMENT RECEIPT</h3>
        </center>
    </div>
    <div class="row" style="padding:2%">
        <div class="col" style="text-align:right ;">
            <label for="">Date :</label> <?php echo $date ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-3">
            <label for="">RECIEVED FROM :</label>
        </div>
        <div class="col-9">
            <?php echo $customerName ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <label for="">AMOUNT :</label>
        </div>
        <div class="col-9">
            <?php echo '₱ ' . number_format($_GET['cashPay'], 2); ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <label for="">AS :</label>
        </div>
        <div class="col-9">
            <?php
            if ($tot > $_GET['cashPay']) {
                echo 'DOWNPAYMENT';
            } else {
                echo 'FULLPAYMENT';
            }
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <label for="">FOR :</label>
        </div>
        <div class="col-9">
            JO<?php echo $joNo ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <label for="">TOTAL AMOUNT :</label>
        </div>
        <div class="col-9">
            <?php echo '₱ ' . number_format($tot, 2)  ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <label for="">AMOUNT RECEIVED:</label>
        </div>
        <div class="col-9">
            <?php echo '₱ ' . number_format($_GET['cashPay'], 2); ?>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-3">
            <label for="">BALANCE AMOUNT:</label>
        </div>
        <div class="col-9">
            <?php
            $payb = $_GET['cashPay'];
            $balTot = $tot - $payb;
            echo '₱ ' .  number_format($balTot, 2); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-9">
            <label for="">RECEIVED BY: ________________________</label>
        </div>
        <div class="col-3">
            <p style="text-decoration:overline;">SIGNITURE</p>
        </div>
    </div>

</div>