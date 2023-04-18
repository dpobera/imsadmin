<?php include('config.php');

$output = array();
$sql = "SELECT stout_tb.stout_id, stout_tb.stout_code, stout_tb.stout_title, employee_tb.emp_name, stout_tb.stout_date, stout_tb.closed, user.user_name
FROM stout_tb
LEFT JOIN user ON user.user_id = stout_tb.user_id
LEFT JOIN employee_tb 
ON stout_tb.emp_id = employee_tb.emp_id ";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'stout_id',
    1 => 'stout_title',
    2 => 'stout_code',
    3 => 'emp_name',

);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE stout_tb.stout_code like '%" . $search_value . "%'";
    $sql .= " OR stout_tb.stout_title like '%" . $search_value . "%'";
    $sql .= " OR employee_tb.emp_name like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= " ORDER BY stout_tb.stout_id desc";
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
    $dateString = $row['stout_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');


    if ($closed == 0) {
        $str = '<center class="text-warning"><i class="bi bi-circle-fill" title="OPEN"></i></center>';
        $disable = ' 
                  <a href="stout_edit.php?edit&id=' . $row["stout_id"] . '"> <button  class="btn btn-secondary btn-sm bg-gradient" title="Edit"><i class="bi bi-pencil-fill"></i></button></a>
  
                  <a href="commit/stout_commit.php?id=' . $row["stout_id"] . '">
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
    $sub_array[] = '&nbsp;' . str_pad($row["stout_id"], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['stout_code'];
    $sub_array[] = $row['stout_title'];
    $sub_array[] = $row['emp_name'];
    $sub_array[] = '<center>' . $date . '</center>';
    $sub_array[] = '<center>' . $disable . ' <a href="view/viewstout.php?id=' . $row["stout_id"] . '">
    <button class="btn btn-secondary btn-sm bg-gradient" title="Details" style=""><i class="bi bi-eye-fill" style="color:white"></i></button></a>';
    $sub_array[] = '<center>' . $row["user_name"] . '</center>';
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
