<?php

include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT ol_tb.ol_id, ol_tb.ol_title, ol_tb.ol_date, ol_type.ol_type_name, ol_tb.ol_si
                                 FROM ol_tb
                                 LEFT JOIN ol_type ON ol_type.ol_type_id = ol_tb.ol_type_id
                                WHERE ol_id=" . $_GET['id']);


    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['ol_id'];
        $ol_title = $row['ol_title'];
        $ol_si = $row['ol_si'];
        $dateString = $row['ol_date'];
        $dateTimeObj = date_create($dateString);
        $date = date_format($dateTimeObj, 'm/d/y');
        $ol_type_name = $row['ol_type_name'];
    } else {
        echo "No results!";
    }
}


$str = $ol_type_name;

?>

<?php include('header.php') ?>
<style>
    thead {
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        z-index: 1;
        background-color: aliceblue;
        color: grey;

    }
</style>

<div class="row">

    <main class="col-md-12 ms-sm-auto col-md-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
            <h1 class="h2 text-secondary font-monospace"><?php echo strtoupper($str) ?> / COMITING RECORDS</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
                    <div class="btnAdd">

                    </div>
                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </symbol>
        </svg>


        <div class="container-fluid shadow-sm bg-light" style="background-color:#ededed;border:1px solid lightgrey;padding:2%">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" value="<?php echo $ol_type_name; ?>" style="cursor:not-allowed" readonly>
                        <label for="floatingInput">Online Platform</label>
                    </div>
                </div>

                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" value="<?php echo $ol_title; ?>" style="cursor:not-allowed" readonly>
                        <label for="floatingInput">OR No.</label>
                    </div>
                </div>


                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" value="<?php echo $ol_si; ?>" style="cursor:not-allowed" readonly>
                        <label for="floatingInput">SI No.</label>
                    </div>
                </div>

                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" value="<?php echo $date; ?>" style="cursor:not-allowed" readonly>
                        <label for="floatingInput">Online Transaction Date</label>
                    </div>
                </div>

                <form method="GET" action="../commit/que/ol_commit_que.php">
                    <input type="hidden" name="ol_id" value="<?php echo $_GET['id'] ?>">
                    <input type="hidden" name='mov_date' class='date'>
                    <br>
                    <div class="table-responsive shadow-sm" style="height: 32vh;background-color:white;border:1px solid lightgrey">
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr style="text-align: left;">
                                    <th width="10%">Product ID</th>
                                    <th width="30%">Item Name</th>
                                    <th width="10%">Beg. Qty</th>
                                    <th width="10%">Qty ORDER</th>
                                    <th width="5%">Unit</th>
                                    <th width="10%">Inc Qty</th>
                                    <th width="10%">SRP</th>
                                    <th width="10%">Less Amount</th>
                                    <th width="10%">SubTotal</th>
                                </tr>
                            </thead>

                            <?php
                            $sql = "SELECT product.product_id, product.product_name, product.qty, unit_tb.unit_name, product.price, ol_product.ol_qty, ol_product.ol_price, ol_product.ol_priceTot, ol_product.ol_fee
                    FROM product 
                    LEFT JOIN ol_product ON product.product_id = ol_product.product_id
                    LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id WHERE ol_product.ol_id='$id' ";

                            $result = $db->query($sql);
                            $count = 0;
                            if ($result->num_rows >  0) {

                                while ($irow = $result->fetch_assoc()) {
                                    $count = $count + 1;
                            ?>
                                    <tr>
                                        <td><?php echo str_pad($irow["product_id"], 8, 0, STR_PAD_LEFT); ?></td>
                                        <td><?php echo $irow['product_name'] ?></td>
                                        <td>
                                            <input type="hidden" name="bal_qty[]" value="<?php echo $irow['qty'] ?>">
                                            <?php echo number_format($irow['qty'], 2)  ?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="out_qty[]" value="<?php echo $irow['ol_qty'] ?>">
                                            <?php echo number_format($irow['ol_qty'], 2)  ?>
                                        </td>
                                        <td><?php echo $irow['unit_name'] ?></td>
                                        <td>
                                            <input type="hidden" name="ol_priceTot[]" value="<?php echo $irow["qty"] - $irow["ol_qty"]; ?>">
                                            <?php echo number_format($irow["qty"] - $irow["ol_qty"], 2)  ?>
                                        </td>
                                        <td><?php echo number_format($irow['ol_price'], 2)  ?></td>
                                        <td><?php echo number_format($irow['ol_fee'], 2)  ?></td>
                                        <td class="ep_totPrice">
                                            <input type="hidden" value="<?php echo $irow["ol_priceTot"]  ?>">
                                            <?php echo number_format($irow["ol_priceTot"], 2) ?>
                                        </td>
                                    </tr>
                                    <input type="hidden" name="product_id[]" value="<?php echo $irow['product_id'] ?>">
                            <?php }
                            } ?>

                            </center>
                        </table>
                    </div>




                    <div class="row mt-4">
                        <div class="col">

                            <button type="submit" name="submit" class="btn btn-secondary bg-gradient">Commit Records</button>
                            <a href=" ../shopee-index.php"><button type="button" class="btn btn-secondary bg-gradient">Cancel</button></a>
                        </div>
                    </div>

            </div><br>
            <div class="alert alert-warning d-flex align-items-center mt-2" role="alert">
                <svg class="bi flex-shrink-0 me-2 text-danger" width="40" height="40" role="img" aria-label="Warning:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>
                    <i> PLEASE DOUBLE CHECK <strong style="color: red;">INCOMING QUANTITY</strong> BEFORE COMMITTING! <br>* <strong style="color: red;">LOOK</strong> before you click !</i>
                </div>
            </div>
            </form>
        </div>
</div>






</main>
</div>





</body>

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