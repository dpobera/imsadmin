<?php include 'header-pos.php';
if (!isset($_SESSION['user'])) {
    header("location: login-page.php");
}
include './php/PointOfSales.php';

$pos = new PointOfSales();

if (!isset($_GET['page'])) {
    $page_number = 1;
} else {
    $page_number = $_GET['page'];
}

// Set row limit
$limit = 10;

// Get initial page number
$initial_page = ($page_number - 1) * $limit;

if (isset($_GET['qry'])) {
    $qry = $_GET['qry'];
} else {
    $qry = "";
}

// Calculate total number of pages
$result = $pos->getPendingJoPayments("", $qry);
$total_rows = $result->num_rows;
$total_pages = ceil($total_rows / $limit);


?>
<style>
    * {
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }
</style>


<div style="padding:2%;margin-top:-1.4cm;">
    <!-- <h2>IMS CASHIERING</h2> -->
    <br>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <!-- <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#home">Job-Order</a>
        </li> -->
        <li class="nav-item" style="cursor: not-allowed;">
            <a class="nav-link active" data-bs-toggle="tab" href="#home">Cashiering/Payments</a>
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
                <div id="home" class="tab-pane active" style="background-color: white;padding:1% ;border-left:1px solid #dee2e6;border-bottom:1px solid #dee2e6;border-right:1px solid #dee2e6;">

                    <div class="container w-50 ">
                        <form action="" class="mt-3 mb-5" method="get">
                            <input class="form-control" name="qry" placeholder="Type to search..." autocomplete="off" value="<?php echo $qry ?>" autofocus>
                        </form>
                    </div>
                    <div class="container">
                        <nav class="">
                            <ul class="pagination">

                                <li class="page-item <?php if ($page_number == 1) {
                                                            echo "disabled";
                                                        } ?>">

                                    <a class="page-link" href="./index.php?page=<?php echo $page_number - 1; ?>">Previous</a>
                                </li>

                                <?php




                                $page_limit = 1;
                                $break_point = $total_pages <= 4 ? 3 : 5;
                                $showed_pages = 1;


                                if ($page_number > 3) {
                                    $showed_pages = $page_number - 2;
                                    //Stop adjustmetn of pages;
                                    if ($showed_pages > $total_pages - 6)  $showed_pages = $total_pages - $total_pages <= 4 ? 1 : 5;
                                }
                                ?>

                                <li class="page-item <?php $pos->checkActivePage($page_limit, $page_number) ?>">
                                    <a class="page-link " href="./index.php?page=<?php echo $page_limit ?>"><?php echo $page_limit ?></a>
                                </li>
                                <li class="page-item disabled">
                                    <a class="page-link"><i class="bi bi-three-dots"></i></a>
                                </li>
                                <?php

                                while ($page_limit != $total_pages) {
                                    if ($page_limit == $break_point) {
                                        break;
                                    };

                                ?>
                                    <li class="page-item <?php $pos->checkActivePage($page_limit + $showed_pages, $page_number) ?>">
                                        <a class="page-link " href="./index.php?page=<?php echo $page_limit + $showed_pages ?>"><?php echo $page_limit + $showed_pages ?></a>
                                    </li>
                                <?php

                                    $page_limit++;
                                } ?>


                                <li class="page-item disabled">
                                    <a class="page-link"><i class="bi bi-three-dots"></i></a>
                                </li>

                                <li class="page-item <?php $pos->checkActivePage($total_pages, $page_number) ?>">
                                    <a class="page-link " href="./index.php?page=<?php echo $total_pages ?>"><?php echo $total_pages ?></a>
                                </li>


                                <li class="page-item <?php if ($page_number == $total_pages) {
                                                            echo "disabled";
                                                        } ?>">
                                    <a class="page-link" href="./index.php?page=<?php echo $page_number + 1 ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="container">
                        <table class="table table-sm align-middle">
                            <tr class="text-center">
                                <th>JO ID</th>
                                <th>JO No.</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Balance</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            <tbody>
                                <?php
                                $pendingResult = $pos->getPendingJoPayments("LIMIT $initial_page, $limit", $qry);

                                if ($pendingResult->num_rows > 0) {
                                    while ($row = $pendingResult->fetch_assoc()) {

                                        $jo_amount = $pos->getJoTotal($row['jo_id']);
                                ?>

                                        <tr class="text-center">
                                            <td><?php echo str_pad($row['jo_id'], 6, 0, STR_PAD_LEFT) ?></td>
                                            <td><?php echo $row['jo_no'] ?></td>
                                            <td class="text-start fw-bold"><?php echo $row['customers_name'] ?></td>
                                            <td class="text-end"><?php echo number_format($jo_amount, 2); ?></td>
                                            <td class="text-end text-danger"><?php echo number_format($row['jo_balance'], 2); ?></td>
                                            <td><?php echo $row['jo_date'] ?></td>
                                            <td><a href="pos-cashier.php?editJo&id=<?php echo $row['jo_id'] ?>" class="btn btn-success"><i class="bi bi-wallet2 "></i> Pay Now</a></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>