<?php include 'header.php';
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include 'php/stin_edit-inc.php'
?>
<link rel="stylesheet" href="css/jo_edit-style2.css">

<style>
    thead {
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        z-index: 1;
        background-color: aliceblue;
        color: black;

    }
</style>
<script defer src="js/stin_edit-script.js"></script>

<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
                <h1 class="h2 text-secondary font-monospace">STOCK INVENTORY IN / Editing Records</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">

                        <div class="btnAdd">

                        </div>
                    </div>
                </div>
            </div>
            <form action="php/stin_edit-inc.php" method="POST">
                <!-- content -->
                <div class="container-fluid shadow-sm p-4 bg-light" style="background-color:#ededed;border:1px solid lightgrey">

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="stinId" id="id" value="<?php echo str_pad($stinId, 8, 0, STR_PAD_LEFT) ?>" style="width:auto;cursor:not-allowed" readonly>
                                <label for="floatingInput">Stock-In ID</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="stinCode" id="stin_code" value="<?php echo $stinCode ?>">
                                <label for="floatingInput"> Stock-In Code</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="stinTitle" id="stin_title" value="<?php echo $stinTitle ?>">
                                <label for="floatingInput"> Job-Order No.</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" name="stinDate" id="stin_date" value="<?php echo $stinDate ?>">
                                <label for="floatingInput">Stock-In Date</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="employeeId">
                                    <option value=" <?php echo $empId ?>"><?php echo $empName ?></option>
                                    <?php

                                    $records = mysqli_query($db, "SELECT * FROM employee_tb ORDER BY emp_name ASC");

                                    while ($data = mysqli_fetch_array($records)) {
                                        echo "<option value='" . $data['emp_id'] . "'>" . $data['emp_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Prepared by</label>

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control" name="stinRemarks" id="stin_remarks"><?php echo $stinRemarks ?></textarea>
                                <label for="floatingTextarea">STIN Remarks</label>
                            </div>
                        </div>
                    </div>

                    <div class="button__container--insert_item">
                        <div class="row">
                            <div class="col">
                                <button class="edit__button edit__button--insert__item btn btn-secondary bg-gradient" style="float: left; margin-bottom:10px;letter-spacing:1px"><i class="bi bi-list"></i> ITEMLIST</button>
                            </div>
                            <div class="container--edit__button mb-2" style="float: left;margin-top:-20px;letter-spacing:1px';margin-right:10px;width:50vh"><br>
                                <button class=" edit__button button--update btn btn-secondary bg-gradient" name='update'>Update Records</button>


                            </div>
                        </div>
                    </div>

                    <div class="container--table">
                        <div class="table-responsive shadow-sm" style="height: 32vh;background-color:white; border:1px solid lightgrey;">
                            <table class="table table-sm table-hover">
                                <thead class="bg-light text-secondary">
                                    <tr style="text-align: left;">
                                        <th>PRODUCT ID</th>

                                        <th>QTY</th>
                                        <th>UNIT</th>
                                        <th width="30%">PRODUCT REMARKS</th>
                                        <th>
                                        </th>
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
                                                "<tr>
                                                                        <td class='td__readonly td__readonly--productid'>" . str_pad($productId[$limit], 8, 0, STR_PAD_LEFT) . "</td>
                                                                        <td class='td__readonly td__readonly--itemname'>$productName[$limit]</td>
                                                                        <td class='td__edit td__edit--qty' style='text-align:left;'>" . $qtyIn[$limit] . "</td>
                                                                        
                                                                        <td class='td__readonly td__readonly--unit' style='text-align:left;'>$unitName[$limit]</td>
                                                                        <td>
                                                                        <textarea class='form-control form-control-sm td__edit--rem'' style='width:95%' id='exampleFormControlTextarea1' rows='1' id='itemRemarks' name='itemRemarks[]' placeholder='Enter your item remarks..'>$itemRemarks[$limit]</textarea>
                                                                        </td>
                                                                        
                                                                        <td class='td__edit td__edit--delete'>
                                                                        <i class='bi bi-x-circle' style='font-size:18px' title='Delete'></i>
                                                                        </td>
                                                                        <input type='hidden' name='productId[]' value='$productId[$limit]' >
                                                                        <input type='hidden' name='qtyIn[]' value='$qtyIn[$limit]' class='input__edit input__edit--qty'>
                                                                        <input type='hidden' name='itemCost[]' value='$itemCost[$limit]' class='input__edit input__edit--cost'>
                                                                       
                                                                        </td>
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


                </div>
            </form>
        </main>
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