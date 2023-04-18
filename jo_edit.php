<?php include 'header.php';
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include 'php/jo_edit-inc.php'
?>
<link rel="stylesheet" href="css/jo_edit-style2.css">

<style>
    thead {
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        z-index: 1;
        text-transform: uppercase;


    }
</style>
<script defer src="js/jo_edit-script.js"></script>

<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
                <h1 class="h2 text-secondary font-monospace">JOB-ORDER / Editing Records</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
                        <div class="btnAdd">

                        </div>
                    </div>
                </div>
            </div>

            <!-- content -->
            <div class="container-fluid shadow-sm bg-light" style="border:1px solid lightgrey">
                <div class="row">
                    <?php include "sidebar.php"; ?>
                    <div class="row">
                        <form action="php/jo_edit-inc.php" method="POST">
                            <div class="form-floating mb-1 mt-2">
                                <input type="text" class="form-control form-control-sm" id="id" name="joId" value="<?php echo str_pad($joId, 8, 0, STR_PAD_LEFT) ?>" style="width:auto" readonly>
                                <label for="floatingInput"> Job-Order ID</label>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control form-select-sm" name="joNo" value="<?php echo $joNo ?>">
                                        <label for="floatingInput">Job-Order No.</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select form-control-sm" id="floatingSelect" aria-label="Floating label select example" name="empId">
                                            <option value="<?php echo $empId ?>"><?php echo $empName; ?></option>
                                            <?php
                                            include "php/config.php";
                                            $records = mysqli_query($db, "SELECT * FROM employee_tb ORDER BY emp_name ASC");

                                            while ($data = mysqli_fetch_array($records)) {
                                                echo "<option value='" . $data['emp_id'] . "'>" . $data['emp_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Prepared By</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control form-control-sm" name="joDate" id="po_date" value="<?php echo $joDate ?>">
                                        <label for="floatingInput">Job-Order Date</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select form-select-sm" id="floatingSelect" aria-label="Floating label select example" name="jo_type_id">
                                            <option value="<?php echo $jo_type_id ?>"><?php echo $jo_type_name; ?></option>
                                            <?php
                                            include "php/config.php";
                                            $records = mysqli_query($db, "SELECT * FROM jo_type ORDER BY jo_type_id ASC");

                                            while ($data = mysqli_fetch_array($records)) {
                                                echo "<option value='" . $data['jo_type_id'] . "'>" . $data['jo_type_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Job-Order Type</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select form-select-sm shadow-sm" id="floatingSelect" aria-label="Floating label select example" name="customerId" style="height:73px">
                                            <option value="<?php echo $customerId ?>"><?php echo $customerName; ?></option>
                                            <?php
                                            include "php/config.php";
                                            $records = mysqli_query($db, "SELECT * FROM customers ORDER BY customers_company ASC");

                                            while ($data = mysqli_fetch_array($records)) {
                                                echo "<option value='" . $data['customers_id'] . "'>" . $data['customers_company'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Customer</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <textarea class="form-control form-control-sm shadow-sm" name="jo_remarks" id="floatingTextarea2" style="height: auto"><?php echo $remarks ?></textarea>
                                        <label for="floatingTextarea2">Job-Order Remarks</label>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="button__container--insert_item">
                                <div class="container--table">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <button class="edit__button edit__button--insert__item btn btn-secondary bg-gradient" style="float: left; letter-spacing:1px"><i class="bi bi-list"></i> ITEMLIST</button>
                                        </div>
                                        <div class="col">
                                            <button class="edit__button button--update btn btn-secondary bg-gradient" name='update' style="float: right;">Update Record</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive shadow" style="height: 32vh;background-color:white">
                                        <table class="table table-sm table-hover">
                                            <thead class="bg-light text-secondary">
                                                <tr style="text-align: left;">
                                                    <th style="color:grey">&nbsp;Product ID</th>
                                                    <th style="color:grey">Item Name</th>
                                                    <th style="color:grey">Qty</th>
                                                    <th style="color:grey">Unit</th>
                                                    <th style="color:grey">Price</th>
                                                    <th style="color:grey">Total Price</th>
                                                    <th> </th>
                                                </tr>
                                            </thead>
                                            <tbody class='table--item'>
                                                <?php
                                                $limit = 0;
                                                if (isset($productId)) {
                                                    while (count($productId) !== $limit) {
                                                        if ($productId[$limit] != 0) {
                                                            # code...
                                                            echo
                                                            "<tr style='text-align:left;'>
                                            <td class='td__readonly td__readonly--productid'>" . str_pad($productId[$limit], 8, 0, STR_PAD_LEFT) . "</td>
                                            <td class='td__readonly td__readonly--itemname'>$productName[$limit]</td>
                                            <td class='td__edit td__edit--qty'>" . number_format($qtyIn[$limit], 2)  . "</td>
                                            <td class='td__readonly td__readonly--unit'>$unitName[$limit]</td>
                                            <td class='td__edit td__edit--cost'>" . number_format($itemPrice[$limit], 2) . "</td>
                                            <td class='td__compute td__compute--totalcost'>" . number_format($itemPrice[$limit] * $qtyIn[$limit], 2) . "</td>
                                            <td class='td__edit td__edit--delete'>
                                            <i class='bi bi-x-circle' title='Delete'></i>
                                        </td>
                                            <input type='hidden' name='productId[]' value='$productId[$limit]' >
                                            <input type='hidden' name='qtyIn[]' value='$qtyIn[$limit]' class='input__edit input__edit--qty'>
                                            <input type='hidden' name='itemPrice[]' value='$itemPrice[$limit]' class='input__edit input__edit--cost'>
                                            </tr>
                                             ";
                                                        }
                                                        $limit++;
                                                    }
                                                }

                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="container--edit__button mb-2" style="margin-top: -3px"><br>


                                </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- end of content -->


            <div class="container--modal">
                <div class='modal--add__item'>
                    <span style=" float: left;">
                        <h5 style="letter-spacing: 3px;">ITEMLIST</h5>
                    </span>
                    <span class='close--modal' style=" float: right; color:grey">x</span>
                    <br><br>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><b><i class="bi bi-search"></i></b></span>
                        <input type="text" class="input--search form-control" aria-label="search" aria-describedby="basic-addon1">
                    </div>
                    <div class='table--container table-responsive'>

                        <table class="modal--table__itemlist table table-sm">
                            <thead class="modal--table--thead">
                                <tr>
                                    <th>Product ID</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Location</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody class='container--itemlist'>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>






            </body>
            <?php include "footer.php"; ?>

            </html>