<?php

include "../../php/config.php"; // Using database connection file here

$id = $_GET['id'];
$proId = $_GET['prodId'];


// get id through query string

// $qry = mysqli_query($db, "SELECT * FROM srr_product WHERE product_id='$proId' AND srr_id='$id'"); // select query
$qry = mysqli_query($db, "SELECT sup_tb.sup_name, srr_product.srr_qty, srr_product.srr_ref
                          LEFT JOIN srr_product ON srr_product.sup_id = sup_tb.sup_id 
                          WHERE srr_product.product_id='$proId' AND srr_product.srr_id='$id'"); // select query

// $data = mysqli_fetch_array($qry); // fetch data

if (isset($_POST['update'])) // when click on Update button
{
    $prodId = $_POST['product_id'];
    $qty = $_POST['srr_qty'];
    $srrRef = $_POST['srr_ref'];
    $supId = $_POST['sup_id'];
    $supName = $_POST['sup_name'];
    $srrDate = $_POST['srr_date'];



    $edit = mysqli_query($db, "UPDATE srr_product SET  srr_qty='$qty', srr_ref='$srrRef', sup_id='$supId', srr_date='$srrDate'
                               WHERE product_id='$proId' AND srr_id='$id'");

    if ($edit) {
        mysqli_close($db); // Close connection


    } else {
        // echo mysqli_error();
    }
    echo "<script>alert('New Record Added')</script>";
    echo "<script>window.close();</script>";
    exit;
}
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
    .con-form {
        font-family: Arial, Helvetica, sans-serif;
        border: 1px;
        color: midnightblue;
    }

    .butLink {

        background-color: #6495ed;
        border-radius: 4px;
        color: white;
        padding: 7px 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }

    .center {
        margin: auto;
        margin-top: 50px;
        width: 90%;
        padding: 30px;
        border-radius: 5px;
    }
</style>


<div class="con-form">
    <div class="center">
        <fieldset>
            <legend><b>Item Edit</legend>
            <form method="POST">
                <input type="hidden" name="product_id[]" value="<?php echo $proId; ?>" />
                <input type="hidden" value="<?php echo $id; ?>" />

                <table width="100%">
                    <tr>

                        <td><b>
                                <font color='midnightblue'>Supplier<em>*</em></font>
                                <br>
                                <select name="sup_id" class="select--emp" style="height: 30px;">
                                    <option value="<?php echo $_GET['supId'] ?>"><?php echo $_GET['supName']; ?></option>
                                    <?php
                                    $records = mysqli_query($db, "SELECT * FROM sup_tb ");

                                    while ($data = mysqli_fetch_array($records)) {
                                        echo "<option value='" . $data['sup_id'] . "'>" . $data['sup_name'] . "</option>";
                                    }
                                    ?>

                                </select>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <font color='midnightblue'>Reference No.<em>*</em></font> <br>
                            <input type="text" name="srr_ref" value="<?php echo $_GET['srrRef']; ?>">
                        </td>
                    </tr>

                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <font color='midnightblue'>Description<em>*</em></font> <br>
                            <input type="text" value="<?php echo $_GET['prodName']; ?>" size="100%" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <font color='midnightblue'>Qty<em>*</em></font> <br>
                            <input type="number" name="srr_qty" value="<?php echo $_GET['srrQty']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <font color='midnightblue'>Date<em>*</em></font> <br>
                            <input type="date" name="srr_date" value="<?php echo $_GET['srrDate']; ?>">
                        </td>
                    </tr>



                </table>
                <br><br>
                <input type="submit" name="update" value="Update" class="butLink" onclick="myFunction()">

                <button type="button" class="butLink" onclick="javascript:history.go(-1)">Back</button>
            </form>

        </fieldset>
    </div>
</div>

<script>
    function myFunction() {
        alert("Edit Item Successfully !! \n\n Press Back Button.");
    }
</script>