<?php include 'header.php';
if (!isset($_SESSION['user'])) {
  header("location: login.php");
}
include('php/config.php');

if (isset($_POST['sup_submit'])) {
  $id = $_POST['id'];
  $sup_name = mysqli_real_escape_string($db, $_POST['sup_name']);
  $sup_conper = mysqli_real_escape_string($db, $_POST['sup_conper']);
  $sup_tel = mysqli_real_escape_string($db, $_POST['sup_tel']);
  $sup_address = mysqli_real_escape_string($db, $_POST['sup_address']);
  $sup_email = mysqli_real_escape_string($db, $_POST['sup_email']);
  $sup_tin = mysqli_real_escape_string($db, $_POST['sup_tin']);
  $tax_type_id = mysqli_real_escape_string($db, $_POST['tax_type_id']);




  mysqli_query($db, "UPDATE sup_tb SET sup_name='$sup_name', sup_conper='$sup_conper' ,sup_tel='$sup_tel' ,sup_address='$sup_address' ,sup_email='$sup_email', sup_tin='$sup_tin', tax_type_id='$tax_type_id' WHERE sup_id='$id'");


  echo
  '<script>
alert("Successfully updated!");
location.href = "sup_edit.php?id=' . $id . '";
</script>';
}


if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

  $id = $_GET['id'];
  $result = mysqli_query($db, "SELECT * FROM sup_tb INNER JOIN tax_type_tb ON tax_type_tb.tax_type_id = sup_tb.tax_type_id WHERE sup_id=" . $_GET['id']);

  $row = mysqli_fetch_array($result);

  if ($row) {

    $id = $row['sup_id'];
    $sup_name = $row['sup_name'];
    $sup_conper = $row['sup_conper'];
    $sup_tel = $row['sup_tel'];
    $sup_address = $row['sup_address'];
    $sup_email = $row['sup_email'];
    $sup_tin = $row['sup_tin'];
    $tax_type_id = $row['tax_type_id'];
    $tax_type_name = $row['tax_type_name'];
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
        <h1 class="h2 text-secondary font-monospace">SUPPLIER / Editing Records</h1>
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
                <label for="floatingInput">SUPPLIER ID</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="sup_name" id="stin_code" value="<?php echo $sup_name ?>">
                <label for="floatingInput"> SUPPLIER NAME</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="sup_address" id="stin_title" value="<?php echo $sup_address ?>">
                <label for="floatingInput"> ADDRESS</label>
              </div>
            </div>
          </div>



          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="sup_conper" id="stin_title" value="<?php echo $sup_conper ?>">
                <label for="floatingInput"> CONTACT PERSON</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating">
                <input type="text" class="form-control" name="sup_tel" id="stin_title" value="<?php echo $sup_conper ?>">
                <label for="floatingInput"> CONTACT NO.</label>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="sup_email" id="stin_title" value="<?php echo $sup_email ?>">
                <label for="floatingInput">EMAIL</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating">
                <input type="text" class="form-control" name="sup_tin" id="stin_title" value="<?php echo $sup_tin ?>">
                <label for="floatingInput"> TIN NO.</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating  mb-3">
                <select class="form-select" id="sel1" name="tax_type_id">
                  <option value="<?php echo $tax_type_id ?>"><?php echo $tax_type_name; ?></option>
                  <?php
                  include "php/config.php";
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
              <button type="submit" class="btn btn-secondary bg-gradient" name="sup_submit">UPDATE RECORD</button>
              <a href="sup-index.php"> <button type="button" class="btn btn-secondary bg-gradient">CANCEL</button></a>
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