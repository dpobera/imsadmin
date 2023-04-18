<?php include 'header.php';
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include 'php/ep_edit-inc.php';
?>
<link rel="stylesheet" href="css/jo_edit-style2.css">
<script defer src="js/ep_edit-script.js"></script>

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


<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
                <h1 class="h2 text-secondary font-monospace">EXITPASS / Editing Records</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">

                        <div class="btnAdd">

                        </div>
                    </div>
                </div>
            </div>
            <form action="php/ep_edit-inc.php" method="POST">
                <!-- content -->
                <div class="container-fluid shadow-sm p-4 bg-light" style="background-color:#ededed;border:1px solid lightgrey">
                    <?php include "sidebar.php"; ?>

                    <div class="form-floating mb-3">
                        <input type="text" id="id" class="form-control form-control-sm" name="epId" value="<?php echo str_pad($epId, 8, 0, STR_PAD_LEFT) ?>" readonly>
                        <label for="floatingInput">Exitpass ID</label>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="epNo" value="<?php echo $epNo ?>">
                                <label for="floatingInput">Exitpass No.</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="epTitle" value="<?php echo $epTitle ?>">
                                <label for="floatingInput">Job-Order No.</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" name="epDate" value="<?php echo $epDate ?>">
                                <label for="floatingInput">Exitpass Date</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="customerId">
                                    <option value="<?php echo $customerId ?>"><?php echo $customerName; ?></option>
                                    <?php
                                    include "config.php";
                                    $records = mysqli_query($db, "SELECT * FROM customers ORDER BY customers_name ASC");

                                    while ($data = mysqli_fetch_array($records)) {
                                        echo "<option value='" . $data['customers_id'] . "'>" . $data['customers_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Customer</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control" id="floatingTextarea" name="epRemarks"><?php echo $epRemarks; ?></textarea>
                                <label for="floatingTextarea">Exitpass Remarks</label>
                            </div>
                        </div>
                    </div>



                    <div class="button__container--insert_item mt-3">
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
                        <div class="table-responsive shadow-sm" style="height: 32vh;background-color:white;border:1px solid lightgrey">
                            <table class="table table-sm table-hover">
                                <thead class="bg-light text-secondary">
                                    <tr style="text-align: left;">
                                        <th>&nbsp;&nbsp;PRODUCT ID</th>
                                        <th>&nbsp;&nbsp;ITEM NAME</th>
                                        <th>&nbsp;&nbsp;QTY</th>
                                        <th>&nbsp;&nbsp;UNIT</th>
                                        <th>&nbsp;&nbsp;PRICE</th>
                                        <th>&nbsp;&nbsp;TOTAL PRICE</th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class='table--item'>
                                    <?php

                                    $limit = 0;
                                    $total = $itemPrice[$limit] * $qtyIn[$limit];

                                    if (isset($productId)) {
                                        while (count($productId) !== $limit) {
                                            if ($productId[$limit] != 0) {
                                                $total = $itemPrice[$limit] * $qtyIn[$limit];
                                                # code...
                                                echo
                                                "<tr style='text-align:left;'>
                                                    <td class='td__readonly td__readonly--productid'>" . str_pad($productId[$limit], 8, 0, STR_PAD_LEFT) . "</td>
                                                    <td class='td__readonly td__readonly--itemname'>$productName[$limit]</td>
                                                    <td class='td__edit td__edit--qty'>" . $qtyIn[$limit] . "</td>
                                                    <td class='td__readonly td__readonly--unit'>$unitName[$limit]</td>
                                                    <td class='td__edit td__edit--cost'>" . number_format($itemPrice[$limit], 2) . "</td>
                                                    <td class='td__compute td__compute--totalcost'>" . number_format($total, 2) . "</td>
                                                    <td class='td__edit td__edit--delete'>
                                                    <i class='bi bi-x-circle' title='Delete'></i>
                                                    </td>
                                                    <input type='hidden' name='productId[]' value='$productId[$limit]' >
                                                    <input type='hidden' name='qtyIn[]' value='$qtyIn[$limit]' class='input__edit input__edit--qty'>
                                                    <input type='hidden' name='itemPrice[]' value='$itemPrice[$limit]' class='input__edit input__edit--cost'>
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
                        <th>PRODUCT ID</th>
                        <th>Item Name</th>
                        <th>QUANTITY</th>
                        <th>UNIT</th>
                        <th>LOCATION</th>
                        <th>PRICE</th>
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