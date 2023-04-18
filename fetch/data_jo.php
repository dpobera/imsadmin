<?php include('config.php');

$output = array();
$sql = "SELECT jo_tb.jo_id, jo_tb.jo_no, customers.customers_name, employee_tb.emp_name, jo_tb.jo_date, jo_tb.closed, user.user_name, jo_tb.jo_type_id, jo_type.jo_type_name, jo_tb.jo_status_id,customers_company
FROM jo_tb
LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id
LEFT JOIN user ON user.user_id = jo_tb.user_id
LEFT JOIN employee_tb ON employee_tb.emp_id = jo_tb.emp_id
LEFT JOIN jo_type ON jo_type.jo_type_id = jo_tb.jo_type_id
LEFT JOIN jo_status ON jo_status.jo_status_id = jo_tb.jo_status_id";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
	0 => 'jo_id',
	1 => 'jo_no',
	2 => 'customers_name',
	3 => 'emp_name',

);


if (isset($_POST['search']['value'])) {
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE jo_tb.jo_no like '%" . $search_value . "%'";
	$sql .= " OR customers.customers_name like '%" . $search_value . "%'";
	$sql .= " OR employee_tb.emp_name like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
	$sql .= " ORDER BY jo_tb.jo_id desc";
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

	$dateString = $row['jo_date'];
	$dateTimeObj = date_create($dateString);
	$date = date_format($dateTimeObj, 'm/d/y');
	$closed = $row['jo_status_id'];
	if ($closed == 1) {
		$str = '<center class="text-success"><i class="bi bi-circle-fill" title="OPEN"></i></center>';
		$disable = '<center>
		<a href="jo_edit.php?editJo&id=' . $row["jo_id"] . '&joTypeId=' . $row['jo_type_id'] . '&joTypeName=' . $row['jo_type_name'] . '"  class="btn btn-secondary btn-sm bg-gradient editbtn" ><i class="bi bi-pencil-fill"></i></a>  
		<a href="javascript:void();" data-id="' . $row['jo_id'] . '"  class="btn btn-secondary btn-sm bg-gradient deleteBtn" ><i class="bi bi-trash-fill"></i></a>
		</center>
';
	} else {
		$str = '<center class="text-danger"><i class="bi bi-dash-circle-fill" title="CLOSED"></i></center>';
		$disable = ' 
		<center>
		<button style="cursor:not-allowed" class="btn btn-outline-secondary btn-sm" disabled>
		<i class="bi bi-pencil-fill"></i>
		</button>  
		<button class="btn btn-outline-secondary btn-sm" disabled>
		<i class="bi bi-trash-fill"></i>
		</button>
		</center>
';
	}

	$sub_array = array();
	$sub_array[] = '&nbsp;' . str_pad($row["jo_id"], 8, 0, STR_PAD_LEFT);
	$sub_array[] = $row['jo_no'];
	$sub_array[] = $row['customers_name'];
	$sub_array[] = $row['emp_name'];
	$sub_array[] = '<center>' . $date . '</center>';
	$sub_array[] = '<center>' . $row['user_name'] . '</center>';
	$sub_array[] = $disable;
	// $sub_array[] = '<center><a href="javascript:void(); data-id="' . $row['jo_id'] . '"  class="btn btn-outline-primary btn-sm editbtn" ><i class="bi bi-pencil-fill"></i></a>  <a href="javascript:void();" data-id="' . $row['jo_id'] . '"  class="btn btn-outline-danger btn-sm deleteBtn" ><i class="bi bi-trash-fill"></i></a></center>';
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
