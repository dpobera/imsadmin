<?php include 'header.php';
if (!isset($_SESSION['user'])) {
  header("location: login.php");
}
include('php/config.php');


if (isset($_POST['submit'])) {
  $id = $_POST['id'];
  $customers_name = mysqli_real_escape_string($db, $_POST['customers_name']);
  $customers_company = mysqli_real_escape_string($db, $_POST['customers_company']);
  $customers_address = mysqli_real_escape_string($db, $_POST['customers_address']);
  $customers_contact = mysqli_real_escape_string($db, $_POST['customers_contact']);
  $customers_note = mysqli_real_escape_string($db, $_POST['customers_note']);
  $customers_tin = mysqli_real_escape_string($db, $_POST['customers_tin']);
  $tax_type_id = mysqli_real_escape_string($db, $_POST['tax_type_id']);


  mysqli_query($db, "UPDATE customers 
                  SET customers_name='$customers_name', customers_company='$customers_company', customers_address='$customers_address', customers_contact='$customers_contact', customers_note='$customers_note', customers_tin='$customers_tin', tax_type_id='$tax_type_id'  
                  WHERE customers_id='$id'");

  echo  '<script>
  alert("Successfully updated!");
  location.href = "cus-edit.php?id=' . $id . '";
  </script>';
  // header("Location:../utilities/bo_customer.php");
}


if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

  $id = $_GET['id'];
  $result = mysqli_query($db, "SELECT customers.customers_id, customers.customers_name,customers.customers_company,customers.customers_address,customers.customers_contact,customers.customers_note,customers.customers_tin,tax_type_tb.tax_type_id,tax_type_tb.tax_type_name
FROM customers
LEFT JOIN tax_type_tb ON tax_type_tb.tax_type_id = customers.tax_type_id
WHERE customers.customers_id=" . $_GET['id']);

  $row = mysqli_fetch_array($result);

  if ($row) {

    $id = $row['customers_id'];
    $customers_name = $row['customers_name'];
    $customers_company = $row['customers_company'];
    $customers_address = $row['customers_address'];
    $customers_contact = $row['customers_contact'];
    $customers_note = $row['customers_note'];
    $customers_tin = $row['customers_tin'];
    $taxTypeName = $row['tax_type_name'];
    $taxTypeId = $row['tax_type_id'];
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
<script defer src="js/stin_edit-script.js"></script>

<div class="container-fluid">
  <div class="row">
    <?php include "sidebar.php"; ?>
    <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
        <h1 class="h2 text-secondary font-monospace">CUSTOMER / Editing Records</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">

            <div class="btnAdd">

            </div>
          </div>
        </div>
      </div>
      <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <!-- content -->
        <div class="container-fluid shadow-sm bg-light mb-3 " style="border:1px solid lightgrey;padding:4%">
          <?php include "sidebar.php"; ?>

          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="id" value="<?php echo str_pad($id, 8, 0, STR_PAD_LEFT) ?>" style="width:auto;cursor:not-allowed" readonly>
                <label for="floatingInput">CUSTOMER ID</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="customers_company" id="stin_code" value="<?php echo $customers_company ?>">
                <label for="floatingInput"> CUSTOMER NAME</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="customers_address" id="stin_title" value="<?php echo $customers_address ?>">
                <label for="floatingInput"> ADDRESS</label>
              </div>
            </div>
          </div>



          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="customers_name" id="stin_title" value="<?php echo $customers_name ?>">
                <label for="floatingInput"> CONTACT PERSON</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating">
                <input type="text" class="form-control" name="customers_contact" id="stin_title" value="<?php echo $customers_contact ?>">
                <label for="floatingInput"> CONTACT NO.</label>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="customers_note" id="stin_title" value="<?php echo $customers_note ?>">
                <label for="floatingInput">NOTE</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating">
                <input type="text" class="form-control" name="customers_tin" id="stin_title" value="<?php echo $customers_tin ?>">
                <label for="floatingInput"> TIN NO.</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating  mb-3">
                <select class="form-select" id="sel1" name="tax_type_id">
                  <option value="<?php echo $taxTypeId ?>"><?php echo $taxTypeName; ?></option>
                  <?php

                  $records = mysqli_query($db, "SELECT * FROM tax_type_tb");

                  while ($data = mysqli_fetch_array($records)) {
                    echo "<option value='" . $data['tax_type_id'] . "'>" . $data['tax_type_name'] . "</option>";
                  }
                  ?>
                </select>
                <label for="sel1" class="form-label">Tax Type</label>
              </div>
            </div>
          </div>
          <div class="row float-end">
            <div class="col">
              <button type="submit" class="btn btn-secondary bg-gradient" name="submit">UPDATE RECORD</button>
              <a href="cust-index.php"> <button type="button" class="btn btn-secondary bg-gradient">CANCEL</button></a>
            </div>
          </div>


        </div>
      </form>
    </main>
  </div>
</div>



<!-- end of content -->







</body>
<?php include "footer.php"; ?>

</html>