<?php include 'header.php';
include '../php/config.php';
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

  $id = $_GET['id'];

  $result = mysqli_query($db, "SELECT stin_tb.stin_id,stin_tb.stin_code,stin_tb.stin_title,stin_tb.stin_date, employee_tb.emp_name
   FROM stin_tb
   LEFT JOIN employee_tb On employee_tb.emp_id = stin_tb.emp_id
    WHERE stin_id=" . $_GET['id']);


  $row = mysqli_fetch_array($result);

  if ($row) {
    $id = $row['stin_id'];
    $stin_code = $row['stin_code'];
    $stin_title = $row['stin_title'];
    $dateString = $row['stin_date'];
    $emp_name = $row['emp_name'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');
  } else {
    echo "No results!";
  }
}
?>
<link rel="stylesheet" href="css/jo_edit-style2.css">

<style>
  thead {
    position: sticky;
    position: -webkit-sticky;
    top: 0;
    z-index: 1;
    background-color: aliceblue;
    color: black;

  }
</style>
<script defer src="js/jo_edit-script.js"></script>

<div class="container-fluid">

  <div class="row">

    <main class="col-md-12 ms-sm-auto col-md-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
        <h1 class="h2 text-secondary font-monospace">STOCK INVENTORY IN / Commiting Record</h1>
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
      <!-- content -->
      <div class="container-fluid shadow-sm bg-light" style="background-color:#ededed;border:1px solid lightgrey;padding:2%">

        <div class="row">

          <input type="hidden" name="id" value="<?php echo $id; ?>" />
          <div class="row">
            <div class="col-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?php echo str_pad($id, 8, 0, STR_PAD_LEFT) ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Stock-In ID</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?php echo $stin_code ?>" style="cursor:not-allowed">
                <label for="floatingInput">Stock-In Code</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?php echo $stin_title ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Job-Order No.</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?php echo $emp_name ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Prepared By</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?php echo $date ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Stock-In Date</label>
              </div>
            </div>
          </div>
          <div class="container--table">
            <div class="table-responsive">
              <form action="../commit/que/stin_commit_que.php" method="GET">
                <input type="hidden" name="stin_id" value="<?php echo $_GET['id'] ?>">
                <input type="hidden" name="mov_date" class="date">
                <div class="table-responsive" style="height: 32vh;background-color:white;border:1px solid lightgrey">
                  <table class="table table-sm table-hover">
                    <thead class="table table-light text-secondary">
                      <tr style="text-align: left;">
                        <th width="10%">Prod ID</th>
                        <th width="55%">Item Name</th>
                        <th width="10%">Barcode</th>
                        <th width="10%">On-Hand</th>
                        <th width="10%">Qty-In</th>
                        <th width="5%">Unit</th>
                        <th width="10%">Incoming Qty</th>
                      </tr>
                    </thead>
                    <?php
                    $sql = "SELECT stin_tb.stin_id, product.product_id,product.product_name,product.qty,stin_product.stin_temp_qty,unit_tb.unit_name,product.cost,
                            stin_product.stin_temp_disamount, product.barcode
                            FROM stin_product 
                            LEFT JOIN product ON product.product_id = stin_product.product_id
                            LEFT JOIN stin_tb ON stin_product.stin_id=stin_tb.stin_id
                            LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id 
                            WHERE stin_product.stin_id='$id' ORDER BY stin_product_id ASC";

                    $result = $db->query($sql);
                    $count = 0;
                    if ($result->num_rows >  0) {

                      while ($irow = $result->fetch_assoc()) {

                    ?>
                        <tr>
                          <td><?php echo str_pad($irow["product_id"], 8, 0, STR_PAD_LEFT); ?></td>
                          <td contenteditable="false"><?php echo $irow['product_name'] ?></td>
                          <td contenteditable="false">
                            <?php
                            if ($irow['barcode'] == "") {
                              echo "N/A";
                            } else {
                              echo $irow['barcode'];
                            }
                            ?></td>
                          <td style="text-align: right;"><input type="text" name="bal_qty[]" value="<?php echo $irow['qty'] ?>" style="border: none;width:100%;background-color:transparent;" readonly></td>
                          <td contenteditable=" false">
                            <input type="number" class="form-control" name="in_qty[]" value="<?php echo $irow['stin_temp_qty'] ?>" style="border: none;text-align:left:100%;background-color:transparent;">
                          </td>
                          <td contenteditable="false"><?php echo $irow['unit_name'] ?></td>
                          <td class="stin_temp_tot"><input type="number" style="border: none;background-color:transparent;color:tomato;font-weight:bold" name="stin_temp_tot[]" value="<?php echo $irow["qty"] + $irow["stin_temp_qty"]; ?>" contenteditable="false"></td>

                        </tr>
                        <input type="hidden" name="product_id[]" value="<?php echo $irow['product_id'] ?>">
                    <?php }
                    } ?>

                  </table>

                </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col float-end">
              <button type="submit" name="submit" class="btn btn-secondary bg-gradient">Commit Records</button>
              <a href=" ../stin-index.php"><button type="button" class="btn btn-secondary bg-gradient">Cancel</button></a>
            </div>
          </div>

        </div>
        <div class="alert alert-warning d-flex align-items-center mt-2" role="alert">
          <svg class="bi flex-shrink-0 me-2 text-danger" width="40" height="40" role="img" aria-label="Warning:">
            <use xlink:href="#exclamation-triangle-fill" />
          </svg>
          <div>
            <i> PLEASE DOUBLE CHECK <strong style="color: red;">INCOMING QUANTITY</strong> BEFORE COMMITING! <br>* <strong style="color: red;">LOOK</strong> before you click !</i>
          </div>
        </div>
        </form>
      </div>
      <!-- end of content -->



      <script>
        //date
        document.querySelector('.date').value = new Date().toISOString();
        // The function below will start the confirmation dialog
      </script>


      </body>
      <?php include "../footer.php"; ?>

      </html