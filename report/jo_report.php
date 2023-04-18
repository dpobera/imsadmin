<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- font include -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro&display=swap" rel="stylesheet">

    <!-- sidebar styles -->
    <link rel="stylesheet" href="../css/../main_style.css">

    <!-- sidebar script -->
    <script src="js/sidebar_scriot.js"></script>
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
    <title>PACC IMS</title>
</head>
<!-- <link rel="stylesheet" type="text/css" href="css/print.css" media="print" /> -->


<body style="background-color:#cce0ff">
    <div style="padding: 2%;">
        <div class="row">
            <div class="col-3">
                <div class="shadow-lg p-5 mt-5 bg-body rounded printPage" style="width:100%;">
                    <form class="form-inline" method="POST" action="">
                        <div class="range">
                            <label style="float: left;">From:</label>
                            <input type="date" class="form-control" placeholder="Start" name="date1" /> <br>
                            <label style="float: left;">To :</label>
                            <input type="date" class="form-control" placeholder="End" name="date2" /> <br>
                            <center><button class="btn btn-primary" name="search" style="width: 100%;">Generate Report</button></center> <br> <br>
                            <div class="row">
                                <div class="col"> <button class="btn btn-success" id="print" style="width: 100%;">Print Records</button></div>
                                <div class="col"><button class="btn btn-danger" onClick="self.close()" style="width: 100%;">Close Page</button></div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="col-9">
                <div class="shadow-lg p-5 mt-5 bg-body rounded printPage" style="width:100%;border:5px solid #cce0ff" id="report">
                    <h5> Job-Order Reports Detailed</h5>
                    <hr>
                    <br>
                    <?php
                    include "../php/config.php";
                    if (isset($_POST['search'])) {
                        $date1 = date("Y-m-d", strtotime($_POST['date1']));
                        $date2 = date("Y-m-d", strtotime($_POST['date2']));
                        $sql = "SELECT jo_tb.jo_id, jo_tb.jo_no, customers.customers_name, jo_tb.jo_date
                            FROM jo_tb 
                            LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id
                            WHERE jo_tb.jo_date 
                            BETWEEN '$date1' AND '$date2'
                                ";

                        $result = $db->query($sql);
                        $count = 0;
                        if ($result->num_rows >  0) {

                            while ($irow = $result->fetch_assoc()) {
                                $joId = str_pad($irow["jo_id"], 8, 0, STR_PAD_LEFT);
                                $joNo = $irow["jo_no"];
                                $customerName = $irow['customers_name'];
                                $dateString = $irow['jo_date'];
                                $dateTimeObj = date_create($dateString);
                                $date = date_format($dateTimeObj, 'm/d/y');
                                // $empName = $irow['emp_name'];
                                // $deptName = $irow['dept_name'];
                                // $stinRemarks = $irow['stin_remarks'];
                                // $closed = $irow["closed"];

                                // if ($closed == 1) {
                                //     $str = 'Closed';
                                // } else {
                                //     $str = 'Open';
                                // }


                                $sqlItem = "SELECT jo_product.jo_id, 
                                               product.product_name, 
                                               product.product_id, 
                                               jo_product.jo_product_qty, 
                                               unit_tb.unit_name,
                                               jo_product.jo_product_price
                                               
                                        FROM jo_product 
                                        LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id
                                        LEFT JOIN product ON product.product_id = jo_product.product_id                  
                                        LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id
                                        WHERE jo_product.jo_id = $joId  ";

                                $resultItem = $db->query($sqlItem);
                                $prodId = [];
                                $prodName = [];
                                $qty = [];
                                $unit = [];
                                $price = [];
                                if ($result->num_rows >  0) {
                                    while ($irow = $resultItem->fetch_assoc()) {
                                        $prodId[] = str_pad($irow["product_id"], 8, 0, STR_PAD_LEFT);
                                        $prodName[] = $irow["product_name"];
                                        $qty[] = $irow["jo_product_qty"];
                                        $unit[] = $irow["unit_name"];
                                        $price[] = $irow["jo_product_price"];
                                    }
                                }
                                echo "
                        <div class='report--content' style='border:1px dotted black'>
                        
                            <table class='table table-borderless'>
                                <tr>
                                    <td style='width:15%' ><label>JO ID:</label> $joId </td>
                                    <td style='width:15%'><label>Jo No.:</label> $joNo</td>
                                    <td style='width:20%'><label>JO Date: </label> $date</td>
                                    <td style='width:60%'><label>Customer:</label> $customerName</td>
                                </tr>
                            </table>

                            <table class='tb--items table' style='margin-top:-1%'>
                            <tr style='text-align:left'>
                                <th>Product ID</th>
                                <th>Item Name</th>
                                <th>Qty-Order</th>
                                <th>Unit Price</th>
                                <th>Sub Total</th>
                                
                            </tr>";

                                $limit = 0;
                                $total = [];
                                while (count($prodId) !== $limit) {
                                    $total[$limit] = $qty[$limit] * $price[$limit];
                                    echo "<tr>
                                <td>$prodId[$limit]</td>
                                <td>$prodName[$limit]</td>
                                <td>$qty[$limit] $unit[$limit]</td>
                                <td>" . number_format($price[$limit], 2) . "/$unit[$limit]</td>
                                <td>" . number_format($total[$limit], 2) . "</td>
                                </tr>

                              ";
                                    $limit++;
                                }



                                $limitt = 0;
                                $subTot = 0;
                                // $disTot = 0;
                                while ($limitt != count($total)) {
                                    $subTot += $total[$limitt];
                                    // $disTot += $totaldisamount[$limit];

                                    $limitt++;
                                }
                                $grandTot = $subTot;


                                echo " <tr>
                                <td style='font-weight:bold;text-align:right; 'colspan='4'>Grand Total: </td>
                                <td style='text-decoration: overline;''>" . number_format($grandTot, 2)  . "</td></tr>  </table>
                           
                        </div>
                      <br><br>
                
                        ";
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
</body>

<script>
    document.getElementById("print").addEventListener("click", function() {
        var printContents = document.getElementById('report').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    });
</script>