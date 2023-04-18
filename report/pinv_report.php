<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/stin_report.css" type="text/css" media="print">
    <link rel="stylesheet" href="../css/stin_report.css" type="text/css">
    <style>
    </style>
    <title>Stock Inventory IN Report</title>
</head>

<center>
    <div class="noprint">
        <form class="form-inline" method="POST" action="">

            <p><i class="fa fa-lightbulb-o" style="font-size:24px"></i>&nbsp;<b>Hint:</b> You can choose which data to include from this report by creating filter for fields for the fields below. <br> </p>

            <div class="range">
                <label style="float: left;">From:</label>
                <input type="date" class="form-control" placeholder="Start" name="date1" /> <br>
                <label style="float: left;">To :</label>
                <input type="date" class="form-control" placeholder="End" name="date2" /> <br>
                <button class="btn btn-primary" name="search">Generate Report</button> <br> <br>
                <button onclick="window.print()">Print Report</button>
            </div>
        </form>
        <br /><br />
    </div>
</center>

<body>
    <div class="print-area">
        <page size="A4">
            <div class="report">
                <?php
                include "../php/config.php";
                if (isset($_POST['search'])) {
                    $date1 = date("Y-m-d", strtotime($_POST['date1']));
                    $date2 = date("Y-m-d", strtotime($_POST['date2']));
                    $sql = "SELECT stin_tb.stin_id, stin_tb.stin_code, stin_tb.stin_title, stin_tb.stin_date, employee_tb.emp_name, stin_tb.stin_remarks, stin_tb.closed,dept_tb.dept_name
                                FROM stin_tb 
                                LEFT JOIN employee_tb ON employee_tb.emp_id=stin_tb.emp_id
                                LEFT JOIN dept_tb ON dept_tb.dept_id = employee_tb.dept_id
                                WHERE stin_tb.stin_date 
                                    BETWEEN '$date1' AND '$date2'
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
                        <div class='report--content'>
                            <table class='tb--head'>
                                <tr>
                                    <td><label>STIN ID</label> &emsp;  $stinId </td>
                                    <td><label>STIN Code</label> &emsp; $stinCode</td>
                                    <td><label>Status</label> &emsp; $str</td>
                                    <td><label>Date </label>&emsp; $date</td>
                                </tr>
                                <tr>
                                    <td><label>Title</label> &emsp;&emsp;&emsp; $stinTitle</td>
                                    <td><label>Prep By </label>&emsp;$empName</td>
                                    <td><label>Department</label>&emsp;$deptName</td>
                                </tr>
                                <tr>
                                <td colspan=4><label>Remarks</label> &emsp;&emsp;&emsp; $stinRemarks</td>
                            </tr>
                            </table>

                            <table class='tb--items'>
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
                }
                ?>




            </div>
        </page>
    </div>
</body>



<script>
    function refresh() {
        window.location.reload("Refresh")
    }
</script>
<script>
    function printDiv() {
        var divContents = document.getElementById("print-area").innerHTML;
        var a = window.open('', '', 'height=1000, width=1300');
        a.document.write(divContents);
        a.document.close();
        a.print();
    }
</script>

</html>