<?php session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include "php/config.php";


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
    <link rel="shortcut icon" href="assets/brand/pacclogoWhite.ico" type="image/x-icon">


    <script src="styles/sidebars.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/dataTableStyle/css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/dataTableStyle/css/datatables-1.10.25.min.css" />

    <!-- Custom styles for this template -->
    <link href="styles/sidebars.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index-style.css">
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
                <a class="nav-link px-3" href="php/logout-inc.php" title="Sign-Out">Sign out <i class="bi bi-box-arrow-left"></i></a>
            </div>
        </div>
    </header>


    <!-- content -->
    <div class="container-fluid">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
            <!-- Itemlist Records header-->
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
                <h1 class="h2 text-secondary font-monospace">DETAILED INVENTORY REPORT</h1>
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
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </symbol>
                <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </symbol>
                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </symbol>
            </svg>
            <!-- table container -->
            <div class="container-fluid bg-light" style="background-color:#ededed;border:1px solid lightgrey">
                <div class="row">
                    <div class="col-4">
                        <div class="card mt-4 mb-4 shadow-sm">
                            <h6 class="card-header font-monospace" style="color:grey">GENERATE REPORT</h6>
                            <div class="card-body">
                                <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                    <i class="bi bi-info-circle-fill"></i> Select <strong>DATE RANGE</strong> to generate report.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <form class="form-inline" method="GET" action="">
                                    <div class="range">

                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" name="date1">
                                            <label for="floatingInput">FROM</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" name="date2">
                                            <label for="floatingInput">TO</label>
                                        </div>




                                        <div class="row float-end">
                                            <div class="col-12"><button class="btn btn-secondary bg-gradient btn-sm" name="search" id='button'>Generate</button>
                                                <button class="btn btn-secondary bg-gradient btn-sm" type="button" id="print">Print Report</button>
                                                <!-- <a href="itemlist-index.php"> <button type="button" class="btn btn-secondary bg-gradient btn-sm">Cancel</button></a> -->
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card mb-4 mt-4 shadow-sm">
                            <h6 class="card-header font-monospace" style="color:grey">SUMMARY REPORT</h6>
                            <div class="card-body bg-gradient">
                                <div class="content" style="background-color: white;">
                                    <div id="report">
                                        <div class="header " style="text-align:center;">
                                            <br>
                                            <h5>Philippine Acrylic & Chemical Corporation</h5>
                                            <h6 style="line-height: .5;">Inventory Management System</h6>
                                            <h6>Summary Inventory Reports</h6>
                                        </div>
                                        <hr>
                                        <div style="padding:3%">

                                            <?php
                                            $dateString = $_GET['date1'];
                                            $dateTimeObj = date_create($dateString);
                                            $date = date_format($dateTimeObj, 'F d ');

                                            $dateString2 = $_GET['date2'];
                                            $dateTimeObj2 = date_create($dateString2);
                                            $date2 = date_format($dateTimeObj2, 'F d, Y ');

                                            if (isset($_GET['search'])) {
                                                echo $date; ?> - <?php echo $date2; ?>

                                                <table class="table table-bordered mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">DEPARTMENT</th>
                                                            <th scope="col">FINISH GOODS</th>
                                                            <th scope="col">RAW MATERIAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>ACRYLIC</td>

                                                            <td> <?php

                                                                    $result = mysqli_query(
                                                                        $db,
                                                                        "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 3 AND class_tb.class_type = 0"
                                                                    );

                                                                    if (mysqli_num_rows($result) > 0) {
                                                                        // output data of each row
                                                                        while ($row = mysqli_fetch_assoc($result)) {

                                                                            $totalAcry = $row['tot'];
                                                                        }
                                                                    } else {
                                                                        echo "0 results";
                                                                    }
                                                                    ?><?php echo number_format($totalAcry, 2);  ?> pcs
                                                            </td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 3 AND class_tb.class_type = 1"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalAcry2 = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalAcry2, 2);  ?> pcs</td>


                                                        </tr>
                                                        <tr>
                                                            <td>FABRICATION</td>

                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 2 AND class_tb.class_type = 0"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalFab = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalFab, 2); ?> pcs</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 2 AND class_tb.class_type = 1"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalFab2 = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalFab2, 2); ?> pcs</td>

                                                        </tr>
                                                        <tr>
                                                            <td>PROCESSING</td>

                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 1 AND class_tb.class_type = 0"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalPro = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalPro, 2); ?> kgs</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 1 AND class_tb.class_type = 1"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalPro2 = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalPro2, 2); ?> kgs</td>

                                                        </tr>
                                                        <tr>
                                                            <td>SALES & DELIVERY</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 12 AND class_tb.class_type = 0"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalSal = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalSal, 2); ?> pcs</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 12 AND class_tb.class_type = 1"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalSal2 = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalSal2, 2); ?> pcs</td>

                                                        </tr>
                                                        <tr>
                                                            <td>ADMINISTRATION</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 8 AND class_tb.class_type = 0"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalAdm = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalAdm, 2); ?> pcs</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 8 AND class_tb.class_type = 1"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalAdm2 = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalAdm2, 2); ?> pcs</td>

                                                        </tr>
                                                        <tr>
                                                            <td>MAINTENANCE</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 12 AND class_tb.class_type = 0"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalMai = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalMai, 2); ?> pcs</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 12 AND class_tb.class_type = 1"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalMai2 = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalMai2, 2); ?> pcs</td>


                                                        </tr>
                                                        <tr>
                                                            <td>AGRICULTURE</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 17 AND class_tb.class_type = 0"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalAgr = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalAgr, 2); ?> pcs</td>
                                                            <td><?php
                                                                $result = mysqli_query(
                                                                    $db,
                                                                    "SELECT SUM(product.qty) AS tot FROM product
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                        WHERE product.dept_id = 17 AND class_tb.class_type = 1"
                                                                );

                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // output data of each row
                                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                                        $totalAgr2 = $row['tot'];
                                                                    }
                                                                } else {
                                                                    echo "0 results";
                                                                } ?><?php echo number_format($totalAgr2, 2) . ' pcs';
                                                                    ?> </td>


                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="alert alert-secondary bg-gradient" role="alert">
                                                    <i><strong>*</strong> Total <strong>Quantity</strong> based on ending inventory reports.</i>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Button trigger modal -->



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

            <script>
                document.getElementById("print").addEventListener("click", function() {
                    var printContents = document.getElementById('report').innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                });

                function myFunction() {
                    alert("Reset Data successfully !");
                }
            </script>


    </div>
    <?php include "footer.php"; ?>
</body>



<script>
    function setDecimal(event) {
        this.value = parseFloat(this.value).toFixed(13);
    }
</script>

</htm