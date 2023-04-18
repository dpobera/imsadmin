<?php

include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT pinv_tb.pinv_id, pinv_tb.pinv_title, employee_tb.emp_name, pinv_tb.pinv_date, user.user_name, pinv_tb.closed
    FROM pinv_tb
    LEFT JOIN user ON user.user_id = pinv_tb.user_id
    INNER JOIN employee_tb 
    ON pinv_tb.emp_id = employee_tb.emp_id WHERE pinv_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['pinv_id'];
        $pinv_title = $row['pinv_title'];
        $emp_name = $row['emp_name'];
        $dateString = $row['pinv_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'm/d/y');
    } else {
        echo "No results!";
    }
}


?>
<?php include('../headerv2.php') ?>
<div style="padding: 2%;">
    <div class="shadow p-5 mt-5 bg-body rounded" style="width:100%;border:5px solid #cce0ff">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <h4 style="font-family:Verdana, Geneva, Tahoma, sans-serifl;letter-spacing:2px">Physical Inventory : Commiting Records <i class="bi bi-pencil"></i></h4>
        <hr>
        <div class="row">
            <div class="col-3">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" value="<?php echo str_pad($id, 8, 0, STR_PAD_LEFT) ?>" style="cursor:not-allowed" readonly>
                    <label for="floatingInput">PINV ID</label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="<?php echo $pinv_title ?>" style="cursor:not-allowed" readonly>
                        <label for="floatingInput">PINV Title</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="<?php echo $emp_name ?>" style="cursor:not-allowed" readonly>
                        <label for="floatingInput">Prepared By</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="<?php echo $date ?>" style="cursor:not-allowed" readonly>
                        <label for="floatingInput">PINV Date</label>
                    </div>
                </div>
            </div>

            <hr>
            <form method="POST" action="../commit/que/pinv_commit_que.php">
                <input type="hidden" name="pinv_id" value="<?php echo $_GET['id'] ?>">
                <input type="hidden" name='mov_date' class='date'>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th width="10%">Product ID.</th>
                            <th width="60%">Description</th>
                            <th width="10%">Location</th>
                            <th width="5%">On-Hand</th>
                            <th width="5%">Phy-Qty</th>
                        </tr>
                        <?php
                        $sql = "SELECT product.product_id, product.product_name, product.qty, unit_tb.unit_name, product.cost, pinv_product.pinv_qty, product.barcode, loc_tb.loc_name,loc_tb.loc_id
                    FROM product 
                    LEFT JOIN pinv_product ON product.product_id = pinv_product.product_id
                    LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id 
                    LEFT JOIN loc_tb ON loc_tb.loc_id = pinv_product.loc_id
                    WHERE pinv_product.pinv_id='$id' ";

                        $result = $db->query($sql);
                        $count = 0;
                        if ($result->num_rows >  0) {

                            while ($irow = $result->fetch_assoc()) {

                        ?>
                                <tr>
                                    <td><?php echo str_pad($irow["product_id"], 8, 0, STR_PAD_LEFT); ?></td>
                                    <td contenteditable="false"><?php echo $irow['product_name'] ?></td>
                                    <td contenteditable="false"><input type="text" name="loc_id[]" value="<?php echo $irow['loc_id'] ?>" style="border: none;background-color:transparent;"></td>
                                    <td><input type="text" name="bal_qty[]" value="<?php echo $irow['qty'] ?>" style="border: none;background-color:transparent;" readonly></td>
                                    <td contenteditable="false">
                                        <font color="red"><input type="number" name="out_qty[]" value="<?php echo $irow['pinv_qty'] ?>" style="border: none;background-color:transparent;" readonly></font>
                                    </td>
                                </tr>
                                <input type="hidden" name="product_id[]" value="<?php echo $irow['product_id'] ?>">
                        <?php }
                        } ?>
                    </table>
                </div>
                <br>
                <div class="pull-right">
                    <button type="submit" name="submit" class="btn btn-primary">Commit Records</button>
                    <a href="../pinv_main2.php"><button type="button" class="btn btn-danger">Cancel</button></a>
                </div>
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
    function PrintPage() {
        window.print();
    }

    function HideBorder(id) {
        var myInput = document.getElementById(id).style;
        myInput.borderStyle = "none";
    }
</script>
<script>
    //date
    document.querySelector('.date').value = new Date().toISOString();

    function confirmUpdate() {
        let confirmUpdate = confirm("Are you sure you want to Commit record?\n \nNote: Double Check Input Records");
        if (confirmUpdate) {
            alert("Update Record Database Successfully!");
        } else {

            alert("Action Canceled");
        }
    }
</script>

<script>
    function confirmCancel() {
        let confirmUpdate = confirm("Are you sure you want to cancel ?");
        if (confirmUpdate) {
            alert("Nothing Changes");
        } else {

            alert("Action Canceled");
        }
    }
</script>

</html>