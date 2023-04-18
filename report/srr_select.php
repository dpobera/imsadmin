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
                <h1 class="h2 text-secondary font-monospace">STOCK ROOM RECEIPTS REGISTER (SRR)</h1>
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

            <div class="container-fluid bg-light" style="background-color:#ededed;border:1px solid lightgrey;">
                <div class="row">
                    <div class="col-4">
                        <div class="card mt-4 mb-4">
                            <h6 class="card-header text-secondary font-monospace">REPORT GENERATOR</h6>
                            <div class="card-body">
                                <form class="form-inline" method="POST" action="" autocomplete="off">
                                    <div class="range">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control form-control-sm" name="date1" required>
                                            <label for="floatingInput">FROM</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control form-control-sm" name="date2" required>
                                            <label for="floatingInput">TO</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control form-control-sm" name="srr_no" required>
                                            <label for="floatingInput">SRR NO.</label>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="srr_month" required>
                                                        <option selected> </option>
                                                        <option value="January">January</option>
                                                        <option value="February">February</option>
                                                        <option value="March">March</option>
                                                        <option value="April">April</option>
                                                        <option value="May">May</option>
                                                        <option value="June">June</option>
                                                        <option value="July">July</option>
                                                        <option value="August">August</option>
                                                        <option value="September">September</option>
                                                        <option value="October">October</option>
                                                        <option value="November">November</option>
                                                        <option value="December">December</option>
                                                    </select>
                                                    <label for="floatingSelect">MONTH</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control form-control-sm" name="srr_year" required>
                                                    <label for="floatingInput">YEAR</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="float-end">
                                            <button class="btn btn-secondary bg-gradient btn-sm" name="search">Generate Report</button>
                                            <button class="btn btn-secondary bg-gradient btn-sm" id="print">Print Records</button>
                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card mt-4 mb-4">
                            <h6 class="card-header text-secondary">SRR REPORTS</h6>
                            <div class="card-body">



                                <div class=" p-2 mt-1 bg-body rounded printPage" id="report">
                                    <center>
                                        <h4>
                                            PHILIPPINE ACRYLIC & CHEMICAL CORPORATION
                                        </h4>
                                        <h5 style="line-height:1px">Storeroom Reciepts Register
                                        </h5>
                                        <hr>
                                    </center>
                                    <div class="row">
                                        <div class="col">
                                            <?php
                                            if (isset($_POST['search'])) {

                                                echo ' <h5>Month : ' . $_POST["srr_month"] . '-' . $_POST["srr_year"] . '</h5>
                                </div>
                                <div class="col">
                                <h5 style="text-align:right">SRR No. ' . $_POST["srr_no"] . '</h5>
                                </div>';
                                            } ?>
                                        </div>
                                        <table class="srrItem table">
                                            <thead>
                                                <tr style="text-align: left;">
                                                    <th>Date</th>
                                                    <th>Supplier</th>
                                                    <th>Ref. No.</th>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th>Unit</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require '../php/config.php';
                                                if (isset($_POST['search'])) {
                                                    $date1 = date("Y-m-d", strtotime($_POST['date1']));
                                                    $date2 = date("Y-m-d", strtotime($_POST['date2']));
                                                    $query = mysqli_query($db, "SELECT po_tb.po_date, sup_tb.sup_name, po_tb.po_code, product.product_name, po_product.item_qtyorder, unit_tb.unit_name, product.pro_remarks, po_tb.po_type_id,po_tb.ref_num,po_tb.rec_date
                                    FROM po_tb
                                    LEFT JOIN sup_tb ON sup_tb.sup_id = po_tb.sup_id
                                    LEFT JOIN po_product ON po_product.po_id = po_tb.po_id
                                    INNER JOIN product ON product.product_id = po_product.product_id
                                    LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
                                    LEFT JOIN po_type ON po_type.po_type_id = po_tb.po_type_id
                                    WHERE po_tb.po_type_id = 1 AND po_tb.rec_date 
                                    BETWEEN '$date1' AND '$date2'
                                     ORDER BY sup_tb.sup_name ASC");
                                                    $row = mysqli_num_rows($query);
                                                    if ($row > 0) {
                                                        while ($fetch = mysqli_fetch_array($query)) {
                                                            $dateString = $fetch['rec_date'];
                                                            $dateTimeObj = date_create($dateString);
                                                            $date = date_format($dateTimeObj, 'm/d/y');
                                                ?>

                                                            <tr>
                                                                <td><?php echo $date ?><br></td>
                                                                <td><?php echo $fetch['sup_name'] ?></td>
                                                                <td><?php echo $fetch['ref_num'] ?></td>
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
				<script>alert("No records found !");</script>
			</tr>';
                                                    }
                                                } else {
                                                }
                                                ?>
                                            </tbody>
                                        </table>

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