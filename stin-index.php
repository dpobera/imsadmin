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
                <a class="nav-link px-3 " href="php/logout-inc.php" title="Sign-Out">Sign out <i class="bi bi-box-arrow-left"></i></a>
            </div>
        </div>
    </header>


    <!-- content -->
    <div class="container-fluid">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
            <!-- Itemlist Records header-->
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
                <h1 class="h2 text-secondary font-monospace">STOCK INVENTORY IN </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
                        <div class="btnAdd">
                            <a href="addstin.php" class="btn btn-sm btn-secondary bg-gradient">
                                Add New Record</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- table container -->
            <div class="container-fluid bg-light" style="background-color:#ededed;border:1px solid lightgrey">
                <div class="table-responsive mt-2 mb-2" style="overflow-x:hidden;padding:1%;">
                    <table id="example" class="table table-hover table-sm" style="background-color:white;border:1px solid lightgrey;">
                        <thead class="table-light bg-gradient table-sm sticky-sm-top top-1 mb-2 mt-2 ml-2 bg-gradient" style="z-index:1;">
                            <th style="color:grey;" width="10%">&nbsp;STIN ID</th>
                            <th style="color:grey;" width="10%">STIN NO.</th>
                            <th style="color:grey" width="10%">JO No.</th>
                            <th style="color:grey" width="10%">PREPARED BY</th>
                            <th style="color:grey;text-align:center" width="10%">DATE</th>
                            <th style="color:grey" width="25%">REMARKS</th>
                            <th style="color:grey;text-align:center" width="10%"> </th>
                            <th style="color:grey;text-align:center" width="10%">CREATED BY</th>
                            <th style="color:grey;text-align:center" width="5%">STATUS</th>
                        </thead>
                    </table>
                    <br>
                </div>
                <div class="col-md-2"></div>

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
                    'url': 'fetch/data_stin.php',
                    'type': 'post',
                },
                "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [5]
                    },

                ],

            });

        });
    </script>

    <script>
        //Jquery codes
        $(document).ready(function() {
            // //Auto incrementing Order-ID
            $(".newStinId").load("addrecord/orderid/auto-order-id-item.php");
        })
    </script>

    </form>
    </div>
    <?php include "footer.php"; ?>
</body>



<script>
    function setDecimal(event) {
        this.value = parseFloat(this.value).toFixed(13);
    }
</script>

</html>