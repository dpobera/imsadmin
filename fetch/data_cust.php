<?php include('config.php');

$output = array();
$sql = "SELECT * FROM customers";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'customers_id',
    1 => 'customers_company',
    2 => 'customers_address',
    3 => 'customers_contact',



);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE customers.customers_company like '%" . $search_value . "%'";
    $sql .= " OR customers.customers_name like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= " ORDER BY customers.customers_id DESC";
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
    $sub_array[] = '&nbsp;' . str_pad($row["customers_id"], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['customers_company'];
    $sub_array[] = $row['customers_address'];
    $sub_array[] = $row['customers_contact'];
    $sub_array[] = '<center><a href="cus-edit.php?id=' . $row["customers_id"] . '"  class="btn btn-secondary bg-gradient btn-sm deleteBtn" ><i class="bi bi-pencil"></i> Edit</a></center>';
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_rows,
    'recordsFiltered' =>   $total_all_rows,
    'data' => $data,
);
echo  json_encode($output);
