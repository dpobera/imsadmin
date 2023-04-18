<?php session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include "../php/config.php";


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>PACC IMS</title>

    <!-- bs5 icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../assets/brand/pacclogoWhite.ico" type="image/x-icon">


    <script src="../styles/sidebars.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/dataTableStyle/css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../styles/dataTableStyle/css/datatables-1.10.25.min.css" />

    <!-- Custom styles for this template -->
    <link href="../styles/sidebars.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index-style.css">
    <style>
        label {
            font-weight: bold;
        }
    </style>
</head>

<body style="background-color: white;">
    <header class="navbar navbar-dark bg-dark bg-gradient sticky-top flex-md-nowrap p-0">
        <a class="navbar-brand bg-dark bg-gradient col-md-3 col-lg-2 me-0 px-3" href="#">
            <img src="assets/brand/pacclogo.png" alt="" width="25" style="margin-bottom: 3px;"> PACC IMS v2.0
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- <input class="form-control form-control w-100" type="text" placeholder="Search" aria-label="Search"> -->
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="../php/logout-inc.php" title="Sign-Out">Sign out <i class="bi bi-box-arrow-left"></i></a>
            </div>
        </div>
    </header>


    <!-- content -->
    <div class="container-fluid">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
            <!-- Itemlist Records header-->
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
                <h1 class="h2 text-secondary font-monospace">STOCK INVENTORY IN REPORTS</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
                        <div class="btnAdd">
                            <!-- <a href="#!" class="btn btn-sm btn-secondary bg-gradient" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                Add New Record</a> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid bg-light" style="background-color:#ededed;border:1px solid lightgrey">
                <div class="row">
                    <div class="col-4">
                        <div class="card mt-4">
                            <h6 class="card-header text-secondary font-monospace">REPORT GENERATOR</h6>
                            <div class="card-body">
                                <form class="form-inline" method="GET" action="">
                                    <div class="range">

                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control form-control-sm" name="date1">
                                            <label for="floatingInput">FROM</label>
                                        </div>
                                        <div class="form-floating mb-1">
                                            <input type="date" class="form-control form-control-sm" name="date2">
                                            <label for="floatingInput">TO</label>
                                        </div>
                                        <div class="form-floating mt-3">
                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="deptType">
                                                <option selected> </option>
                                                <option value="FABR">FABRICATION</option>
                                                <option value="CUTTER">ACRYLIC</option>
                                                <option value="PRCG">PRCG</option>
                                                <option value="STKRM">ACRYSOLV REPORT</option>
                                            </select>
                                            <label for="floatingSelect">SELECT DEPARTMENT</label>
                                        </div>

                                        <div class="row float-end mt-3">
                                            <div class="col">
                                                <button class="btn btn-secondary bg-gradient btn-sm" name="search">Generate Report</button>
                                                <button class="btn btn-secondary bg-gradient btn-sm" id="print">Print Records</button>
                                            </div>
                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card mt-4 mb-4">
                            <h6 class="card-header text-secondary font-monospace">TON REPORTS</h6>
                            <div class="card-body">

                                <div class="container-fluid" style="">


                                    <div class="p-5 mt-3 bg-body rounded printPage mb-3" style="width:100%;border:5px solid lightgrey" id="report">
                                        <h5> Turn-Over Slip Reports</h5>
                                        <h6>Department : <?php echo $_GET['deptType'] ?></h6>
                                        <?php
                                        $dateString = $_GET['date1'];
                                        $dateTimeObj = date_create($dateString);
                                        $date_1 = date_format($dateTimeObj, 'm/d/y');

                                        $dateString1 = $_GET['date2'];
                                        $dateTimeObj1 = date_create($dateString1);
                                        $date_2 = date_format($dateTimeObj1, 'm/d/y');




                                        $deptType = $_GET['deptType'];

                                        ?>
                                        <h6>Dated : <?php echo $date_1 ?> - <?php echo $date_2 ?> </h6>
                                        <br>
                                        <div class="report">
                                            <?php
                                            include "../php/config.php";
                                            if (isset($_GET['search'])) {
                                                $date1 = date("Y-m-d", strtotime($_GET['date1']));
                                                $date2 = date("Y-m-d", strtotime($_GET['date2']));
                                                $deptType = $_GET['deptType'];

                                                $sql = "SELECT stin_tb.stin_id, stin_tb.stin_code, stin_tb.stin_title, stin_tb.stin_date, employee_tb.emp_name, stin_tb.stin_remarks, stin_tb.closed,dept_tb.dept_name
                                                FROM stin_tb 
                                                LEFT JOIN employee_tb ON employee_tb.emp_id=stin_tb.emp_id
                                                LEFT JOIN dept_tb ON dept_tb.dept_id = employee_tb.dept_id
                                                WHERE stin_tb.stin_date 
                                                BETWEEN '$date1' AND '$date2' AND dept_tb.dept_name LIKE '%$deptType%'
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
                                    <td><label >STIN ID</label> &emsp;  $stinId </td>
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
                                                echo '<div class="alert alert-secondary" role="alert">
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
        </main>
    </div>




    <!-- end of content -->

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="styles/dataTableStyle/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="styles/dataTableStyle/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="styles/dataTableStyle/js/dt-1.10.25datatables.min.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script> -->





    <?php include "../footer.php"; ?>
</body>



<script>
    function setDecimal(event) {
        this.value = parseFloat(this.value).toFixed(13);
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