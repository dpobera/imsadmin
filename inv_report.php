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
                                    <i class="bi bi-info-circle-fill"></i> Choose on <strong>DEPARTMENT</strong> listed below to generate reports based on inventory records.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <form class="form-inline" method="GET" action="">
                                    <div class="range">
                                        <div class="form-floating mb-5">
                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="dept_id">
                                                <option></option>
                                                <?php
                                                include "php/config.php";
                                                $records = mysqli_query($db, "SELECT * FROM dept_tb WHERE dept_type = 0");
                                                while ($data = mysqli_fetch_array($records)) {
                                                    echo "<option value='" . $data['dept_id'] . "'>" . $data['dept_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="floatingSelect">Department List</label>


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
                            <h6 class="card-header font-monospace" style="color:grey">DETAILED REPORT LIST</h6>
                            <div class="card-body bg-gradient">
                                <div class="content " style="background-color: white;">
                                    <div id="report">
                                        <div class="header mt-3" style="text-align:center;">
                                            <h5>Philippine Acrylic & Chemical Corporation</h5>
                                            <h6 style="line-height: .5;">Inventory Management System</h6>
                                            <h6>Inventory Reports</h6>
                                        </div>
                                        <div class=" dept-title">
                                            <?php

                                            $dept_id = $_GET['dept_id'];
                                            $date = date('m/d/Y', time());
                                            $result = mysqli_query(
                                                $db,
                                                "SELECT * FROM dept_tb WHERE dept_id  = '$dept_id'"
                                            );

                                            if (mysqli_num_rows($result) > 0) {
                                                // output data of each row
                                                while ($row = mysqli_fetch_assoc($result)) {

                                                    $dept_name = $row['dept_name'];
                                                }
                                            } else {
                                                echo "0 results";
                                            }

                                            ?>
                                            <div class="row">
                                                <div class="col">
                                                    <strong>Department :</strong> <?php echo $dept_name ?>
                                                </div>
                                                <div class="col" style="text-align:right">
                                                    <strong>Date Generated :</strong> <?php echo $date ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <strong>Submitted by:</strong> <?php echo $_SESSION["empName"]; ?>
                                                </div>
                                            </div>
                                            <hr>


                                            <!-- <script>
                            //date
                            document.querySelector('.date').value = new Date().toISOString();
                        </script> -->
                                        </div>
                                        <?php
                                        /*
 
*   File:       displayByCompany.php
 
*/


                                        // Connect DB

                                        $hostName  = "localhost";
                                        $userName = "root";
                                        $userPassword = "";
                                        $database = "inventorymanagement";
                                        $comArray = array();
                                        $orderClause = '';
                                        $tempcompany = '';
                                        $comArray = array();


                                        $dbConnectionStatus  = new mysqli($hostName, $userName, $userPassword, $database);

                                        //Connection Error
                                        if ($dbConnectionStatus->connect_error) {


                                            die("Connection failed: " . $dbConnectionStatus->connect_error);
                                        }
                                        // Connected to Database JaneDB
                                        // Object oriented  -> pointing 
                                        if ($dbConnectionStatus->query("SELECT DATABASE()")) {

                                            $dbSuccess = true;
                                            //
                                            $result = $dbConnectionStatus->query("SELECT DATABASE()");
                                            $row = $result->fetch_row();
                                            // printf("Default database is %s.\n", $row[0]);
                                            $result->close();
                                        }


                                        // DB Connect Successful

                                        if ($dbSuccess) {

                                            //  -------------------- Style declarations---------------------------------------------------------


                                            $textFont = 'style = " font-family: arial, helvetica, sans-serif; "';
                                            $indent50 = 'style = " margin-left: 0; "';
                                            $indent100 = 'style = " margin-left: 0; "';
                                            //  ----------------------------------------------------------------------------------------------------


                                            // echo '<h1>PACC Inventory List</h1>';

                                            //-------------------------- Select Company Querries-------------------------------------------------------


                                            if (isset($_GET['search'])) {


                                                $dept_id = $_GET['dept_id'];


                                                $selectCompany = "SELECT product.product_id, product.product_name,class_tb.class_name,dept_tb.dept_name
                                        FROM product
                                        LEFT JOIN dept_tb ON dept_tb.dept_id = product.dept_id
                                        LEFT JOIN class_tb ON class_tb.class_id = product.class_id

                                        WHERE product.dept_id = '$dept_id' 
                                        AND class_tb.dept_id = '$dept_id'  
                                        ORDER BY class_tb.class_name ASC";



                                                $selectCompany_Query = mysqli_query($dbConnectionStatus, $selectCompany);
                                                $companyArray = array();

                                                // Loop Through Company Records
                                                while ($rowsCompany = mysqli_fetch_assoc($selectCompany_Query)) {

                                                    // Get the Company Name/ id


                                                    $companyName = $rowsCompany['class_name'];

                                                    // Check whether the Company Table is Created f No Create the Table
                                                    if (!in_array($companyName, $comArray)) {

                                                        array_push($comArray, $companyName);

                                                        echo '<br>';

                                                        echo '<div class="shadow-sm" id="conentTb" style="padding:2%; border:1px dotted lightgrey;"';

                                                        echo '<h5' . $indent50 . ' >' . '<strong>**</strong> GROUP  <b>' . $companyName . '</b></h5>';
                                                        echo '<div ' . $indent100 . '>';
                                                        echo "<table border='0' class='table'";

                                                        echo "<tr>";
                                                        // echo "<td style='width:10% ;font-weight:bold'>Product_id</td>";
                                                        echo "<td style='width:50%;font-weight:bold'>PRODUCT</td>";
                                                        // echo "<td style='width:20%;font-weight:bold'>Location</td>";
                                                        echo "<td style='width:20%;font-weight:bold;text-align:right'>B.BAL</td>";
                                                        echo "<td style='width:20%;font-weight:bold'>UNIT</td>";
                                                        echo "<td style='width:20%;font-weight:bold;text-align:right'>E.BAL</td>";
                                                        echo "<td style='width:20%;font-weight:bold'>UNIT</td>";
                                                        echo "<td style='width:20%;font-weight:bold'>REMARKS</td>";

                                                        echo "</tr>";

                                                        //-----------------Add Row into the Selected Company --------------------------------

                                                        $selectPerson = "SELECT
                                    product.product_id, product.product_name,class_tb.class_name,product.qty,unit_tb.unit_name,loc_tb.loc_name,dept_tb.dept_id,product.pro_remarks
                                                FROM product
                                                LEFT JOIN dept_tb ON dept_tb.dept_id = product.dept_id
                                                LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                                LEFT JOIN unit_tb ON unit_tb.unit_id= product.unit_id
                                                LEFT JOIN loc_tb ON loc_tb.loc_id= product.loc_id
                                                 WHERE class_tb.class_name = '$companyName' AND product.qty > 0.000001 AND product.dept_id = '$dept_id' 
                                                 ORDER BY product.product_id ASC";

                                                        $selectPerson_Query = mysqli_query($dbConnectionStatus, $selectPerson);
                                                        $arrayPerson = array();
                                                        while ($personrows = mysqli_fetch_assoc($selectPerson_Query)) {

                                                            $arrayPerson[] = $personrows;
                                                        }




                                                        foreach ($arrayPerson as $data) {

                                                            echo '<tr>';
                                                            // Search through the array print out value if see the Key  eg: 'id', 'product_name ' etc.
                                                            // echo '<td>' . str_pad($data['product_id'], 8, 0, STR_PAD_LEFT) . '</td>';
                                                            echo '<td>' . $data['product_name'] . '</td>';
                                                            // echo '<td>' . $data['loc_name'] . '</td>';
                                                            echo '<td style="text-align:right">0.00</td>';
                                                            echo '<td> ' . $data['unit_name'] . '</td>';

                                                            echo '<td style="text-align:right">' . $str = $data['qty'];
                                                            strlen(substr(strrchr($str, "."), 2));
                                                            '</td>';
                                                            echo '<td>' . $data['unit_name'] . '</td>';
                                                            echo '<td>' . $data['pro_remarks'] . '</td>';
                                                            // echo '<td>' . $data['pro_remarks'] . '</td>';
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                        }

                                                        //-------------------------------------------------------------------------------------

                                                        echo '<tr>';

                                                        echo '<td style="color:red"><strong><i>Subtotal</i></strong></td>';
                                                        echo '<td style="text-align:right;color:red"><strong>0.00</strong></td>';

                                                        //SUM and display total of quantity
                                                        $selectPerson2 = "SELECT SUM(product.qty) AS total
                                    FROM product
                                    LEFT JOIN class_tb ON class_tb.class_id = product.class_id
                                    WHERE class_tb.class_name = '$companyName' AND product.dept_id = '$dept_id' ";

                                                        $selectPerson_Query2 = mysqli_query($dbConnectionStatus, $selectPerson2);
                                                        $arrayPerson2 = array();

                                                        while ($personrows2 = mysqli_fetch_assoc($selectPerson_Query2)) {

                                                            $arrayPerson2[] = $personrows2;
                                                        }
                                                        foreach ($arrayPerson2 as $data2) {

                                                            echo '<td style="text-align:right;color:red"></td>';
                                                            echo '<td style="color:red;margin:0px;text-align:right"> <b>' . number_format($data2['total'], 2) . '</b></td>';
                                                            echo '<td style="text-align:right;color:red"><b></b></td>';
                                                            echo '<td style="text-align:right;color:red"><b></b></td>';
                                                            echo '</tr>';
                                                        }
                                                        echo "</table>";
                                                        echo '</div>';
                                                        echo '</div>';
                                                    }
                                                }





                                                echo '</div>';
                                            }
                                        }


                                        ?>
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