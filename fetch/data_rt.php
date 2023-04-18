<?php include('config.php');

$output = array();
$sql = "SELECT rt_tb.rt_id, rt_tb.rt_no, rt_tb.rt_date, customers.customers_name, user.user_name, rt_tb.closed
FROM rt_tb
LEFT JOIN customers ON customers.customers_id = rt_tb.customers_id
LEFT JOIN user ON user.user_id = rt_tb.user_id";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'rt_id',
    // 1 => 'rt_no',
    2 => 'customers_name',
    3 => 'rt_date',

);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE rt_tb.rt_no like '%" . $search_value . "%'";
    $sql .= " OR rt_tb.rt_no like '%" . $search_value . "%'";
    $sql .= " OR customers.customers_name like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= " ORDER BY rt_tb.rt_id desc";
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

    $dateString = $row['rt_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');
    $closed = $row["closed"];

    if ($closed == 0) {
        $str = '<center class="text-warning"><i class="bi bi-circle-fill" title="OPEN"></i></center>';
        $disable = ' <a href="rt_edit.php?edit&id=' . $row["rt_id"] . '" disabled> <button  class="btn btn-secondary btn-sm bg-gradient" title="Edit"><i class="bi bi-pencil-fill"></i></button></a>
      <a href="commit/rt_commit.php?id=' . $row["rt_id"] . '">
                <button class="btn btn-secondary btn-sm bg-gradient" title="Commit Record"><i class="bi bi-check2-circle"></i></button></a>



     ';
    } else {
        $str = '<center class="text-danger"><i class="bi bi-dash-circle-fill" title="CLOSED"></i></center>';
        $disable = '
        <button style="cursor:not-allowed" class="btn btn-outline-secondary btn-sm" disabled>
    	<i class="bi bi-pencil-fill"></i>
    	</button>
        <button style="cursor:not-allowed" class="btn btn-outline-secondary btn-sm" disabled>
    	<i class="bi-check2-circle"></i>
    	</button>



      ';
    }

    $sub_array = array();
    $sub_array[] = '&nbsp;' . str_pad($row["rt_id"], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['rt_no'];
    $sub_array[] = $row['customers_name'];
    $sub_array[] = '<center>' . $date . '</center>';
    $sub_array[] = '<center>' . $disable . ' <a href="view/viewrt.php?id=' . $row["rt_id"] . '" </center>
    <button class="btn btn-secondary btn-sm bg-gradient" title="Details" style=""><i class="bi bi-printer-fill"></i></button></a>';
    $sub_array[] = '<center>' . $row["user_name"] . '</center>';
    // $sub_array[] = $row['emp_name'];
    $sub_array[] = $str;
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_rows,
    'recordsFiltered' =>   $total_all_rows,
    'data' => $data,
);
echo  json_encode($output);
