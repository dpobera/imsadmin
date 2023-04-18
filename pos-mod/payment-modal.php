<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel"><i class="bi bi-arrow-right-circle"> </i>Select Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Cash Payment</button>
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal">Online Payment</button>
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle4" data-bs-toggle="modal">Cheque Payment</button>
                </center>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Cash Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="row mb-3 mt-4">
                            <div class="col">
                                <label for="">Amount Due: </label>
                            </div>
                            <div class="col">
                                <label for=""><?php echo number_format($grandTot, 2) ?></label>
                            </div>
                        </div>
                        <div class="row mb-3" style="color: red;">
                            <div class="col">
                                <label for="">Balance: </label>
                            </div>
                            <div class="col">
                                <label for=""><?php echo number_format($grandTot, 2) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="payment-details">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control payment-balance" id="floatingInput" value="0.00">
                                <label for="floatingInput">Amount</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control payment-tendered" id="floatingInput" value="0.00">
                                <label for="floatingInput">Tendered Amount</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control payment-change" id="floatingInput" value="0.00">
                                <label for="floatingInput">Change</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-success"><i class="bi bi-check2-circle"></i> Tender Transaction</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalToggle3" aria-hidden="true" aria-labelledby="exampleModalToggleLabel3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel3">Online Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 mt-4">
                    <div class="col">

                    </div>
                    <div class="col">

                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="empId">
                        <option>.....</option>
                        <?php

                        $records = mysqli_query($db, "SELECT * FROM online_platform");

                        while ($data = mysqli_fetch_array($records)) {
                            echo "<option value='" . $data['online_platform_id'] . "'>" . $data['online_platform_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <label for="floatingSelect">Online Platform</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="floatingInput">
                    <label for="floatingInput">Transaction Date</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput">
                    <label for="floatingInput">Reference No.</label>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-success"><i class="bi bi-check2-circle"></i> Tender Transaction</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalToggle4" aria-hidden="true" aria-labelledby="exampleModalToggleLabel4" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel4">Cheque Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="empId">
                        <option>.....</option>
                        <option value="1">BPI</option>
                        <option value="2">BDO</option>
                        <option value="3">MBTC</option>
                        <option value="4">CBC</option>
                    </select>
                    <label for="floatingSelect">Bank</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="floatingInput">
                    <label for="floatingInput">Transaction Date</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput">
                    <label for="floatingInput">Reference No.</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success"><i class="bi bi-check2-circle"></i> Tender Transaction</button>
            </div>
        </div>
    </div>
</div>