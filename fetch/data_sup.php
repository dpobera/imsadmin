<?php include('config.php');

$output = array();
$sql = "SELECT * FROM sup_tb";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
  0 => 'sup_id',
  1 => 'sup_name',
  2 => 'sup_address',
  3 => 'sup_conper',
  4 => 'sup_tel',
  5 => 'sup_email',


);


if (isset($_POST['search']['value'])) {
  $search_value = $_POST['search']['value'];
  $sql .= " WHERE sup_tb.sup_name like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
  $column_name = $_POST['order'][0]['column'];
  $order = $_POST['order'][0]['dir'];
  $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
  $sql .= " ORDER BY sup_tb.sup_id DESC";
}

if ($_POST['length'] != -1) {
  $start = $_POST['start'];
  $length = $_POST['length'];
  $sql .= " LIMIT  " . $start . ", " . $length;
}
//tbody data
$query = mysqli_query($con, $sql);
$count_rows = mysqli_num_rows($query);
$data = array();

while ($row = mysqli_fetch_assoc($query)) {

  $sub_array = array();
  $sub_array[] = '&nbsp;' . str_pad($row["sup_id"], 8, 0, STR_PAD_LEFT);
  $sub_array[] = $row['sup_name'];
  $sub_array[] = $row['sup_address'];
  $sub_array[] = $row['sup_conper'];
  $sub_array[] = $row['sup_tel'];
  $sub_array[] = $row['sup_email'];
  $sub_array[] = '<center><a href="sup_edit.php?id=' . $row["sup_id"] . '" title="View History"  class="btn btn-secondary bg-gradient btn-sm deleteBtn" ><i class="bi bi-pencil"></i> Edit</a></center>';
  $data[] = $sub_array;
}

$output = array(
  'draw' => intval($_POST['draw']),
  'recordsTotal' => $count_rows,
  'recordsFiltered' =>   $total_all_rows,
  'data' => $data,
);
echo  json_encode($output);
