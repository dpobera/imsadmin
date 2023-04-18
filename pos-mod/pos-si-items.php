<?php include 'header-pos.php';
if (!isset($_SESSION['user'])) {
    header("location: login-page.php");
}
include('../php/config.php');
include './php/Delivery.php';
if (isset($_GET['next'])) {

    $dr_number = $_GET['dr_number'];

    $dr = new Delivery();

    $customer = $dr->getCustomerDetails(implode(",", $dr_number));
}
?>


<div style="padding:2%;margin-top:-1.4cm;">
    <!-- <h2>IMS CASHIERING</h2> -->
    <br>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <!-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" style="color: grey;cursor:not-allowed">Job-Order</a>
        </li> -->
        <li class="nav-item">
            <a class=" nav-link" href="./index.php">Cashiering/Payments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="pos-dr.php">Delivery Reciepts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="pos-si.php">Sales Invoice</a>
        </li>


    </ul>

    <div class="row">
        <div class="col">
            <!-- Tab panes -->
            <div class="tab-content">
                <div id="menu1" class="tab-pane active" style="background-color: white;padding:1% ;border-left:1px solid #dee2e6;border-bottom:1px solid #dee2e6;border-right:1px solid #dee2e6;">
                    <br>
                    <div class="container">
                        <div class="row" style="margin-top: -30px;">
                            <div class="row">
                                <div class="col">
                                    <h4><i class="bi bi-people"></i> Customer Details</h4>
                                </div>
                                <div class="col">
                                    <!-- <button type="button" class="btn-search_customer btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal" style="float: right;"><i class="bi bi-search"></i> Search Customer</button>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Job-Order
                                    </button> -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input disabled type="text" class="form-control" id="customerName floatingInput" style="width: 30%;height:50px" value="<?php echo str_pad($customer['customers_id'], 8, 0, STR_PAD_LEFT)  ?>" disabled>
                                        <label for="floatingInput">Customer ID</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input disabled type="text" class="form-control" id="floatingInput" style="height:50px" value="<?php echo  $customer['customers_name'] ?>">
                                        <label for="floatingInput">Customer Name</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="floatingInput" style="height:50px" value="<?php echo $customer['customers_contact'] ?>" disabled>
                                        <label for="floatingInput">Contact Number</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="floatingInput" style="height:50px" value="<?php echo $customer['customers_address'] ?>" disabled>
                                        <label for="floatingInput">Customer Address</label>
                                    </div>
                                </div>
                            </div>

                            <form action="./php/invoice_save.php?<?php echo http_build_query(array('dr_number' => $dr_number)); ?>" method="post">
                                <div class="row order-list-container">
                                    <div class="col">
                                        <h4><i class="bi bi-cart4"></i> Order Details</h4>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-3">
                                        <?php

                                        $inputInvoice = "<input autocomplete='off' 
                                                        pattern='\d\d\d\d\d\d' 
                                                        title='Example: 123456' 
                                                        name='invoice_number' 
                                                        type='text' 
                                                        class='form-control' 
                                                        id='drNumber' 
                                                        placeholder='Enter Invoice Number' required>";

                                        if (isset($_GET['error'])) {
                                            if ($_GET['error'] == 'duplicate_invoice') {
                                                $inputInvoice = "<input autocomplete='off' 
                                               pattern='\d\d\d\d\d' 
                                               title='Example: 123456' 
                                               name='invoice_number' 
                                               type='text' 
                                               class='form-control border-danger' 
                                               id='drNumber' 
                                               value='" . $_GET['invoice_number'] . "'
                                               placeholder='Enter Invoice Number' required>";
                                            }
                                        }

                                        echo $inputInvoice;
                                        ?>
                                        <!-- <input autocomplete="off" pattern="\d\d\d\d\d\d" title="Example: 123456" name="invoice_number" type="text" class="form-control border-danger" id="drNumber" placeholder='Enter Invoice Number' required> -->
                                    </div>
                                    <div class="col">
                                        <!-- <span class="text-danger">
                                            Duplicate Invoice!
                                        </span> -->
                                        <?php
                                        if (isset($_GET['error'])) {
                                            if ($_GET['error'] == 'duplicate_invoice') {
                                                echo "
                                                <span class='text-danger'>
                                                    Invoice Number Already Used!
                                                </span>";
                                            }
                                        }

                                        ?>
                                    </div>
                                </div>
                        </div>
                        <div class="col-3">

                        </div>
                        <div>

                            <br>
                            <div class='order-list-table_container table-responsive'>

                                <div class="table__container">

                                    <table class="order-list table table-striped table-light" style="table-layout:fixed">
                                        <thead>
                                            <tr>
                                                <th style="width: 8%;">Item Code</th>
                                                <th style="width: 42%;">Item Decription</th>
                                                <th style="width: 12%;">Unit Price</th>
                                                <th style="width: 12%;">Qty</th>
                                                <th style="width: 13%;">Unit</th>
                                                <!-- <th>Discount</th> -->
                                                <th style="width: 13%;">Sub-Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $drItemsResult = $dr->getDrItems(implode(",", $dr_number));

                                            $grandTotal = 0;
                                            if ($drItemsResult->num_rows > 0) {
                                                while ($itemRows = $drItemsResult->fetch_assoc()) {
                                                    $grandTotal += $itemRows['totalRowAmount'];
                                            ?>
                                                    <tr>
                                                        <td><?php echo str_pad($itemRows['product_id'], 8, 0, STR_PAD_LEFT) ?>
                                                        </td>
                                                        <td><?php echo $itemRows['product_name'] ?></td>
                                                        <td class='label--price'>
                                                            <?php echo number_format($itemRows['jo_product_price'], 2) ?></td>
                                                        <td><?php echo number_format($itemRows['totalQty'], 2) ?></td>
                                                        <td><?php echo $itemRows['unit_name'] ?></td>
                                                        <td class='label--subtotal text-end'>
                                                            <?php echo number_format($itemRows['totalRowAmount'], 2) ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class=" container container--summary row">
                                        <div class="col-sm-6">

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row container text-end mb-3">
                                                <div class="col-sm-10">
                                                    <h6 class="fw-bold ">Total:₱</h6>
                                                </div>
                                                <div class="col-sm-2 text-end">
                                                    <h6 class="fw-bold "><span class="text-success lbl--table__total"><?php echo number_format($grandTotal, 2) ?></span>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-5 text-end">
                                    <button type='submit' name="save" class="btn btn-primary btn--submit__form"><i class="bi bi-check2-circle"></i> Save and Print</button>
                                    <a href="pos-si.php"><button type="button" class="btn btn-secondary">Go
                                            Back</button></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <br>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    if (isset($_GET['error'])) {
        $err = $_GET['error'];

        if ($err === 'zero-qty') {
    ?>
            <script>
                alert('Transaction Error:\n\nYou cannot proceed with ZERO total quantity!');
            </script>
        <?php

        }

        if ($err === 'duplicate-dr') {
        ?>
            <script>
                alert('Transaction Error:\n\nDR Number already used!\nPlease use NEW DR Number!');
            </script>
    <?php

        }
    }
    ?>
    </body>

    </html>