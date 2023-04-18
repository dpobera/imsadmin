<?php include 'header-pos.php';
if (!isset($_SESSION['user'])) {
    header("location: login-page.php");
}
include('../php/config.php');
if (isset($_GET['editJo'])) {

    $joId = $_GET['id'];
    $joId = $_GET['id'];

    require 'php/config.php';

    $result = mysqli_query(
        $db,
        "SELECT jo_tb.jo_id, jo_tb.jo_no, jo_tb.jo_date, customers.customers_name,customers.customers_contact,customers.customers_address,customers.customers_id, jo_product.product_id, jo_product.jo_product_qty, jo_product.jo_product_price, product.product_name, unit_tb.unit_name, unit_tb.unit_id, employee_tb.emp_name, employee_tb.emp_id, jo_tb.jo_type_id, jo_type.jo_type_name, jo_type.jo_type_id,customers_company,jo_tb.jo_remarks
        FROM jo_tb
        LEFT JOIN jo_product ON jo_product.jo_id = jo_tb.jo_id
        LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id
        LEFT JOIN product ON jo_product.product_id = product.product_id
        LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
        LEFT JOIN employee_tb ON employee_tb.emp_id = jo_tb.emp_id
        LEFT JOIN jo_type ON jo_type.jo_type_id = jo_tb.jo_type_id
        WHERE jo_tb.jo_id ='$joId'
        ORDER BY jo_product.jo_product_id ASC"
    );



    // PO Details
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $customerName = $row['customers_company'];
            $customerId = $row['customers_id'];
            $customerCon = $row['customers_contact'];
            $customerAdd = $row['customers_address'];
            $joNo = $row['jo_no'];
            $empName = $row['emp_name'];
            $empId = $row['emp_id'];
            $joDate = $row['jo_date'];
            $jo_type_id = $row['jo_type_id'];
            $jo_type_name = $row['jo_type_name'];
            $productId[] = str_pad($row['product_id'], 8, 0, STR_PAD_LEFT);
            $productName[] = $row['product_name'];
            $qtyIn[] = $row['jo_product_qty'];
            $unitId[] = $row['unit_id'];
            $unitName[] = $row['unit_name'];
            $itemPrice[] = $row['jo_product_price'];
            $total[] = $row["jo_product_qty"] * $row["jo_product_price"];
            $remarks = $row['jo_remarks'];
        }
    } else {
        echo "0 results";
    }
}
?>


