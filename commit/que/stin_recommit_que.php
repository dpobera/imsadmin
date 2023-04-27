<?php session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include "../../php/config.php";
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT stin_tb.stin_id,stin_tb.stin_code,stin_tb.stin_title,stin_tb.stin_date, employee_tb.emp_name
     FROM stin_tb
     LEFT JOIN employee_tb On employee_tb.emp_id = stin_tb.emp_id
      WHERE stin_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['stin_id'];
        $stin_code = $row['stin_code'];
        $stin_title = $row['stin_title'];
        $dateString = $row['stin_date'];
        $emp_name = $row['emp_name'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'm/d/y');
    } else {
        echo "No results!";
    }
}


//insert new items to database

if (isset($_GET['submit'])) {

    include "../../php/config.php";
    $id = $_GET['id'];
    $bal_qty = $_GET['bal_qty'];
    $in_qty = $_GET['in_qty'];
    $productId = $_GET['product_id'];
    $stin_id = $_GET['stin_id'];
    $mov_date = $_GET['mov_date'];

    $sql = "SELECT closed FROM stin_tb WHERE stin_id = " . $_GET['stin_id'];
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $closed = $row['closed'];
        }
    } else {
        echo "0 results";
    }


    if ($closed == 0) {
        foreach ($_GET['stin_temp_tot'] as $stin_temp_tot) {
            $total[] = $stin_temp_tot;
        }

        foreach ($_GET['product_id'] as $product_id) {
            $pro_id[] = $product_id;
        }



        $limit = 0;
        while ($limit != count($pro_id)) {


            $sql = "UPDATE product SET qty = " . $total[$limit] . " WHERE product_id=" . $pro_id[$limit];

            mysqli_query($db, $sql);


            $limit += 1;
        }
        $limit = 0;
        while ($limit != count($pro_id)) {


            $sql = "UPDATE stin_product SET stin_product_status = 1 WHERE stin_id =" . $id . " AND product_id=" . $pro_id[$limit];

            mysqli_query($db, $sql);


            $limit += 1;
        }


        $limit = 0;
        while (sizeof($productId) !== $limit) {

            $sql = "INSERT INTO move_product (product_id,bal_qty,in_qty,mov_type_id,move_ref,mov_date)
            VALUES (" . $productId[$limit] . "," . $bal_qty[$limit] . "," . $in_qty[$limit] . ", 1 " . "," . $stin_id . ",'" . $mov_date . "')";
            if (mysqli_query($db, $sql)) {

                $status2 = "Inventory Records UPDATED !";
                echo "<script> alert('" . $status2 . "')
	location.href = '../stin_recommit.php?id=" . $_GET['id'] . "'</script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
            }

            $limit++;
        }
    } else {
        $status = "Transaction Closed, Viewing Purpose Only !";
        echo "<script> alert('" . $status . "')
		location.href = '../../stin-index.php'</script>";
    }

    // header("location: ../../stin-index.php");
}



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
    <link rel="shortcut icon" href="../../assets/brand/pacclogoWhite.ico" type="image/x-icon">


    <script src="../styles/sidebars.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../styles/dataTableStyle/css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="../../stylesheet" type="text/css" href="styles/dataTableStyle/css/datatables-1.10.25.min.css" />

    <!-- Custom styles for this template -->
    <link href="../styles/sidebars.css" rel="stylesheet">
    <link rel="../stylesheet" href="css/index-style.css">

</head>

