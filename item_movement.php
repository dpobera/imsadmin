<?php
include "header.php";
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include "php/config.php";
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];
    $result = mysqli_query($db, "SELECT * FROM product WHERE product_id=" . $_GET['id']);

    $row = mysqli_fetch_array($result);

    if ($row) {

        $id = $row['product_id'];
        $product_name = $row['product_name'];
        $class = $row['class_id'];
        $unit = $row['unit_id'];
        $pro_remarks = $row['pro_remarks'];
        $loc_id = $row['loc_id'];
        $barcode = $row['barcode'];
        $price = $row['price'];
        $cost = $row['cost'];
        $dept = $row['dept_id'];
    } else {
        echo "No results!";
    }
}

?>
<style>
    thead {
        position: sticky;
        top: 0;
    }

    tbody:hover {
        color: red;
        cursor: pointer;
    }
</style>
<div class="container-fluid">
    <?php include "sidebar.php"; ?>
    <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
        <!-- Itemlist Records header-->
        <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
            <h1 class="h2 text-secondary font-monospace">ITEM MOVEMENT EDIT</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="">
                    <button type="button" class="btn btn-sm btn-secondary" onclick="alert('DI PA AYOS GINAGAWA PA!')">Print Records</button>
                    <div class="btn-group me-2">
                    </div>
                </div>
            </div>

        </div>

        <!-- Itemlist Records header END-->

        <div class="container-fluid shadow-sm bg-light" style="background-color:#ededed;border:1px solid lightgrey;height:65vh;padding:1%">
            <caption>
                <div class="row">
                    <div class="col">
                        <label class="text-secondary">PRODUCT ID#</label><input type="text" class="form-control" value="<?php echo str_pad($id, 8, 0, STR_PAD_LEFT) ?>" disabled>
                    </div>
                    <div class="col">
                        <label class="text-secondary">PRODUCT NAME</label><input type="text" class="form-control" value="<?php echo $product_name ?>" disabled>
                    </div>
                </div>
            </caption><br>
            <div class="table-responsive shadow-sm" style="height:50vh;overflow-y:suto;overflow-x:auto;background-color:white">

                <table class="table table-sm table-bordered table-hover">
                    <thead class="table-light text-secondary ">
                        <tr>
                            <th>Movement ID</th>
                            <th>PROCESS</th>
                            <th>REFERENCE NO</th>
                            <th>IN</th>
                            <th>OUT</th>
                            <th>BALANCE</th>
                            <th style="text-align: center;">Process Date</th>
                            <th style="text-align: center;"></th>
                        </tr>
                    </thead>
                    <?php
                    include "php/config.php";
                    $sql = "SELECT move_product.move_id, move_type.mov_type_name, move_product.move_ref, po_tb.po_code, move_product.in_qty, move_product.out_qty, move_product.bal_qty, move_product.mov_date, move_product.mov_type_id, stout_tb.stout_code, stin_tb.stin_code, ep_tb.ep_no, ol_tb.ol_title, rt_tb.rt_no, pinv_tb.pinv_title, order_tb.order_id, order_tb.dr_number,ol_type.ol_type_name
                        FROM move_product 
                            INNER JOIN move_type ON move_product.mov_type_id = move_type.mov_type_id
                            INNER JOIN product ON product.product_id = move_product.product_id
                            LEFT JOIN po_tb ON move_product.move_ref = po_tb.po_id
                            LEFT JOIN stout_tb ON move_product.move_ref = stout_tb.stout_id
                            LEFT JOIN stin_tb ON move_product.move_ref = stin_tb.stin_id
                            LEFT JOIN ep_tb ON move_product.move_ref = ep_tb.ep_id
                            LEFT JOIN ol_tb ON move_product.move_ref = ol_tb.ol_id
                            LEFT JOIN pinv_tb ON move_product.move_ref = pinv_tb.pinv_id
                            LEFT JOIN rt_tb ON move_product.move_ref = rt_tb.rt_id
                            LEFT JOIN order_tb ON move_product.move_ref = order_tb.order_id
                            LEFT JOIN ol_type ON ol_type.ol_type_id = ol_tb.ol_type_id
                        WHERE move_product.product_id = '$id'
                        ORDER BY move_id ASC";

                    $result = $db->query($sql);
                    $count = 0;
                    if ($result->num_rows >  0) {

                        while ($irow = $result->fetch_assoc()) {
                            $count = $count + 1;
                            $dateString = $irow['mov_date'];
                            $dateTimeObj = date_create($dateString);
                            $date = date_format($dateTimeObj, 'm/d/y');
                            $movId = $irow['move_id'];
                    ?>
                            <tbody>
                                <tr>
                                    <td><?php echo str_pad($irow["move_id"], 8, 0, STR_PAD_LEFT) ?></td>
                                    <td><?php echo $irow['mov_type_name']; ?></td>
                                    <td><?php

                                        switch ($irow['mov_type_id']) {

                                            case '1':
                                                echo $irow['stin_code'];
                                                break;
                                            case '2':
                                                echo $irow['stout_code'];
                                                break;
                                            case '3':
                                                echo 'PO# ' . $irow['po_code'];
                                                break;
                                            case '4':
                                                echo 'DR# ' . $irow['move_ref'];
                                                break;
                                            case '5':
                                                echo 'Beginning';
                                                break;
                                            case '6':
                                                echo 'EP# ' . $irow['ep_no'];
                                                break;

                                            case '7':
                                                echo $irow['pinv_title'];
                                                break;

                                            case '8':
                                                echo $irow['ol_type_name'], ' - ' .
                                                    $irow['ol_title'];
                                                break;

                                            case '9':
                                                echo $irow['rt_no'];
                                                break;

                                            case '10':
                                                echo 'Order No.  ' . $irow['order_id'] . ' , DR#' . $irow['dr_number'];
                                                break;

                                            default:
                                                break;
                                        }

                                        ?>
                                    </td>
                                    <td><?php echo $irow['in_qty']; ?></td>
                                    <td><?php echo $irow['out_qty']; ?></td>
                                    <td><?php

                                        switch ($irow['mov_type_id']) {

                                            case '1':
                                                $totsi = $irow['bal_qty'] + $irow['in_qty'];
                                                echo $totsi;
                                                break;
                                            case '2':
                                                echo $irow['bal_qty'] - $irow['out_qty'];
                                                break;
                                            case '3':
                                                echo $irow['bal_qty'] + $irow['in_qty'];
                                                break;

                                            case '4':
                                                echo $irow['bal_qty'] - $irow['out_qty'];
                                                break;

                                            case '5':
                                                echo $irow['bal_qty'];
                                                break;

                                            case '6':
                                                echo $irow['bal_qty'] - $irow['out_qty'];
                                                break;

                                            case '7':
                                                echo $irow['bal_qty'];
                                                break;

                                            case '8':
                                                echo $irow['bal_qty'] - $irow['out_qty'];
                                                break;

                                            case '9':
                                                echo $irow['bal_qty'] + $irow['in_qty'];
                                                break;

                                            case '10':
                                                echo $irow['bal_qty'] + $irow['in_qty'];
                                                break;

                                            default:
                                                break;
                                        }

                                        ?>
                                    </td>
                                    <td style="font-weight: bolder; letter-spacing:2px;text-align: center;"><?php echo $date; ?></td>
                                    <td style="font-weight: bolder; letter-spacing:2px;text-align: center;"><a href="item_movement-edit.php?id=<?php echo $id ?>&movId=<?php echo $movId ?>"><button class="btn btn-secondary btn-sm bg-gradient"><i class="bi bi-pencil-square"></i> Edit</button></a></td>
                                </tr>
                            </tbody>
                    <?php }
                    } ?>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include "footer.php" ?>