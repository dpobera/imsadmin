<?php

include_once 'header.php';
include 'php/ol_edit-inc.php';
?>
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



<link rel="stylesheet" href="css/po_edit-style.css">
<script defer src="js/ol_edit-script.js"></script>


<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">

                <h1 class="h2 text-secondary font-monospace">
                    <?php $str = $olTypeName;
                    echo  strtoupper($str); ?> / Editing Records
                </h1>

                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">

                        <div class="btnAdd">

                        </div>
                    </div>
                </div>
            </div>

            <form action="php/ol_edit-inc.php" method="POST">
                <div class="container-fluid shadow-sm p-4 bg-light" style="background-color:#ededed;border:1px solid lightgrey">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="id" name="olId" value="<?php echo str_pad($olId, 8, 0, STR_PAD_LEFT) ?>" style="width:auto" readonly>
                        <label for="floatingInput"> Online Trans ID</label>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" name="oltypeId">
                                    <option value="<?php echo $oltypeId ?>"><?php echo $olTypeName; ?></option>
                                    <?php
                                    include "config.php";
                                    $records = mysqli_query($db, "SELECT * FROM ol_type ORDER BY ol_type_name ASC");

                                    while ($data = mysqli_fetch_array($records)) {
                                        echo "<option value='" . $data['ol_type_id'] . "'>" . $data['ol_type_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Online Platform</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="olTitle" class="form-control" id="floatingInput" value="<?php echo $olTitle ?>">
                                <label for="floatingInput">Statement </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="olSi" class="form-control" id="floatingInput" value="<?php echo $olSi ?>">
                                <label for="floatingInput">SI No. </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="floatingInput" name="olAdjustment" value="<?php echo $olAdjustment ?>">
                                <label for="floatingInput">Adjustment Amount</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" name="olDate" class="form-control" id="floatingInput" value="<?php echo $olDate ?>">
                                <label for="floatingInput">Online Transaction Date </label>
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col"> <button class="edit__button edit__button--insert__item btn btn-secondary bg-gradient" style="float: left; margin-bottom:10px;letter-spacing:1px"><i class="bi bi-list"></i> ITEMLIST</button>
                        </div>
                        <div class="col">
                            <div class="container--edit__button mb-2" style="float: right;margin-top:-20px;letter-spacing:1px';margin-right:10px;width:50vh"><br>
                                <button class="po__button button--po__update btn btn-secondary bg-gradient" name='update'>Update Records</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive shadow" style="height: 32vh;background-color:white;border:1px solid lightgrey">
                        <table class='table table table-sm table-hover p-2'>
                            <thead class="bg-light bg-gradient text-secondary">
                                <tr style="text-align: left;">
                                    <th style="width: 10%;">&nbsp;&nbsp;Product ID</th>
                                    <th style="width: 40%;">&nbsp;&nbsp;Item Name</th>
                                    <th style="width: 10%;text-align:right">&nbsp;&nbsp;Qty</th>
                                    <th style="width: 10%;">&nbsp;&nbsp;Unit</th>
                                    <th style="width: 10%;">&nbsp;&nbsp;SRP</th>
                                    <th style="width: 10%;">&nbsp;&nbsp;Less Fee</th>
                                    <th style="width: 10%;">&nbsp;&nbsp;Total Price</th>
                                    <th style="width: 10%;">
                                    </th>

                                </tr>
                            </thead>
                            <tbody class='table--item'>
                                <?php

                                $limit = 0;
                                $total = $itemPrice[$limit] * $qtyIn[$limit] - $itemFee[$limit];

                                if (isset($productId)) {
                                    while (count($productId) !== $limit) {
                                        if ($productId[$limit] != 0) {
                                            $total = $itemPrice[$limit] * $qtyIn[$limit] - $itemFee[$limit];
                                            # code...
                                            echo
                                            "<tr style='text-align:left;'>
                                                <td class='td__readonly td__readonly--productid'>" . str_pad($productId[$limit], 8, 0, STR_PAD_LEFT) . "</td>
                                                <td class='td__readonly td__readonly--itemname'>$productName[$limit]</td>
                                                <td class='td__edit td__edit--qty' style='text-align:right'>" . number_format($qtyIn[$limit], 2)  . "</td>
                                                <td class='td__readonly td__readonly--unit'>&nbsp;$unitName[$limit]</td>
                                                <td class='td__edit td__edit--cost'>" . number_format($itemPrice[$limit], 2)  . "</td>
                                                <td class='td__edit td__edit--fee'>" . number_format($itemFee[$limit], 2)  . "</td>
                                                <td class='td__compute td__compute--totalcost'>" . number_format($total, 2)  . "</td>
                                                <td class='td__edit td__edit--delete'>
                                                <i class='bi bi-x-circle' title='Delete'></i>
                                                </td>
                                                <input type='hidden' name='productId[]' value='$productId[$limit]' >
                                                <input type='hidden' name='qtyIn[]' value='$qtyIn[$limit]' class='input__edit input__edit--qty'>
                                                <input type='hidden' name='itemPrice[]' value='$itemPrice[$limit]' class='input__edit input__edit--cost'>
                                                <input type='hidden' name='itemFee[]' value='$itemFee[$limit]' class='input__edit input__edit--fee'>
                                                <input type='hidden' name='itemTotal[]' value='$total' class='input__edit input__edit--total'>
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
        </main>

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