<body style="background-color: white;">
    <header class="navbar navbar-dark bg-dark bg-gradient sticky-top flex-md-nowrap p-0">
        <a class="navbar-brand bg-dark bg-gradient col-md-3 col-lg-2 me-0 px-3" href="../../stin-index.php">
            <img src="../../assets/brand/pacclogo.png" alt="" width="25" style="margin-bottom: 3px;"> PACC IMS v2.0
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- <input class="form-control form-control w-100" type="text" placeholder="Search" aria-label="Search"> -->
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="../../php/logout-inc.php" title="Sign-Out">Sign out <i class="bi bi-box-arrow-left"></i></a>
            </div>
        </div>
    </header>


    <!-- content -->
    <div class="container-fluid">

        <main class="col-md-12 ms-sm-auto col-md-10 px-md-4">
            <!-- Itemlist Records header-->
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
                <h1 class="h2 text-secondary font-monospace">STOCK-IN / RECOMIT / SAVE</h1>
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


            <!-- table container -->
            <div class="container-fluid bg-light" style="background-color:#ededed;border:1px solid lightgrey">

                <div class="row  p-3">
                    <div class="col-5  p-4">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" value="<?php echo str_pad($id, 8, 0, STR_PAD_LEFT) ?>" style="cursor:not-allowed" readonly>
                                    <label for="floatingInput">Stock-In ID</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" value="<?php echo $stin_code ?>" style="cursor:not-allowed" readonly>
                                    <label for="floatingInput">Stock-In Code</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" value="<?php echo $stin_title ?>" style="cursor:not-allowed" readonly>
                                    <label for="floatingInput">Job-Order No.</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" value="<?php echo $emp_name ?>" style="cursor:not-allowed" readonly>
                                    <label for="floatingInput">Prepared By</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" value="<?php echo $date ?>" style="cursor:not-allowed" readonly>
                                    <label for="floatingInput">Stock-In Date</label>
                                </div>
                            </div>
                        </div>
                        <form method="GET">
                            <div class="table-responsive mt-2 mb-2" style="overflow:hidden;padding:0%;">
                                <table class="table table-hover table-sm shadow-sm mt-4" style="background-color:white;border:1px solid lightgrey">
                                    <thead class="table-light bg-gradient table-sm sticky-sm-top top-1 mb-2 mt-2 ml-2 text-secondary">
                                        <th width="20%">PRODUCT ID</th>
                                        <th width="60%">ITEM NAME</th>
                                        <th width="20%">ACTION</th>


                                    </thead>
                                    <?php
                                    include "../../php/config.php";
                                    $id = $_GET['id'];

                                    $sql = "SELECT stin_tb.stin_id, product.product_id,product.product_name,product.qty,stin_product.stin_temp_qty,unit_tb.unit_name,product.cost,
                                    stin_product.stin_temp_disamount, product.barcode,stin_product.stin_product_status,stin_tb.closed
                                    FROM stin_product 
                                    LEFT JOIN product ON product.product_id = stin_product.product_id
                                    LEFT JOIN stin_tb ON stin_product.stin_id=stin_tb.stin_id
                                    LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id 
                                    WHERE stin_product.stin_id='$id' ";

                                    $result = $db->query($sql);
                                    $count = 0;
                                    if ($result->num_rows >  0) {

                                        while ($irow = $result->fetch_assoc()) {
                                            $product_id = $irow['product_id'];
                                            $stinProdStat = $irow['stin_product_status'];
                                    ?>
                                            <tr>
                                                <td style="display:none"><input type="hidden" name="id" value="<?php echo $id ?>"></td>
                                                <td><input type="hidden" name="product_id" value="<?php echo $product_id ?>"><?php echo str_pad($product_id, 8, 0, STR_PAD_LEFT) ?></td>
                                                <td> <?php echo $irow['product_name'] ?></td>
                                                <td>

                                                    <?php
                                                    if ($stinProdStat == 1) {
                                                        echo "<p class='text-danger'>CLOSED</p>";
                                                    } else {
                                                        echo ' <a href="#"> 
                                                        <button class="btn btn-primary btn-sm bg-gradient" type="button" disabled>comit</button></a>';
                                                    }
                                                    ?>


                                                </td>
                                            </tr>

                                    <?php }
                                    } ?>

                                </table>
                                <br>
                                <a href="#"><button class="btn btn-sm btn-danger bg-gradient" type="button" disabled>DONE</button></a>


                            </div>
                        </form>
                    </div>
                    <div class="col-7">
                        <div class="card shadow-sm">
                            <div class="card-header text-secondary font-monospace">
                                ITEM TO BE COMITTED
                            </div>
                            <div class="card-body text-secondary">
                                <h5 class="card-title"></h5>

                                <input type="hidden" name="id" value="<?php echo $id; ?>" />

                                <div class="container--table">
                                    <div class="table-responsive">
                                        <form action="" method="GET">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                            <input type="hidden" name="stin_id" value="<?php echo $_GET['id'] ?>">
                                            <input type="hidden" name="mov_date" class="date">
                                            <div class="table-responsive" style="height: 32vh;background-color:white;border:1px solid lightgrey">
                                                <table class="table table-sm table-hover">
                                                    <thead class="table table-light text-secondary">
                                                        <tr style="text-align: left;">
                                                            <th width="10%">Prod ID</th>
                                                            <th width="55%">Item Name</th>
                                                            <th width="10%">Barcode</th>
                                                            <th width="10%">On-Hand</th>
                                                            <th width="10%">Qty-In</th>
                                                            <th width="5%">Unit</th>
                                                            <th width="10%">Incoming Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $product_id = $_GET['product_id'];
                                                    $sql = "SELECT stin_tb.stin_id, product.product_id,product.product_name,product.qty,stin_product.stin_temp_qty,unit_tb.unit_name,product.cost,
                                                stin_product.stin_temp_disamount, product.barcode
                                                FROM stin_product 
                                                LEFT JOIN product ON product.product_id = stin_product.product_id
                                                LEFT JOIN stin_tb ON stin_product.stin_id=stin_tb.stin_id
                                                LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id 
                                                WHERE stin_product.stin_id='$id' AND stin_product.product_id = '$product_id'";

                                                    $result = $db->query($sql);
                                                    $count = 0;
                                                    if ($result->num_rows >  0) {

                                                        while ($irow = $result->fetch_assoc()) {


                                                    ?>
                                                            <tr>
                                                                <td><?php echo str_pad($irow["product_id"], 8, 0, STR_PAD_LEFT); ?></td>
                                                                <td contenteditable="false"><?php echo $irow['product_name'] ?></td>
                                                                <td contenteditable="false">
                                                                    <?php
                                                                    if ($irow['barcode'] == "") {
                                                                        echo "N/A";
                                                                    } else {
                                                                        echo $irow['barcode'];
                                                                    }
                                                                    ?></td>
                                                                <td style="text-align: right;"><input type="text" name="bal_qty[]" value="<?php echo $irow['qty'] ?>" style="border: none;width:100%;background-color:transparent;" readonly></td>
                                                                <td contenteditable=" false">
                                                                    <input type="number" class="form-control" name="in_qty[]" value="<?php echo $irow['stin_temp_qty'] ?>" style="border: none;text-align:left:100%;background-color:transparent;">
                                                                </td>
                                                                <td contenteditable="false"><?php echo $irow['unit_name'] ?></td>
                                                                <td class="stin_temp_tot"><input type="number" style="border: none;background-color:transparent;color:tomato;font-weight:bold" name="stin_temp_tot[]" value="<?php echo $irow["qty"] + $irow["stin_temp_qty"]; ?>" contenteditable="false"></td>

                                                            </tr>
                                                            <input type="hidden" name="product_id[]" value="<?php echo $irow['product_id'] ?>">

                                                    <?php }
                                                    } ?>

                                                </table>

                                            </div>
                                            <div class="row mt-4">
                                                <div class="col float-end">
                                                    <button type="submit" name="submit" class="btn btn-secondary bg-gradient">Commit Records</button>
                                                    <a href=" ../stin_recommit.php?id=<?php echo $id ?>"><button type="button" class="btn btn-secondary bg-gradient">Cancel</button></a>
                                                </div>
                                            </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>








                </div>

            </div>



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




    <!-- <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({

                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                    $(nRow).attr('ol_id', aData[0]);
                },

                // 'select': 'true',
                'responsive': 'true',
                'serverSide': 'true',
                'processing': 'true',
                'paging': 'true',
                'order': [],

                "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0]

                    },

                ],

            });

        });
    </script> -->

    <!-- <script>
        //Jquery codes
        $(document).ready(function() {
            // //Auto incrementing Order-ID
            $(".newStinId").load("addrecord/orderid/auto-order-id-item.php");
        })
    </script> -->


    <?php include "../../footer.php"; ?>
</body>



<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<!-- Optional JavaScript; choose one of the two! -->
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="../styles/dataTableStyle/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="../styles/dataTableStyle/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="../styles/dataTableStyle/js/dt-1.10.25datatables.min.js"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script> -->


<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({

            "fnCreatedRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr('stin_id', aData[0]);
            },
            'responsive': 'true',
            'serverSide': 'true',
            'processing': 'true',
            'paging': 'true',
            'order': [],
            'ajax': {
                'url': '../fetch/data_stin_product.php',
                'type': 'post',
            },
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0]
                },

            ],

        });

    });
</script>
<script>
    function setDecimal(event) {
        this.value = parseFloat(this.value).toFixed(13);
    }
</script>
<script>
    //date
    document.querySelector('.date').value = new Date().toISOString();
    // The function below will start the confirmation dialog
</script>

</html>