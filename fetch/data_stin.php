<?php include('config.php');

$output = array();
$sql = "SELECT stin_tb.stin_id, stin_tb.stin_code, stin_tb.stin_title, employee_tb.emp_name, stin_tb.stin_date, stin_tb.closed, user.user_name, stin_tb.stin_remarks
FROM stin_tb
LEFT JOIN user ON user.user_id = stin_tb.user_id
LEFT JOIN employee_tb ON stin_tb.emp_id = employee_tb.emp_id";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'stin_id',
    1 => 'stin_tittle',
    2 => 'stin_code',
    3 => 'emp_name',

);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE stin_tb.stin_code like '%" . $search_value . "%'";
    $sql .= " OR stin_tb.stin_title like '%" . $search_value . "%'";
    $sql .= " OR employee_tb.emp_name like '%" . $search_value . "%'";
    $sql .= " OR stin_tb.stin_remarks like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= " ORDER BY stin_tb.stin_id desc";
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

    $dateString = $row['stin_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');
    $closed = $row["closed"];

    if ($closed == 0) {
        $str = '<center class="text-warning"><i class="bi bi-circle-fill" title="OPEN"></i></center>';
        $disable = ' 
      
               
 
               
     ';
    } else {
        $str = '<center class="text-danger"><i class="bi bi-dash-circle-fill" title="CLOSED"></i></center>';
        $disable = '
        
    
       
      ';
    }

    $sub_array = array();
    $sub_array[] = '&nbsp;' . str_pad($row["stin_id"], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['stin_code'];
    $sub_array[] = $row['stin_title'];
    $sub_array[] = $row['emp_name'];
    $sub_array[] = '<center>' . $date . '</center>';
    $sub_array[] = $row['stin_remarks'];

    $sub_array[] = $disable . ' 

    <a href="stin_edit.php?edit&id=' . $row["stin_id"] . '">
    <button class="btn btn-success btn-sm bg-gradient" title="Details" style="">EDIT</button></a>
    <a href="commit/stin_recommit.php?id=' . $row["stin_id"] . '">
    <button class="btn btn-primary btn-sm bg-gradient" title="Commit Record">RECOMIT</button></a>';
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
