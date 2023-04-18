<?php include('config.php');

$output = array();
$sql = "SELECT employee_tb.emp_id,employee_tb.emp_name,dept_tb.dept_name
        FROM employee_tb
        LEFT JOIN dept_tb ON dept_tb.dept_id = employee_tb.dept_id";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'emp_id',
    1 => 'emp_name',
    2 => 'dept_name',



);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE employee_tb.emp_name like '%" . $search_value . "%'";
    $sql .= " OR dept_tb.dept_name like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= " ORDER BY employee_tb.emp_name ASC";
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
    $sub_array[] = '&nbsp;' . str_pad($row["emp_id"], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['emp_name'];
    $sub_array[] = $row['dept_name'];

    // $sub_array[] = '<center><a href="class-edit.php?id=' . $row["class_id"] . '"   class="btn btn-secondary bg-gradient btn-sm deleteBtn" ><i class="bi bi-pencil" id="submit"></i> Edit</a></center>';
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_rows,
    'recordsFiltered' =>   $total_all_rows,
    'data' => $data,
);
echo  json_encode($output);
