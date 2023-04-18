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
            <h1 class="h2 text-secondary font-monospace">ITEM MOVEMENT / Change Records</h1>
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

                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "inventorymanagement";

                // Create connection
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT move_product.move_id, move_type.mov_type_name, move_product.move_ref, po_tb.po_code, move_product.in_qty, move_product.out_qty, move_product.bal_qty, move_product.mov_date, move_product.mov_type_id, stout_tb.stout_code, stin_tb.stin_code, ep_tb.ep_no, ol_tb.ol_title, rt_tb.rt_no, pinv_tb.pinv_title, order_tb.order_id, order_tb.dr_number,ol_type.ol_type_name,product.product_name
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
                    WHERE move_product.product_id = '$id' ";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        $moveId = $row['move_id'];
                        $product_name = $row['product_name'];
                        $balqty = $row['bal_qty'];
                        $inqty = $row['in_qty'];
                        $outqty = $row['out_qty'];
                        $movid = $row['mov_type_id'];
                        $movName = $row['mov_type_name'];
                        $moveref = $row['move_ref'];
                    }
                } else {
                    echo "0 results";
                }

                mysqli_close($conn);
                ?>

                <form class="row g-3 p-3" action="php/item_movement-edit-con.php" method="GET">
                    <input type="hidden" name="movId" value="<?php echo $moveId ?>">
                    <div class="col">
                        <label for="inputEmail4" class="form-label">MOVEMENT ID</label>
                        <input type="text" class="form-control" id="inputEmail4" value="<?php echo $moveId ?>" disabled>
                    </div>
                    <div class="col">
                        <label for="inputEmail4" class="form-label">PRODUCT ID</label>
                        <input type="text" class="form-control" id="inputEmail4" value="<?php echo $id ?>" name="prodId">
                    </div>
                    <div class="col">
                        <label for="inputEmail4" class="form-label">BAL QTY</label>
                        <input type="text" class="form-control" id="inputEmail4" value="<?php echo $balqty ?>" name="balQty">
                    </div>
                    <div class="col">
                        <label for="inputEmail4" class="form-label">IN QTY</label>
                        <input type="text" class="form-control" id="inputEmail4" value="<?php echo $inqty ?>" name="inQty">
                    </div>
                    <div class="col">
                        <label for="inputEmail4" class="form-label">OUT QTY</label>
                        <input type="text" class="form-control" id="inputEmail4" value="<?php echo $outqty ?>" name="outQty">
                    </div>
                    <div class="col">
                        <label for="inputEmail4" class="form-label">TYPE</label>
                        <input type="text" class="form-control" id="inputEmail4" value="<?php echo $movName ?>" disabled>
                    </div>
                    <div class="col">
                        <label for="inputEmail4" class="form-label">REFERENCE</label>
                        <input type="text" class="form-control" id="inputEmail4" value="<?php echo $moveref ?>" name="ref">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-secondary" name="update">CHANGE RECORD</button>
                    </div>
                </form>


            </div>
        </div>
    </main>
</div>

<?php include "footer.php" ?>