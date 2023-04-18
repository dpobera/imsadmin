<!-- Modal -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
</script>

<?php
$joid = $_GET['id'];
$tot = $grandTot ?>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    Select Payment Method
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color:white ;">
                <div class="row">
                    <div class="col-7">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#cash" type="button" role="tab" aria-controls="home" aria-selected="true">Cash</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#online" type="button" role="tab" aria-controls="profile" aria-selected="false">Online</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#cheque" type="button" role="tab" aria-controls="contact" aria-selected="false">Cheque</button>
                            </li>
                        </ul>


                        <div class="tab-content" id="myTabContent">
                            <!-- cash payment -->

                            <form method="GET" action="ac_reciept.php">
                                <input type="hidden" name="id" value="<?php echo $joid ?>">
                                <input type="hidden" name="tot" value="<?php echo $tot ?>">
                                <div class="tab-pane fade show active" id="cash" role="tabpanel" aria-labelledby="cash-tab">
                                    <!-- <form class="payment" method="get" action="payment.php"> -->
                                    <div class="form-floating mb-3 mt-3">
                                        <input type="text" class="form-control payment-balance" id="floatingInput" value="0.00" name="cashPay">
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

                                    <div class="">
                                        <button class="btn btn-success" style="width:100%">Save Payment</button></a>
                                    </div>
                            </form>
                        </div>


                        <!-- online payment -->
                        <div class="tab-pane fade" id="online" role="tabpanel" aria-labelledby="online-tab">
                            <!-- <form class="payment" method="get" action="payment.php"> -->
                            <div class="form-floating mb-3  mt-3">
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
                                <input type="text" class="form-control payment-balance" id="floatingInput" value="0.00">
                                <label for="floatingInput">Amount</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingInput">
                                <label for="floatingInput">Transaction Date</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput">
                                <label for="floatingInput">Reference No.</label>
                            </div>
                            <div class="">
                                <button class="btn btn-success" style="width:100%">Save Payment</button>
                            </div>
                            </form>
                        </div>

                        <!-- cheque payment -->
                        <div class="tab-pane fade" id="cheque" role="tabpanel" aria-labelledby="cheque-tab">
                            <!-- <form class="payment" method="get" action="payment.php"> -->
                            <div class="form-floating mb-3 mt-3">
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
                                <input type="text" class="form-control payment-balance" id="floatingInput" value="0.00">
                                <label for="floatingInput">Amount</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingInput">
                                <label for="floatingInput">Transaction Date</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput">
                                <label for="floatingInput">Reference No.</label>
                            </div>
                            <div class="">
                                <button class="btn btn-success" style="width:100%">Save Payment</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Billing statement -->
                <div class="col-5" style="border:1px dashed lightgrey;">
                    <h5>Billing Statement</h5>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <p>Amount Due :</p>
                        </div>
                        <div class="col">
                            <p><?php echo number_format($grandTot, 2) ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <p>Balance :</p>
                        </div>
                        <div class="col">
                            <p><?php echo number_format($grandTot, 2) ?></p>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <br>

        </div>
        <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div> -->
    </div>
</div>
</div>