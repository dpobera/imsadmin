<?php
include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

  $id = $_GET['id'];

  $result = mysqli_query($db, "SELECT po_tb.po_code, po_tb.po_title, po_tb.po_date, po_tb.po_remarks, sup_tb.sup_id, po_tb.po_id, sup_tb.sup_name, sup_tb.sup_address, po_tb.po_terms, sup_tb.sup_tin, po_type.po_type_name
  FROM sup_tb 
  LEFT JOIN po_tb ON sup_tb.sup_id = po_tb.sup_id  
  LEFT JOIN po_type ON po_type.po_type_id = po_tb.po_type_id

  WHERE po_tb.po_id=" . $_GET['id']);


  $row = mysqli_fetch_array($result);

  if ($row) {
    $id = $row['po_id'];
    $po_code = $row['po_code'];
    $dateString = $row['po_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');
    $po_title = $row['po_title'];
    $po_remarks = $row['po_remarks'];
    $sup_name = $row['sup_name'];
    $sup_address = $row['sup_address'];
    $sup_tin = $row['sup_tin'];
    $po_terms = $row['po_terms'];
    $po_type = $row['po_type_name'];
  } else {
    echo "No results!";
  }
}


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


<div class="container-fluid">
  <div class="row">

    <main class="col-md-12 ms-sm-auto col-md-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
        <h1 class="h2 text-secondary font-monospace">PURCHASE ORDER / RECEIVING ITEMS</h1>
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
      <div class="container-fluid shadow-sm bg-light" style="border:1px solid lightgrey;padding:2%">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <form method="GET" action="../commit/que/po_commit_que.php">

          <div class="row">
            <div class="col-4">
              <div class="form-floating mb-2">
                <input type="text" id="id" class="form-control form-control-sm" name="poId" value="<?php echo str_pad($id, 8, 0, STR_PAD_LEFT) ?>" readonly>
                <label for="floatingInput">Purchase-Order ID</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" value="<?php echo $po_code ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Purchase-Order Code</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" value="<?php echo $po_title ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Purchase-Order Title</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" value="<?php echo $po_terms ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Purchase-Order Terms</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" value="<?php echo $date ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Purchase-Order Date</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-floating">
                <textarea class="form-control form-control-sm" id="floatingTextarea" style="cursor:not-allowed" readonly><?php echo $po_remarks ?></textarea>
                <label for="floatingTextarea">Purchase-Order Remarks</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" value="<?php echo $sup_name ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Supplier</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" value="<?php echo $po_type ?>" style="cursor:not-allowed" readonly>
                <label for="floatingInput">Purchase-Order Type</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <input type="date" class="form-control form-control-sm" name="rec_date" required>
                <label for="floatingInput">Recieving Date</label>
              </div>
            </div>
          </div>


          <input type="hidden" name="po_id" value="<?php echo $_GET['id'] ?>">
          <input type="hidden" name='mov_date' class='date'>
          <div class="table-responsive" style="height: 32vh;background-color:white;border:1px solid lightgrey">
            <table class="table table-sm">
              <thead class="table table-light text-secondary">
                <tr>
                  <th width="10%">Product ID</th>
                  <th width="30%">Item Name</th>
                  <!-- <th width="10%">Beg. Qty</th> -->
                  <!-- <th width="10%">Qty-Recieved</th> -->
                  <th width="10%">Qty-Order</th>
                  <th width="3%">Unit</th>
                  <th width="5%">Cost</th>
                  <th width="10%">Total Cost</th>
                  <th width="10%">Less Amount</th>
                  <th width="10%">Incomming-Qty</th>
                </tr>
              </thead>
              <?php
              $sql = "SELECT po_product.po_id, product.product_id ,product.product_name, product.qty, po_product.item_qtyorder, unit_tb.unit_name, product.cost, po_product.item_disamount,po_product.item_cost,po_product.po_temp_tot
                                  FROM product
                                  LEFT JOIN po_product
                                  ON product.product_id = po_product.product_id
                                  LEFT JOIN unit_tb
                                  ON product.unit_id = unit_tb.unit_id
                                  WHERE po_product.po_id = '$id' ";

              $result = $db->query($sql);
              $count = 0;
              if ($result->num_rows >  0) {

                while ($irow = $result->fetch_assoc()) {
                  $count = $count + 1;
              ?>
                  <tr>

                    <td contenteditable="false"><?php echo str_pad($irow["product_id"], 8, 0, STR_PAD_LEFT) ?></td>
                    <td contenteditable="false"><?php echo $irow['product_name'] ?></td>
                    <input type="hidden" name="bal_qty[]" value="<?php echo  $irow['qty'] ?>">
                    <input type="hidden" name="in_qty[]" value="<?php echo $irow['item_qtyorder'] ?>">
                    <td contenteditable="true"><?php echo number_format($irow['item_qtyorder'], 2)  ?></td>
                    <td contenteditable="true"><?php echo $irow['unit_name'] ?></td>
                    <td contenteditable="true"><?php echo number_format($irow['item_cost'], 2)  ?></td>
                    <td class="item_totcost">
                      <input type="number" name="item_totcost[]" style="border: none;width:100px;" value="<?php echo number_format($irow["item_qtyorder"] * $irow["item_cost"], 2); ?>" contenteditable="false">
                    </td>
                    <td contenteditable="true">
                      <?php echo number_format($irow['item_disamount'], 2)  ?>
                    </td>
                    <td class="po_temp_tot">
                      <input type="number" name="po_temp_tot[]" style="border: none;color:red" value="<?php echo  $irow["qty"] + $irow["item_qtyorder"]; ?>" contenteditable="false">
                    </td>
                  </tr>
                  <input type="hidden" name="product_id[]" value="<?php echo $irow['product_id'] ?>">
              <?php }
              } ?>

            </table>
          </div>
          <br>

          <div class="row mt-4 mb-4  float-end">
            <div class="col">
              <button type="submit" name="submit" class="btn btn-secondary bg-gradient">Commit Records</button>
              <a href=" ../po-index.php"><button type="button" class="btn btn-secondary bg-gradient">Cancel</button></a>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col">
            <div class="alert alert-warning d-flex align-items-center mt-2" role="alert">
              <svg class="bi flex-shrink-0 me-2 text-danger" width="40" height="40" role="img" aria-label="Warning:">
                <use xlink:href="#exclamation-triangle-fill" />
              </svg>
              <div>
                <i> PLEASE DOUBLE CHECK <strong style="color: red;">INCOMING QUANTITY</strong> BEFORE COMMITING! <br>* <strong style="color: red;">LOOK</strong> before you click !</i>
              </div>
            </div>
          </div>
        </div>


      </div>

  </div>
  </main>
  <!-- ------------ -->
</div>
</div>
















<!-- Items Details -->


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