<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../source/css/bootstrap.min.css">
    <script src="../source/js/bootstrap.min.js"></script>
    <title>PACC IMS</title>
    <style>
        label {
            font-weight: bold;
        }

        @media print {
            body {
                font-size: 6pt;
                font-family: 'Courier New', Courier, monospace;
            }

            td {
                font-size: 7pt;
            }

            table {
                line-height: .5;
            }

            th {
                font-size: 8pt;
            }

            .report--content {
                /* page-break-before: always !important; */
                border: 1px solid black;
            }
        }

        @media screen {
            body {
                font-size: 12px;
            }
        }

        @media print {
            body {
                line-height: .5;
            }
        }

        @media only screen and (min-width: 320px) and (max-width: 480px) and (resolution: 150dpi) {
            body {
                line-height: 1.4;
            }
        }
    </style>
</head>

<body>

</body>

</html>
<div class="mt-2" style="padding: 2%;">

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a href="stin_report.php?date1=&date2="><button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Fabrication</button></a>
            <a href="stin_report_acry.php?date1=&date2="> <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Acrylic</button></a>
            <a href="stin_report_prcg.php?date1=&date2="><button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">PRCG</button></a>
            <a href="stin_report_stkrm.php?date1=&date2="><button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">STKRM</button></a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="background-color: white;">
            <div style="padding: 2%;">
                <div class="row">
                    <div class="col-3">
                        <div class="p-5 mt-3 bg-body rounded" style="border:5px solid #cce0ff">
                            <form class="form-inline" method="GET" action="">
                                <div class="range">
                                    <label style="float: left;">From:</label>
                                    <input type="date" class="form-control" placeholder="Start" name="date1" /> <br>
                                    <label style="float: left;">To :</label>
                                    <input type="date" class="form-control" placeholder="End" name="date2" /> <br>

                                    <center><button class="btn btn-primary btn-sm" name="search" style="width: 100%;">Generate Report</button></center> <br> <br>
                                    <div class="row">
                                        <div class="col"> <button class="btn btn-success btn-sm" id="print" style="width: 100%;">Print Records</button></div>
                                        <div class="col"><button class="btn btn-danger btn-sm" onClick="self.close()" style="width: 100%;">Close Page</button></div>
                                    </div>

                                    &emsp;

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="p-5 mt-3 bg-body rounded printPage" style="width:100%;border:5px solid #cce0ff" id="report">
                            <h5> Turn-Over Slip Reports</h5>
                            <h6>Department : Acrylic</h6>
                            <?php
                            $dateString = $_GET['date1'];
                            $dateTimeObj = date_create($dateString);
                            $date_1 = date_format($dateTimeObj, 'm/d/y');

                            $dateString1 = $_GET['date2'];
                            $dateTimeObj1 = date_create($dateString1);
                            $date_2 = date_format($dateTimeObj1, 'm/d/y');
                            ?>
                            <h6>Dated : <?php echo $date_1 ?> - <?php echo $date_2 ?> </h6>
                            <br>
                            <div class="report">
                                <?php
                                include "../php/config.php";
                                if (isset($_GET['search'])) {
                                    $date1 = date("Y-m-d", strtotime($_GET['date1']));
                                    $date2 = date("Y-m-d", strtotime($_GET['date2']));

                                    $sql = "SELECT stin_tb.stin_id, stin_tb.stin_code, stin_tb.stin_title, stin_tb.stin_date, employee_tb.emp_name, stin_tb.stin_remarks, stin_tb.closed,dept_tb.dept_name
                                FROM stin_tb 
                                LEFT JOIN employee_tb ON employee_tb.emp_id=stin_tb.emp_id
                                LEFT JOIN dept_tb ON dept_tb.dept_id = employee_tb.dept_id
                                WHERE stin_tb.stin_date 
                                    BETWEEN '$date1' AND '$date2' AND dept_tb.dept_name LIKE '%CUTTER%'
                                    GROUP BY stin_tb.stin_id
                                    ORDER BY stin_tb.stin_date
                                ";

                                    $result = $db->query($sql);
                                    $count = 0;
                                    if ($result->num_rows >  0) {

                                        while ($irow = $result->fetch_assoc()) {

                                            $stinId = str_pad($irow["stin_id"], 8, 0, STR_PAD_LEFT);
                                            $stinCode = $irow["stin_code"];
                                            $stinTitle = $irow['stin_title'];
                                            $dateString = $irow['stin_date'];
                                            $dateTimeObj = date_create($dateString);
                                            $date = date_format($dateTimeObj, 'm/d/y');


                                            $empName = $irow['emp_name'];

                                            $deptName = $irow['dept_name'];
                                            $stinRemarks = $irow['stin_remarks'];
                                            $closed = $irow["closed"];

                                            if ($closed == 1) {
                                                $str = 'Closed';
                                            } else {
                                                $str = 'Open';
                                            }


                                            $sqlItem = "SELECT stin_product.stin_id, product.product_name, product.product_id, stin_product.stin_temp_qty, unit_tb.unit_name,stin_tb.stin_date
                                    FROM stin_product 
                                    INNER JOIN stin_tb ON stin_tb.stin_id = stin_product.stin_id
                                    LEFT JOIN product ON product.product_id = stin_product.product_id                  
                                    LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id
                                    WHERE stin_product.stin_id = $stinId 
                                    ";

                                            $resultItem = $db->query($sqlItem);
                                            $prodId = [];
                                            $prodName = [];
                                            $qty = [];
                                            $unit = [];
                                            if ($result->num_rows >  0) {
                                                while ($irow = $resultItem->fetch_assoc()) {
                                                    $prodId[] = str_pad($irow["product_id"], 8, 0, STR_PAD_LEFT);
                                                    $prodName[] = $irow["product_name"];
                                                    $qty[] = $irow["stin_temp_qty"];
                                                    $unit[] = $irow["unit_name"];
                                                }
                                            }


                                            echo "
                                           
                        <div class='report--content' style='border: 1px solid lightgrey;padding:1%'>
                        
                            <table class='tb--head table table-borderless'>
                                <tr>
                                    <td><label>STIN ID</label> &emsp;  $stinId </td>
                                    <td><label>STIN Code</label> &emsp; $stinCode</td>
                                    <td><label>Status</label> &emsp; $str</td>
                                    <td><label>Date </label>&emsp; $date</td>
                                </tr>
                                <tr>
                                    <td><label>JO No.</label> &emsp;&emsp;&emsp; $stinTitle</td>
                                    <td><label>Prep By </label>&emsp;$empName</td>
                                    <td><label>Department</label>&emsp;$deptName</td>
                                </tr>
                                <tr>
                                <td colspan=4><label>Remarks</label> &emsp;&emsp;&emsp; $stinRemarks</td>
                            </tr>
                            </table>

                            <table class='tb--items table'>
                            <tr style='text-align:left'>
                                <th>Product ID</th>
                                <th>Item Name</th>
                                <th>Qty-IN</th>
                                <th>Unit</th>
                            </tr>";

                                            $limit = 0;
                                            while (count($prodId) !== $limit) {
                                                echo "<tr>
                                <td>$prodId[$limit]</td>
                                <td>$prodName[$limit]</td>
                                <td>$qty[$limit]</td>
                                <td>$unit[$limit]</td>
                                </tr>";

                                                $limit++;
                                            }

                                            echo "   </table>

                        </div>
                        <br><br>";
                                        }
                                    }
                                } else {
                                    echo '<div class="alert alert-primary" role="alert">
                        No data to display.
                      </div>';
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>












<body style="background-color:#cce0ff">

</body>



<div class="print-area">
    <page size="A4">

    </page>
</div>
</body>



<script>
    function refresh() {
        window.location.reload("Refresh")
    }
</script>
<script>
    document.getElementById("print").addEventListener("click", function() {
        var printContents = document.getElementById('report').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    });
</script>

</html>