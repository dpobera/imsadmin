<?php include('config.php');

$output = array();
$sql = "SELECT ep_tb.ep_id, ep_tb.ep_no, ep_tb.ep_title, ep_tb.ep_date, customers.customers_name, ep_tb.closed, user.user_name, customers.customers_id
FROM ep_tb
LEFT JOIN customers ON customers.customers_id = ep_tb.customers_id
LEFT JOIN user ON user.user_id = ep_tb.user_id";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'ep_id',
    1 => 'ep_no',
    2 => 'ep_title',
    3 => 'customers_name',

);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE ep_tb.ep_no like '%" . $search_value . "%'";
    // $sql .= " OR stout_tb.stout_title like '%" . $search_value . "%'";
    // $sql .= " OR employee_tb.emp_name like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= " ORDER BY ep_tb.ep_id desc";
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
    $closed = $row["closed"];
    $dateString = $row['ep_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');


    if ($closed == 0) {
        $str = '<center class="text-warning"><i class="bi bi-circle-fill" title="OPEN"></i></center>';
        $disable = ' 

                <a href="ep_edit.php?editEp&id=' . $row["ep_id"] . '" disabled> <button  class="btn btn-secondary btn-sm bg-gradient" title="Edit"><i class="bi bi-pencil-fill"></i></button></a>

                <a href="commit/ep_commit.php?id=' . $row["ep_id"] . '">
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
		</button>';
    }

    $sub_array = array();
    $sub_array[] = '&nbsp;' . str_pad($row["ep_id"], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['ep_no'];
    $sub_array[] = $row['ep_title'];
    $sub_array[] = $row['customers_name'];
    $sub_array[] = '<center>' . $date . '</center>';
    $sub_array[] = '<center>'
        . $disable . '
     <a href="view/viewep2.php?id=' . $row["ep_id"] . '&epNo=' . $row["ep_no"] . '">
     <button class="btn btn-secondary btn-sm bg-gradient" title="Details" style=""><i class="bi bi-eye-fill" style="color:white"></i></button></a>
</center>';
    $sub_array[] = '<center>' . $row['user_name'] . '</center>';
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
