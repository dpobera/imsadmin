<?php include 'header-pos.php';
if (!isset($_SESSION['user'])) {
    header("location: login-page.php");
}
include('../php/config.php');
include './php/Delivery.php';


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
            <a class="nav-link active" href="pos-dr.php">Delivery Reciepts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pos-si.php">Sales Invoice</a>
        </li>


    </ul>
    <div class="row">
        <div class="col">
            <!-- Tab panes -->
            <div class="tab-content">
                <div id="home" class="tab-pane active" style="background-color: white;padding:1% ;border-left:1px solid #dee2e6;border-bottom:1px solid #dee2e6;border-right:1px solid #dee2e6;">


                    <div style="padding: 2%;">

                        <div class="input-group flex-nowrap">
                            <form action="" method="get" class="row">
                                <span class="col-1 input-group-text pe-0" id="addon-wrapping"><i class="bi bi-search"></i>
                                </span>
                                <span class="form-group col ps-0">
                                    <select class="form-select" name="qry" id="" onchange="this.form.submit()">

                                        <?php if (isset($_GET['qry'])) {
                                            $customer_id = $_GET['qry'];
                                            $getCustName = new Delivery();
                                            $nameResult = $getCustName->select('*', 'customers', 'customers_id = ' . $customer_id);

                                            $nameRow = mysqli_fetch_assoc($nameResult);

                                            echo  "<option value='" . $nameRow['customers_id'] . "'>" .
                                                $nameRow['customers_name'] . "
                                            </option>";
                                        } else {
                                            echo  "<option value=''>Select Customer ...
                                            </option>";
                                        } ?>


                                        <?php
                                        $customer = new Delivery();
                                        $customerResult = $customer->select('*', 'customers ', 'customers_name != "" ORDER BY customers_name ASC');

                                        while ($customerRow = mysqli_fetch_assoc($customerResult)) {
                                            $customerName = $customerRow['customers_name'];

                                        ?>
                                            <option value="<?php echo $customerRow['customers_id'] ?>">
                                                <?php echo $customerRow['customers_name'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </span>
                            </form>
                        </div>
                        <br>
                        <form action="pos-dr-products.php" method="get">
                            <table class="jo__modal--table table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>JO No.</th>
                                        <th>Customer Name</th>
                                        <th class="text-center">Items Released</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $jo = new Delivery();

                                    $table = "
                                jo_tb
                                LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id
                                LEFT JOIN user ON user.user_id = jo_tb.user_id
                                LEFT JOIN employee_tb ON employee_tb.emp_id = jo_tb.emp_id
                                LEFT JOIN jo_type ON jo_type.jo_type_id = jo_tb.jo_type_id
                                LEFT JOIN jo_status ON jo_status.jo_status_id = jo_tb.jo_status_id";

                                    $column = "
                                        jo_tb.jo_id, 
                                        jo_tb.jo_no, 
                                        customers.customers_name, 
                                        customers.customers_id, 
                                        jo_tb.jo_date,   
                                        jo_tb.closed, 
                                        jo_tb.jo_type_id, 
                                        jo_type.jo_type_name, 
                                        jo_tb.jo_status_id, 
                                        customers_company";

                                    if (isset($_GET['qry']) && $_GET['qry'] !== '') {
                                        $query = $_GET['qry'];
                                    } else {
                                        $query = " ";
                                    }

                                    $filter = "customers.customers_id = '$query' ORDER BY jo_tb.jo_date DESC";

                                    $joResult = $jo->select(
                                        $column,
                                        $table,
                                        $filter
                                    );

                                    if (mysqli_num_rows($joResult) > 0) {
                                        while ($row = mysqli_fetch_assoc($joResult)) {
                                            $jo_id = $row['jo_id'];

                                            // // Get Item already Released
                                            // $joItems = new Delivery();
                                            // $joItemsColumn = "order_product.order_id,
                                            //             order_product.product_id, 
                                            //             order_product.pos_temp_qty, 
                                            //             jo_tb.jo_id";

                                            // $joItemsTable = "order_product
                                            //             LEFT JOIN order_tb ON order_tb.dr_number = order_product.dr_number
                                            //             LEFT JOIN jo_tb ON jo_tb.jo_id = order_tb.jo_id";

                                            // $joItemsFilter = "jo_tb.jo_id = '$jo_id'";

                                            // $joItemsResult = $joItems->select($joItemsColumn, $joItemsTable, $joItemsFilter);

                                            // $totalReleased = 0;
                                            // if (mysqli_num_rows($joItemsResult)) {
                                            //     while ($joItemsRow = mysqli_fetch_assoc($joItemsResult)) {
                                            //         $totalReleased += $joItemsRow['pos_temp_qty'];
                                            //     }
                                            // }

                                            $totalReleased = 0;
                                            $totalReleased = $jo->getJoTotalDelivered($jo_id);


                                            // Get JO Product total qty
                                            $joProduct = new Delivery();
                                            $joProductColumn = "jo_product.jo_id, jo_product.jo_product_qty";
                                            $joProductTable = "jo_product";
                                            $joProductFilter = "jo_product.jo_id = '$jo_id'";


                                            $joProductResult = $joProduct->select($joProductColumn, $joProductTable, $joProductFilter);
                                            $totalJoProduct = 0;
                                            if (mysqli_num_rows($joProductResult)) {
                                                while ($joProductRow = mysqli_fetch_assoc($joProductResult)) {
                                                    $totalJoProduct += $joProductRow['jo_product_qty'];
                                                }
                                            }

                                            // Exclude completed transactions
                                            if ($totalReleased / $totalJoProduct >= 1) continue;

                                    ?>
                                            <tr>
                                                <td><input class="jo__checkbox" type="checkbox" name="jo_id[]" value="<?php echo $jo_id ?>" /></td>
                                                <td><?php echo $row['jo_no'] ?></td>
                                                <td><?php echo $row['customers_name'] ?></td>
                                                <td class="text-center"><?php echo $totalReleased . "/" . $totalJoProduct ?></td>
                                                <td><?php echo $row['jo_date'] ?></td>
                                            </tr>

                                        <?php
                                        }
                                    } else {
                                        ?>


                                        <?php

                                        if (isset($_GET['qry'])) {
                                            echo ' <div class="alert alert-danger text-center fs-5">No record found!</div>';
                                        } else {
                                            echo ' <div class="alert alert-warning text-center fs-5">Choose Customer!</div>';
                                        }

                                        ?>

                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="text-end">
                                <button type="submit" name="next" class="btn__next btn btn-success text-end disabled">Next <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET['dr'])) {
        $dr = $_GET['dr'];

        if ($dr === 'saved') {
    ?>
            <script>
                alert('Transaction Success:\n\nDR Transaction Saved!');
            </script>
    <?php

        }
    }

    ?>


    <script>
        const joCheckbox = document.querySelectorAll('.jo__checkbox');
        const btnNext = document.querySelector('.btn__next');

        function checkBoxes(nodeList) {
            let checked = false;

            nodeList.forEach(element => {
                if (element.checked) checked = true;
            });

            return checked;
        }

        joCheckbox.forEach(el => {
            el.addEventListener('change', function() {
                btnNext.classList.remove('disabled');

                if (!checkBoxes(joCheckbox)) {
                    btnNext.classList.add('disabled');
                }
            })
        })
    </script>
    </body>

    </html>

    <!-- 
    SELECT order_product.product_id,
    order_product.order_product_id, 
    order_product.order_id, 
    order_product.pos_temp_qty
    order_tb.jo_id
    FROM order_product
    LEFT JOIN order_tb ON order_tb.order_id = order_product.order_id
    LEFT JOIN jo_tb ON jo_tb.jo_id = order_tb.jo_id
 -->