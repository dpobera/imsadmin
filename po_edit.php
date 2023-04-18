<?php

include_once 'header.php';
include 'php/po_edit-inc.php';
?>

<link rel="stylesheet" href="css/po_edit-style.css">
<script defer src="js/po_edit-script.js"></script>
<style>
    thead {
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        z-index: 1;
        color: grey;
        text-transform: uppercase;

    }
</style>



<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
                <h1 class="h2 text-secondary font-monospace">PURCHASE ORDER / Editing Records</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">

                        <div class="btnAdd">

                        </div>
                    </div>
                </div>
            </div>


            <!-- CONTENT START HERE -->



            <form action="php/po_edit-inc.php" method="POST">
                <div class="container-fluid shadow-sm p-4 bg-light" style="background-color:#ededed;border:1px solid lightgrey">
                    <?php include "sidebar.php"; ?>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="text" id="po_id" class="form-control" name="poId" value="<?php echo str_pad($poId, 8, 0, STR_PAD_LEFT) ?>" readonly>
                                <label for="floatingInput">Purchase-Order ID</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="poCode" value="<?php echo $poCode ?>" readonly>
                                <label for="floatingInput">Purchase-Order Code</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="poTitle" value="<?php echo $poTitle ?>">
                                <label for="floatingInput">Purchase-Order Title</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="poTerms" value="<?php echo $poTerms ?>">
                                <label for="floatingInput">Purchase-Order Terms</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="refNum" value="<?php echo $refNum ?>">
                                <label for="floatingInput">Reference No.</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" name="poDate" value="<?php echo $poDate ?>">
                                <label for="floatingInput">Purchase-Order Date</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control" id="floatingTextarea" name="poRemarks"><?php echo $poRemarks ?></textarea>
                                <label for="floatingTextarea">Purchase-Order Remarks</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="supplierId">
                                    <option value="<?php echo $supId ?>"><?php echo $supName; ?></option>
                                    <?php
                                    include "config.php";
                                    $records = mysqli_query($db, "SELECT * FROM sup_tb ORDER BY sup_name ASC");

                                    while ($data = mysqli_fetch_array($records)) {
                                        echo "<option value='" . $data['sup_id'] . "'>" . $data['sup_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Supplier</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="po_type_id">
                                    <option value=" <?php echo $po_type_id ?>"><?php echo $po_type_name ?></option>
                                    <?php
                                    include "config.php";
                                    $records = mysqli_query($db, "SELECT * FROM po_type ORDER BY po_type_id ASC");

                                    while ($data = mysqli_fetch_array($records)) {
                                        echo "<option value='" . $data['po_type_id'] . "'>" . $data['po_type_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Purchase-Order Type</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="button__container--insert_item">
                        <!-- <button class="po__button button--insert__item">Add item</button> -->
                    </div>

                    <div class="container--po__table">

                        <div class="row">
                            <div class="col"> <button class="po__button button--insert__item btn btn-secondary bg-gradient" style="float: left; margin-bottom:10px;letter-spacing:1px"><i class="bi bi-list"></i> ITEMLIST</button>
                            </div>
                            <div class="col">
                                <div class="container--edit__button mb-2" style="float: right;margin-top:-20px;letter-spacing:1px';margin-right:10px;width:50vh"><br>
                                    <button class="po__button button--po__update btn btn-secondary bg-gradient" name='updatepo'>Update Records</button>
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive shadow-sm" style="height: 32vh;background-color:white;border:1px solid lightgrey">
                            <table class='po__table table table-sm table-hover p-2'>
                                <thead class="bg-light bg-gradient text-secondary">
                                    <tr style="text-align: left;">
                                        <th style='text-indent:10px'>Prod ID</th>
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Cost</th>
                                        <th>Tot Cost</th>
                                        <th>Disc %</th>
                                        <th>Disc Val</th>
                                        <th>Sub-total</th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class=' po__table--item'>

                                    <?php
                                    $limit = 0;

                                    if (isset($productId)) {
                                        while (count($productId) !== $limit) {
                                            if ($productId[$limit] != 0) {
                                                echo
                                                "<tr>
                                                        <td class='td__readonly td__readonly--productid' style='text-indent:10px'>$productId[$limit]</td>
                                                        <td class='td__readonly td__readonly--itemname'>$productName[$limit]</td>
                                                        <td class='td__edit td__edit--qty'>" . number_format($qtyIn[$limit], 2) . "</td>
                                                        <td >$unitName[$limit]</td>
                                                        <td class='td__edit td__edit--cost'>" . number_format($itemCost[$limit], 2) . "</td>
                                                        <td class='td__compute td__compute--totalcost'>" . number_format($itemCost[$limit] * $qtyIn[$limit], 2) . "</td>
                                                        <td class='td__edit td__edit--discpercent'>" . number_format($itemDiscpercent[$limit], 2) . "</td>
                                                        <td class='td__compute td__compute--discount'>" . number_format($itemDisamount[$limit], 2) . "</td>
                                                        <td class='td__compute td__compute--subtotal'>" . number_format($itemTotal[$limit], 2) . "</td>
                                                        <td class='td__edit td__edit--delete'>
                                                        <i class='bi bi-x-circle'></i>
                                                        </td>
                                                        <input type='hidden' name='productId[]' value='$productId[$limit]' >
                                                        <input type='hidden' name='qtyIn[]' value='$qtyIn[$limit]' class='input__edit input__edit--qty'>
                                                        <input type='hidden' name='itemCost[]' value='$itemCost[$limit]' class='input__edit input__edit--cost'>
                                                        <input type='hidden' name='itemDiscpercent[]' value='$itemDiscpercent[$limit]' class='input__edit input__edit--discpercent'>
                                                        <input type='hidden' name='itemDisamount[]' value='$itemDisamount[$limit]' class='input__edit input__edit--discount'>
                                                        <input type='hidden' name='itemTotal[]' value='" . $itemCost[$limit] * $qtyIn[$limit] . "' class='input__edit input__edit--total'>
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


            </form>





    </div>
</div>








<div class="container--modal">
    <div class='modal--add__item mb-3'>

        <span style=" float: left;">
            <h5 style="letter-spacing: 3px;">ITEMLIST</h5>
        </span>
        <span class='close--modal' style=" float: right; color:grey">x</span>
        <br><br>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b><i class="bi bi-search"></i></b></span>
            <input type="text" class="input--search form-control" aria-label="search" aria-describedby="basic-addon1">
        </div>
        <div class='table--container' style="background-color:#ededed;">
            <table class="table modal--table__itemlist">
                <thead class="bg-light bg-gradient text-secondary">
                    <tr>
                        <th>Prod ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Location</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody class='container--itemlist'>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once 'footer.php' ?>