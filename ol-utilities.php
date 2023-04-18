<?php session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include "php/config.php"; ?>
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
                <h1 class="h2 text-secondary font-monospace">Official Receipt Generator / SHOPEE</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
                        <!-- <div class="btnAdd">
                            <a href="addshopee.php" class="btn btn-sm btn-secondary bg-gradient">
                                Add New Record</a>
                        </div> -->
                    </div>
                </div>
            </div>


            <div class="container-fluid bg-light" style="background-color:#ededed;border:1px solid lightgrey">
                <form action="" method="get">
                    <div class="mb-3">
                        <div class="card mt-3 shadow-sm">
                            <div class="card-header text-secondary font-monospace">
                                Select Statement from Shopee Online Sales
                            </div>
                            <div class="card-body">
                                <div class="form-floating mt-3">
                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="ol_set">
                                        <option selected> </option>
                                        <?php
                                        include "php/config.php";
                                        $records = mysqli_query($db, "SELECT ol_title FROM ol_tb
                                            WHERE ol_tb.ol_type_id = 2 AND ol_tb.ol_id <> 2
                                            GROUP BY ol_title
                                            ORDER BY ol_id DESC");
                                        while ($data = mysqli_fetch_array($records)) {
                                            echo "<option value='" . $data['ol_title'] . "'>" . $data['ol_title'] . "</option>";
                                        }

                                        ?>
                                    </select>

                                </div>

                                <div class="mt-3 float-end">
                                    <button type="submit" name="submit" class="btn btn-secondary bg-gradient btn-sm">Select Record</button>

                                    <a href="ol-utilities.php?ol_set=-----------------&submit=&setAmount=0&fcTotal=0&grandTot=0&addTot=0"> <button type="button" class="btn btn-secondary bg-gradient btn-sm"> Reset Data</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>



                <div class="row">
                    <div class="col">
                        <div class="card mt-3 shadow-sm" style="height:auto">
                            <div class="card-header text-secondary font-monospace">
                                PAY-OUT SUMMARY
                            </div>
                            <div class="card-body">
                                <?php

                                // IF Edit button Click from PO Main
                                if (isset($_GET['submit'])) {

                                    $set = $_GET['ol_set'];

                                    require 'php/config.php';

                                    $result = mysqli_query(
                                        $db,
                                        "SELECT ol_product.ol_id,ol_tb.ol_title,ol_type.ol_type_name,ol_tb.ol_si
                                                    FROM ol_product
                                                    LEFT JOIN ol_tb ON ol_tb.ol_id = ol_product.ol_id
                                                    LEFT JOIN ol_type ON ol_tb.ol_type_id = ol_type.ol_type_id
                                                    WHERE ol_tb.ol_type_id = 2 AND ol_tb.ol_title LIKE '%$set%'

                                                    ORDER BY ol_id DESC"
                                    );



                                    // PO Details
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while ($row = mysqli_fetch_assoc($result)) {

                                            $olSi = $row['ol_si'];
                                            $olTitle = $row['ol_title'];
                                            $ol_type_name = $row['ol_type_name'];
                                            $ol_id = $row['ol_id'];
                                        }
                                    } else {

                                        echo "<script>alert('No Item Selected !');
                                                            location.href ='ol-utilities.php?ol_set=-----------------&submit=&setAmount=0&fcTotal=0&grandTot=0&addTot=0' </script>";
                                    }

                                ?>



                                    <form action="view/ol_or.php" method="GET">

                                        <div class="col fs-small" id="printDiv" style="padding:2%;border:1px dashed lightgrey">
                                            <div class="row text-secondary">
                                                <div class="col">
                                                    <h4><?php
                                                        if ($set == '-----------------') {
                                                            echo " ";
                                                        } else {
                                                            echo $ol_type_name;
                                                        }


                                                        ?></h4>
                                                </div>
                                                <div class="col">
                                                    <div class="row">

                                                        <div class=" col">
                                                            <h5 style="text-align:right ;"><?php echo $olTitle ?></h5>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" value="<?php echo $olTitle ?>" name="set">
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <tr>

                                                        <thead class="text-secondary">
                                                            <!-- <th>OL ID</th> -->
                                                            <th>SI No.</th>
                                                            <th style="text-align: left;">Prod TotQty</th>
                                                            <th>SI Amount</th>
                                                            <th>Adj</th>
                                                            <th>Fee's</th>
                                                            <th>Amount</th>
                                                        </thead>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        include "php/config.php";
                                                        $sql = "SELECT ol_product.ol_id,ol_tb.ol_title,ol_type.ol_type_name,ol_tb.ol_si,ol_tb.ol_adjustment,
                                                                    SUM(ol_product.ol_fee) AS fc,
                                                                    SUM(ol_product.ol_priceTot) AS price,
                                                                    SUM(ol_product.ol_price) AS pricetot,
                                                                    SUM(ol_product.ol_qty) AS qty
                                                                    FROM ol_product

                                                                    LEFT JOIN ol_tb ON ol_tb.ol_id = ol_product.ol_id
                                                                    LEFT JOIN ol_type ON ol_tb.ol_type_id = ol_type.ol_type_id
                                                                    WHERE ol_tb.ol_title ='$set' 
                                                                    GROUP BY ol_tb.ol_id";

                                                        $result = $db->query($sql);
                                                        $count = 0;
                                                        if ($result->num_rows >  0) {

                                                            while ($irow = $result->fetch_assoc()) {
                                                                $limit = 0;
                                                                $totalQyt[] = $irow['qty'];
                                                                $total[] = $irow['price'] + $irow['fc'];
                                                                $fcTotal[] = $irow['fc'];
                                                                $adjustmentTot[] = $irow['ol_adjustment'];
                                                                $siAmount[] = $irow['fc'] + $irow['price'];

                                                        ?>
                                                                <tbody>

                                                                    <td><?php echo $irow['ol_si'] ?></td>
                                                                    <td style="text-align: left;"><?php echo number_format($irow['qty'], 2)  ?></td>
                                                                    <td><?php echo number_format($irow['fc'] + $irow['price'], 2) ?></td>
                                                                    <td><?php echo number_format($irow['ol_adjustment'], 2) ?></td>
                                                                    <td><?php echo number_format($irow['fc'], 2)  ?></td>
                                                                    <td><?php echo number_format($irow['fc'] + $irow['price'] - $irow['fc'], 2) ?></td>
                                                                </tbody>
                                                    </tr>

                                            <?php }
                                                        } ?>
                                            <tr>
                                                <td style="color: red;font-weight:bold;">
                                                    <i>Summary Total</i>
                                                </td>
                                                <td style="text-align: left;">
                                                    <?php
                                                    $limit = 0;
                                                    $qtyTot = 0;
                                                    $disTot = 0;
                                                    while ($limit != count($totalQyt)) {
                                                        $qtyTot += $totalQyt[$limit];

                                                        // $disTot += $totaldisamount[$limit];
                                                        $limit += 1;
                                                    }
                                                    // $grandTot = $subTot - $disTot;

                                                    echo "<b style='color:red;'>" . number_format($qtyTot, 2) . "</b>" ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $limit = 0;
                                                    $subTot = 0;
                                                    $disTot = 0;
                                                    while ($limit != count($total)) {
                                                        $subTot += $total[$limit];

                                                        // $disTot += $totaldisamount[$limit];
                                                        $limit += 1;
                                                    }
                                                    $grandTot = $subTot - $disTot;

                                                    // echo   number_format($grandTot, 2)  ;
                                                    echo "<b style='color:red'>" . number_format($grandTot, 2) . "</b>" ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $limit = 0;
                                                    $subTot = 0;
                                                    $disTot = 0;
                                                    while ($limit != count($adjustmentTot)) {
                                                        $subTot += $adjustmentTot[$limit];

                                                        // $disTot += $totaldisamount[$limit];
                                                        $limit += 1;
                                                    }
                                                    $adjustmentGrandTot = $subTot - $disTot;

                                                    echo "<b style='color:red'>" . number_format($adjustmentGrandTot, 2)  . "</b>" ?></td>
                                                </td>

                                                <td><?php
                                                    $limit = 0;
                                                    $subTot = 0;
                                                    $disTot = 0;
                                                    while ($limit != count($fcTotal)) {
                                                        $subTot += $fcTotal[$limit];

                                                        // $disTot += $totaldisamount[$limit];
                                                        $limit += 1;
                                                    }
                                                    $fCgrandTot = $subTot - $disTot;

                                                    echo "<b style='color:red'>" . number_format($fCgrandTot, 2) . "</b>" ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $fTot = $grandTot - $fCgrandTot + $adjustmentGrandTot;
                                                    echo "<b style='color:red'> " . number_format($fTot, 2) . "</b>"; ?>
                                                </td>
                                            </tr>
                                                </table>
                                            </div>
                                        </div>

                                    <?php
                                } ?>

                                    <!-- <button type="button" class="btn btn-secondary btn-sm bg-gradient mt-3 float-end">Print Summary</button> -->
                            </div>

                        </div>
                    </div>
                    <div class="col">
                        <div class="card mt-3 mb-3 shadow-sm" style="height:auto">
                            <div class="card-header text-secondary font-monospace">
                                SUMMARY
                            </div>
                            <div class="card-body">
                                <h4 class="text-secondary">Summary Breakdown</h4>
                                <br>
                                <table class="table text-secondary">
                                    <tr>
                                        <td>Total Sales Invoice Amount</td>


                                        <td><?php
                                            $limit = 0;
                                            $subTot = 0;
                                            $disTot = 0;

                                            while ($limit != count($total)) {
                                                $subTot += $total[$limit];

                                                // $disTot += $totaldisamount[$limit];
                                                $limit += 1;
                                            }
                                            $grandTot = $subTot - $disTot;

                                            echo "₱ " . number_format($grandTot, 2)  ?></td>

                                    </tr>
                                    <tr>
                                        <td>Adjustment Amount</td>


                                        <td>
                                            <?php
                                            $limit = 0;
                                            $subTot = 0;
                                            $disTot = 0;
                                            while ($limit != count($adjustmentTot)) {
                                                $subTot += $adjustmentTot[$limit];

                                                // $disTot += $totaldisamount[$limit];
                                                $limit += 1;
                                            }
                                            $adjustmentGrandTot = $subTot - $disTot;

                                            echo "+ ₱ " . number_format($adjustmentGrandTot, 2)  ?></td>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Total Fee's & Charges</td>

                                        <td><?php
                                            $limit = 0;
                                            $subTot = 0;
                                            $disTot = 0;
                                            while ($limit != count($fcTotal)) {
                                                $subTot += $fcTotal[$limit];

                                                // $disTot += $totaldisamount[$limit];
                                                $limit += 1;
                                            }
                                            $fCgrandTot = $subTot - $disTot;

                                            echo "- ₱ " . number_format($fCgrandTot, 2)  ?></td>
                                    </tr>
                                    <tr>


                                        <td>
                                            <h5>Settlement Amount</h5>
                                        </td>
                                        <td><?php
                                            $fTot = $grandTot - $fCgrandTot + $adjustmentGrandTot;
                                            echo "<h5>₱ " . number_format($fTot, 2) . "</h5>"; ?>


                                            <input type="hidden" name="setAmount" value="<?php echo $fTot ?>">
                                            <input type="hidden" name="fcTotal" value="<?php echo $fCgrandTot ?>">
                                            <input type="hidden" name="grandTot" value="<?php echo $grandTot ?>">
                                            <input type="hidden" name="addTot" value="<?php echo $adjustmentGrandTot ?>">
                                        </td>
                                    </tr>
                                </table>

                                <div style="float:right">
                                    <button type="submit" class="btn btn-secondary btn-sm bg-gradient" name="save">Generate OR</button>

                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- end of content -->

            <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
            <script src="styles/dataTableStyle/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
            <script src="styles/dataTableStyle/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script type="text/javascript" src="styles/dataTableStyle/js/dt-1.10.25datatables.min.js"></script>

            <script>
                document.getElementById("doPrint").addEventListener("click", function() {
                    var printContents = document.getElementById('printDiv').innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                });
            </script>

            <?php include "footer.php"; ?>
</body>





</html