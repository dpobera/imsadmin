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
                        <form action="pos-si-items.php" method="get">
                            <table class="jo__modal--table table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;"></th>
                                        <th style="width: 10%;" class="text-center">DR No.</th>
                                        <th style="width: 60%;" class="text-center">Customer Name</th>
                                        <th style="width: 10%;" class="text-center">Amount</th>
                                        <th style="width: 20%;" class="text-center">Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    if (isset($_GET['qry']) && $_GET['qry'] !== '') {
                                        $query = $_GET['qry'];
                                    } else {
                                        $query = " ";
                                    }

                                    $dr = new Delivery();
                                    $drResult = $dr->getPendingDr($query);

                                    if ($drResult->num_rows > 0) {
                                        while ($drRow = $drResult->fetch_assoc()) {

                                            $drAmount = $dr->getDrAmount($drRow['dr_number']);
                                            $drCustomer =  $dr->getCustomerDetails($drRow['dr_number']);
                                            if ($query != $drCustomer['customers_id']) continue;

                                    ?>
                                            <tr>
                                                <td class="text-end"><input id="tableCheckbox<?php echo $drRow['dr_number'] ?>" class="jo__checkbox form-check-input fs-5" type="checkbox" name="dr_number[]" value="<?php echo $drRow['dr_number'] ?>" /></td>
                                                <td class="text-center"><label for="tableCheckbox<?php echo $drRow['dr_number'] ?>" class="form-check-label"><?php echo $drRow['dr_number'] ?></label> </td>
                                                <td><?php echo $drCustomer['customers_name'] ?></td>
                                                <td class="text-end"><?php echo number_format($drAmount['dr_amount'], 2) ?></td>
                                                <td class="text-center"><?php echo $drRow['dr_date'] ?></td>
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