<div style="padding:2%;margin-top:-1.4cm;">
    <!-- <h2>IMS CASHIERING</h2> -->
    <br>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <!-- <li class="nav-item" style="cursor: not-allowed;">
            <a class="nav-link disabled" data-bs-toggle="tab" href="#">Job-Order</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#menu1">Cashiering/Payments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pos-dr.php">Delivery Reciepts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pos-si.php">Sales Invoice</a>
        </li>


    </ul>
    <div class="row">
        <div class="col">
            <!-- Tab panes -->
            <div class="tab-content">
                <div id="menu1" class="tab-pane active" style="background-color: white;padding:1% ;border-left:1px solid #dee2e6;border-bottom:1px solid #dee2e6;border-right:1px solid #dee2e6;"><br>
                    <div class="row" style="margin-top: -30px;">
                        <div class="col-9">
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
                                        <input type="text" class="form-control" id="customerName floatingInput" style="width: 30%;height:50px" value="<?php echo str_pad($customerId, 8, 0, STR_PAD_LEFT)  ?>" disabled>
                                        <label for="floatingInput">Customer ID</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="floatingInput" style="height:50px" value="<?php echo $customerName ?>" disabled>
                                        <label for="floatingInput">Customer Name</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="floatingInput" style="height:50px" value="<?php echo $customerCon ?>" disabled>
                                        <label for="floatingInput">Contact Number</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="floatingInput" style="height:50px" value="<?php echo $customerAdd ?>" disabled>
                                        <label for="floatingInput">Customer Address</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row order-list-container">
                                <div class="col">
                                    <h4><i class="bi bi-cart4"></i> Order Details</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <span class="container-transaction_number">
                                        <label for="transactionNumber">Transaction Number:</label>
                                        <input type="text" id="transactionNumber" value="0000000001" disabled />
                                    </span>
                                </div>
                                <div class="col">
                                    <span class="container-transaction_date">
                                        <label for="transactionDate">Transaction Date:</label>
                                        <input type="text" id="transactionDate" class="date" disabled />
                                    </span>
                                </div>
                                <div class="col">
                                    <span class="container-jo__number">
                                        <label for="jonumber">JO Number:</label>
                                        <input type="text" id="jonumber" disabled value="<?php echo $joNo ?>" />
                                    </span>
                                </div>
                            </div>
                        </div>

                        <?php
                        $limit = 0;
                        $tax = $total[$limit] / 1.12 * 0.12;
                        $subTot = 0;
                        $disTot = 0;

                        $grandTot = $subTot - $disTot;
                        while ($limit != count($total)) {
                            $subTot += $total[$limit];
                            // $disTot += $totaldisamount[$limit];
                            $limit += 1;
                        }
                        $net = $subTot - $tax;
                        $grandTot = $subTot
                        ?>

                        <?php
                        $qtyTot = 0;
                        $limit = 0;
                        while ($limit != count($qtyIn)) {
                            $qtyTot += $qtyIn[$limit];
                            // $disTot += $totaldisamount[$limit];
                            $limit += 1;
                        }

                        ?>
                        <div class="col-3">
                            <fieldset class="fieldset-summary" style="background-color: white;border:none;">
                                <legend>Order Billing Statement</legend>
                                <div class="summary_label-container mb-2">
                                    <div class="row">
                                        <div class="col-8">
                                            <span class="summary-label">Sub-Total:</span>
                                        </div>
                                        <div class="col-4">
                                            <span class="subtotal-value">
                                                <input class="input__summary input__summary--subtotal " type="text" value="<?php echo number_format($subTot, 2)  ?>" style="background-color: transparent;border:none" disabled />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="summary_label-container mb-2">
                                    <div class="row">
                                        <div class="col-8"><span class="summary-label">Tax:</span></div>
                                        <div class="col-4"><span class="tax-value">
                                                <input class="input__summary input__summary--tax" type="text" value="<?php echo number_format($tax, 2) ?>" style="background-color: transparent;border:none" disabled />
                                            </span></div>
                                    </div>
                                </div>

                                <div class="summary_label-container mb-2">
                                    <div class="row">
                                        <div class="col-8"><span class="summary-label">Net-Sales:</span></div>
                                        <div class="col-4"><span class="netsales-value">
                                                <input class="input__summary input__summary--netsales" type="text" value="<?php echo number_format($net, 2) ?>" style="background-color: transparent;border:none" disabled />
                                            </span></div>
                                    </div>
                                </div>

                                <div class="summary_label-container mb-2">
                                    <div class="row">
                                        <div class="col-8"><span class="summary-label">Discount Amount:</span></div>
                                        <div class="col-4"><span class="disc_amount-value">
                                                <input class="input__summary input__summary--discount" type="text" value="0.00" style="background-color: transparent;border:none" disabled />
                                            </span></div>
                                    </div>
                                </div>

                                <div class="summary_label-container mb-2">
                                    <div class="row">
                                        <div class="col-8"><span class="summary-label">Total Quantity:</span></div>
                                        <div class="col-4"><span class="total_qty-value">
                                                <input class="input__summary input__summary--qty" type="text" value="<?php echo number_format($qtyTot, 2)  ?>" style="background-color: transparent;border:none" disabled />
                                            </span></div>
                                    </div>
                                </div>

                                <div class="summary_label-container">
                                    <div class="row">
                                        <div class="col-8"> <span class="summary-label">Gross Amount:</span></div>
                                        <div class="col-4"> <span class="gross_amount-value">
                                                <input class="input__summary input__summary--gross" type="text" value="<?php echo  number_format($grandTot, 2) ?>" style="background-color: transparent;border:none" disabled />
                                            </span></div>
                                    </div>
                                </div>
                                <br>
                                <hr style="margin-top: 0cm;">
                                <div class="container-total_payable" style="margin-top: -10px;">
                                    <div class="row">
                                        <div class="col-8"> <span class="summary-label">
                                                <h4>Grand Total:</h4>
                                            </span></div>
                                        <div class="col-4"> <span class="label-total_payable">
                                                <h4><?php echo '₱ ' . number_format($grandTot, 2) ?></h4>
                                            </span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <a href="payment-page.php?id=<?php echo $joId ?>">
                                            <button type="button" class="btn btn-primary">
                                                <i class="bi bi-check2-circle"></i> Proceed to Payment</button>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="index.php"><button type="button" class="btn btn-secondary" style="width:100%">Go Back</button></a>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                    </div>




                    <div>

                        <br>
                        <div class='order-list-table_container table-responsive'>
                            <table class="order-list table">

                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Decription</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <!-- <th>Discount</th> -->
                                    <th>Sub-Total</th>
                                    <th>&nbsp;</th>
                                </tr>


                                <tr>
                                    <?php
                                    $limit = 0;

                                    if (isset($productId)) {
                                        while (count($productId) !== $limit) {
                                            if ($productId[$limit] != 0) {
                                                # code...
                                                echo
                                                "<tr>
                                                <td>" . str_pad($productId[$limit], 8, 0, STR_PAD_LEFT) . "</td>
                                                <td>$productName[$limit]</td>
                                                <td>" . number_format($itemPrice[$limit], 2) . "</td>
                                                <td>" . $qtyIn[$limit] . "</td>
                                                <td>$unitName[$limit]</td>
                                                
                                                <td>" . number_format($itemPrice[$limit] * $qtyIn[$limit], 2) . "</td>
                                                <td>
                                                <i class='bi bi-x-circle' style='font-size:22px' title='Delete'></i>
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


                                </tr>


                            </table>
                        </div>
                        <?php include('payment-modal2.php'); ?>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <script>
        //date
        document.querySelector('.date').value = new Date().toISOString();
    </script>