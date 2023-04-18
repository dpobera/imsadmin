<!DOCTYPE html>
<html lang="en">
<?php

include('../php/config.php');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $class = $_POST['class_id'];
    // $qty = $_POST['qty'];
    $unit = $_POST['unit_id'];
    $pro_remarks = $_POST['pro_remarks'];
    $loc_id = $_POST['loc_id'];
    $barcode = $_POST['barcode'];
    $price = $_POST['price'];
    $cost = $_POST['cost'];
    $dept = $_POST['dept_id'];
    $product_type_id = $_POST['product_type_id'];

    mysqli_query($db, "UPDATE product SET product_name='$product_name', class_id='$class',unit_id='$unit' ,pro_remarks='$pro_remarks',loc_id='$loc_id' ,barcode='$barcode' ,price='$price',cost='$cost' ,dept_id='$dept' ,product_type_id='$product_type_id' WHERE product_id='$id'");
    echo "<script type='text/javascript'>alert('Update Records Successfully!');
    location.href = '../itemlist_main.php'</script>";



    // header("Location:../itemlist_main.php");
}



if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT product.product_id, product.product_name, class_tb.class_name, product.qty, unit_tb.unit_name, product.pro_remarks, loc_tb.loc_name, product.barcode, product.price, product.cost, dept_tb.dept_name, product_type.product_type_name
FROM product
LEFT JOIN class_tb ON product.class_id = class_tb.class_id
LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
LEFT JOIN loc_tb ON product.loc_id = loc_tb.loc_id
LEFT JOIN product_type ON product.product_type_id = product_type.product_type_id
LEFT JOIN dept_tb ON product.dept_id = dept_tb.dept_id WHERE product_id=" . $_GET['id']);

    $row = mysqli_fetch_array($result);

    if ($row) {

        $id = $row['product_id'];
        $product_name = $row['product_name'];
        $class = $row['class_name'];
        $qty = $row['qty'];
        $unit = $row['unit_name'];
        $pro_remarks = $row['pro_remarks'];
        $loc_id = $row['loc_name'];
        $barcode = $row['barcode'];
        $price = $row['price'];
        $cost = $row['cost'];
        $dept = $row['dept_name'];
        $type = $row['product_type_name'];
    } else {
        echo "No results!";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itemlist: Editing Records</title>
</head>
<?php include('../main_header_v2.php'); ?>

<div class="container-sm mt-2">
    <a class="back-button" href="../itemlist_main.php">
        <p class="mt-3" style="float:right;padding:2%"><i class="bi bi-backspace"></i> Back to Itemlist</p>
    </a>
    <div class="shadow-lg p-5 mb-5 bg-rounded" style="background-color: white;border: 5px solid #cce0ff">
        <h3 style="color: #0d6efd;"><i class="bi bi-boxes"></i> Itemlist: Editing Records</h3>
        <hr>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="row">

                <div class="col-7">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Item Name" name="product_name" value="<?php echo $product_name; ?>">
                        <label for="floatingInput">Item Description</label>
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-floating mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="class_id">
                                <option class="select__option--class" value="<?php echo $_GET['class']; ?>"><?php echo $_GET['className']; ?></option>
                                <?php
                                include "config.php";
                                $records = mysqli_query($db, "SELECT * FROM class_tb ORDER BY class_name ASC");
                                while ($data = mysqli_fetch_array($records)) {
                                    echo "<option value='" . $data['class_id'] . "'>" . $data['class_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="floatingSelect">Class</label>
                        </div>
                    </div>
                </div>
                <!-- <div class="col">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" name="qty" value="<?php echo $_GET['qty']; ?>" onchange="setDecimal" min="0" max="9999999999" step="0.0000001">
                        <label for="floatingInput">Quantity</label>
                    </div>
                </div> -->

                <div class="col-2">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="unit_id">
                            <option value="<?php echo $_GET['unitId']; ?>"><?php echo $_GET['unit']; ?></option>
                            <?php
                            include "config.php";
                            $records = mysqli_query($db, "SELECT * FROM unit_tb");

                            while ($data = mysqli_fetch_array($records)) {
                                echo "<option value='" . $data['unit_id'] . "'>" . $data['unit_name'] . "</option>";
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Unit</label>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <div class="form-floating">
                        <textarea class="form-control" name="pro_remarks" id="floatingTextarea"><?php echo $pro_remarks; ?></textarea>
                        <label for="floatingTextarea">Remarks</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="loc_id">
                            <option value="<?php echo $_GET['locId'] ?>"><?php echo $_GET['loc']; ?></option>
                            <?php
                            include "config.php";
                            $records = mysqli_query($db, "SELECT * FROM loc_tb");

                            while ($data = mysqli_fetch_array($records)) {
                                echo "<option value='" . $data['loc_id'] . "'>" . $data['loc_name'] . "</option>";
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Location</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Barcode" name="barcode" value="<?php echo $barcode; ?>">
                        <label for="floatingInput">Barcode</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Price" name="price" value="<?php echo $price; ?>">
                        <label for="floatingInput">Price</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Cost" name="cost" value="<?php echo $cost; ?>">
                        <label for="floatingInput">Cost</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="dept_id">
                            <option value="<?php echo $_GET['deptId'] ?>"><?php echo $_GET['dept']; ?></option>
                            <?php
                            include "config.php";
                            $records = mysqli_query($db, "SELECT * FROM dept_tb");

                            while ($data = mysqli_fetch_array($records)) {
                                echo "<option value='" . $data['dept_id'] . "'>" . $data['dept_name'] . "</option>";
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Department</label>
                    </div>
                </div>

                <div class="col">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="product_type_id">
                            <option value="<?php echo $_GET['typeId'] ?>"><?php echo $_GET['typeName']; ?></option>
                            <?php
                            include "config.php";
                            $records = mysqli_query($db, "SELECT * FROM product_type ORDER BY product_type_id ASC");

                            while ($data = mysqli_fetch_array($records)) {
                                echo "<option value='" . $data['product_type_id'] . "'>" . $data['product_type_name'] . "</option>";
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Item-Type</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit"><i class="bi bi-check2-circle"></i> Update Records</button>
        </form>
    </div>
</div>
<script>
    (function($) {
        showSwal = function(type) {
            'use strict';
            if (type === 'auto-close') {
                swal({
                    title: 'Auto close alert!',
                    text: 'I will close in 2 seconds.',
                    timer: 2000,
                    button: false
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === 'timer') {
                            console.log('I was closed by the timer')
                        }
                    }
                )
            } else {
                swal("Error occured !");
            }
        }

    })(jQuery);
</script>
<?php include('../footer.php'); ?>

</html>