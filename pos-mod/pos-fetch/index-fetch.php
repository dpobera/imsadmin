<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<?php

$connect = new PDO("mysql:host=localhost; dbname=inventorymanagement", "root", "");

/*function get_total_row($connect)
{
  $query = "
  SELECT * FROM tbl_webslesson_post
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  return $statement->rowCount();
}

$total_record = get_total_row($connect);*/

$limit = '12';
$page = 1;
if ($_POST['page'] > 1) {
  $start = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
} else {
  $start = 0;
}

$query = "
SELECT jo_tb.jo_id, jo_tb.jo_no, customers.customers_name, employee_tb.emp_name, jo_tb.jo_date, jo_tb.closed, user.user_name, jo_tb.jo_type_id, jo_type.jo_type_name, jo_tb.jo_status_id,customers_company
FROM jo_tb
LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id
LEFT JOIN user ON user.user_id = jo_tb.user_id
LEFT JOIN employee_tb ON employee_tb.emp_id = jo_tb.emp_id
LEFT JOIN jo_type ON jo_type.jo_type_id = jo_tb.jo_type_id
LEFT JOIN jo_status ON jo_status.jo_status_id = jo_tb.jo_status_id
 ";

if ($_POST['query'] != '') {
  $query .= "
  WHERE customers.customers_name LIKE '%" . $_POST['query'] . "%' OR jo_tb.jo_no LIKE '%" . $_POST['query'] . "%' 
  ";
}

$query .= 'ORDER BY jo_id DESC ';




$filter_query = $query . 'LIMIT ' . $start . ', ' . $limit . '';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();




$output = '
<br>
<table class="table table-hover table" width="100%" style="cursor:pointer;">
  <tr>
    <th>JO ID</th>
    <th>Job-Order No. </th>
    <th>Customer</th>
    <th>Total Amount</th>
    <th>Balance</th>
    <th><center>Date</th>
    <th></th>

    
  </tr>
';
if ($total_data > 0) {
  foreach ($result as $row) {

    $joId = $row["jo_id"];
    $closed = $row["jo_status_id"];
    $dateString = $row["jo_date"];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');


    include '../php/config.php';
    $joTotalQry = "SELECT jo_product.jo_product_price * jo_product.jo_product_qty AS jo_product_total FROM jo_product WHERE jo_product.jo_id = '$joId'";
    $joTotalResult = mysqli_query($db, $joTotalQry);
    $joTotalAmount = 0;

    if (mysqli_num_rows($joTotalResult) > 0) {

      while ($joTotalRow = mysqli_fetch_assoc($joTotalResult)) {
        // Add every item total
        $joTotalAmount += $joTotalRow['jo_product_total'];
      }
    }

    // Get the latest balance
    include_once '../php/functions.php';

    $balance = getPaymentBalance($db, $joId);

    if ($balance == 0) {
      continue;
    }

    $output .= '
    <tr>
      <td>' . str_pad($row["jo_id"], 8, 0, STR_PAD_LEFT) . '</td>
      <td>' . $row["jo_no"] . '</td>
      <td>' . $row["customers_company"] . '</td>
      <td>' . number_format($joTotalAmount, 2, '.', ',')  . '</td>
      <td>' . number_format($balance, 2, '.', ',')  . '</td>
    
      <td style="letter-spacing:1px;text-align:center">' . $date . '</td>
      <td><a href="pos-cashier.php?editJo&id=' . $joId . '" disabled> <button class="btn btn-primary" title="Edit">Next <i class="bi bi-caret-right-fill"></i></button></a></td>
    </tr>
    ';
  }
} else {
  $output .= '
  <tr>
    <td colspan="10" align="center"><div class="alert alert-danger" role="alert">
    No Records found !
   </div></td>
  </tr>
  ';
}

$output .= '
</table>
<br />
<label style="float:right; color:gray;">Total Records - ' . $total_data . '</label>
<br />
<div align="center">

</div>
';

echo $output;

?>

<script>
  function confirmAction() {
    let confirmAction = confirm("Are you sure you want to delete?");
    if (confirmAction) {
      alert("Deleted item successfully!!!");
    } else {

      alert("Action canceled");
    }
  }

  function confirmUpdate() {
    let confirmUpdate = confirm("Are you sure you want to CONFIRM record?\n \nNote: Double Check Input Records");
    if (confirmUpdate) {
      alert("CONFIRM Record successfully!");
    } else {

      alert("Action Canceled");
    }
  }
</script>