<?php session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include "php/config.php";

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $class_name = $_POST['class_name'];
    $dept_id = $_POST['dept_id'];

    mysqli_query($db, "UPDATE class_tb SET class_name='$class_name', dept_id ='$dept_id' WHERE class_id='$id'");
    echo "<script type='text/javascript'>alert('Update Records Successfully!');
                                    location.href ='class-index.php'</script>";
}


if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {


    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT
                                    class_tb.class_id,class_tb.class_name,dept_tb.dept_name,dept_tb.dept_id
                                    FROM class_tb
                                    LEFT JOIN dept_tb ON dept_tb.dept_id = class_tb.dept_id
                                    WHERE class_tb.class_id=" . $_GET['id']);

    $row = mysqli_fetch_array($result);

    if ($row) {
        $class_id = $row['class_id'];
        $class_name = $row['class_name'];
        $dept_name = $row['dept_name'];
    } else {
        echo "No results!";
    }
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
                <h1 class="h2 text-secondary font-monospace">ITEM CLASSIFICATION</h1>
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
                        <div class="card mt-4 shadow-sm">
                            <h6 class="card-header font-monospace" style="color:grey">CREATE NEW CLASS</h6>
                            <div class="card-body">
                                <div class="alert alert-secondary d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                        <use xlink:href="#info-fill" />
                                    </svg>
                                    <div>
                                        Please check on <strong>CLASS TABLE</strong> before creating new record !
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" disabled>
                                    <label for="floatingInput">Class Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" disabled>
                                            <option class="select__option--class"></option>
                                            <?php
                                            include "../php/config.php";
                                            $records = mysqli_query($db, "SELECT * FROM dept_tb");

                                            while ($data = mysqli_fetch_array($records)) {
                                                echo "<option value='" . $data['dept_id'] . "'>" . $data['dept_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Department</label>
                                    </div>
                                </div>
                                <div class="row mb-3 float-end">
                                    <div class="col"><button type="button" class="btn btn-secondary bg-gradient btn-sm" disabled>Save Class</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <h6 class="card-header font-monospace" style="color:grey">EDIT CLASS</h6>
                            <div class="card-body">


                                <form method="POST">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingInput" name="class_name" value="<?php echo $class_name; ?>">
                                                <label for="floatingInput">Class Name</label>
                                            </div>
                                        </div>

                                        <div class="col-5">
                                            <div class="form-floating mb-3">
                                                <div class="form-floating">
                                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="dept_id">
                                                        <option class="select__option--class" value="<?php echo $row['dept_id']; ?>"><?php echo $row['dept_name']; ?></option>
                                                        <?php
                                                        include "config.php";
                                                        $records = mysqli_query($db, "SELECT * FROM dept_tb");

                                                        while ($data = mysqli_fetch_array($records)) {
                                                            echo "<option value='" . $data['dept_id'] . "'>" . $data['dept_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="floatingSelect">Department</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row float-end">
                                        <div class="col">
                                            <button type="submit" class="btn btn-secondary bg-gradient btn-sm " name="submit">Update Record</button>
                                            <a href="class-index.php"> <button type="button" class="btn btn-secondary bg-gradient btn-sm ">Cancel</button></a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-8">
                        <div class="card mb-3 mt-4 shadow-sm">
                            <h6 class="card-header font-monospace" style="color:grey">CLASS TABLE</h6>
                            <div class="card-body bg-gradient">
                                <div class="table-responsive mt-2 mb-2" style="overflow-x:hidden;padding:1%;">
                                    <table id="example" class="table table-hover mt-3 table-sm" style="border:solid 1px lightgrey">
                                        <thead class="table-light bg-gradient  sticky-sm-top top-1 mb-2 mt-2 ml-2" style="z-index:1;">
                                            <th style="color:grey" width="8%">&nbsp;CLASS ID</th>
                                            <th style="color:grey;" width="30%">CLASS NAME</th>
                                            <th style="color:grey" width="20%">DEPARTMENT</th>
                                            <th style="color:grey" width="10%"> </th>
                                        </thead>

                                    </table>
                                    <br>
                                </div>
                                <div class="col-md-2"></div>

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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({

                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                    $(nRow).attr('class_id', aData[0]);
                },

                'responsive': 'true',
                'serverSide': 'true',
                'processing': 'true',
                'paging': 'true',
                'order': [],
                'ajax': {
                    'url': 'fetch/data_class.php',
                    'type': 'post',
                },
                "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [1]
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


    </div>
    <?php include "footer.php"; ?>
</body>



<script>
    function setDecimal(event) {
        this.value = parseFloat(this.value).toFixed(13);
    }
</script>

</htm