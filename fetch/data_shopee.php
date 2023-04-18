<?php include('config.php');

$output = array();
$sql = "SELECT ol_tb.ol_id, ol_tb.ol_title, ol_type.ol_type_id, ol_type.ol_type_name, ol_tb.ol_date, ol_tb.closed, user.user_name, ol_tb.ol_si
FROM ol_tb
LEFT JOIN ol_type ON ol_type.ol_type_id = ol_tb.ol_type_id
LEFT JOIN user ON user.user_id = ol_tb.user_id
";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'ol_id',
    1 => 'ol_title',
    2 => 'ol_type_name',
    // 3 => 'emp_name',
);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE ol_tb.ol_id like '%" . $search_value . "%'";
    $sql .= " OR ol_tb.ol_title like '%" . $search_value . "%'";
    $sql .= " OR ol_tb.ol_si like '%" . $search_value . "%'";
    $sql .= " OR ol_type.ol_type_name like '%" . $search_value . "%'";
}



if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= " ORDER BY ol_tb.ol_id desc";
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

    $dateString = $row['ol_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');
    $closed = $row["closed"];
    $type = $row["ol_type_id"];

    if ($type == 2) {

        $olstr = "<p class='text-warning fw-bold text-uppercase'>" . $row['ol_type_name'] . "</p>";
    } else {
        $olstr = "<p class='text-primary fw-bold text-uppercase'>" . $row['ol_type_name'] . "</p>";
    }

    if ($closed == 0) {
        $str = '<center class="text-warning"><i class="bi bi-circle-fill" title="OPEN"></i></center>';
        $disable = ' <a href="ol_edit.php?editOl&id=' . $row["ol_id"] . '" disabled> <button  class="btn btn-secondary btn-sm bg-gradient" title="Edit"><i class="bi bi-pencil-fill"></i></button></a>
      <a href="commit/ol_commit.php?id=' . $row["ol_id"] . '">
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
    // $sub_array[] = '';
    $sub_array[] = '&nbsp;' . str_pad($row["ol_id"], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['ol_title'];
    $sub_array[] = $row['ol_si'];
    $sub_array[] = $olstr;
    $sub_array[] = '<center>' . $date . '</center>';
    // $sub_array[] = $row['stin_remarks'];

    $sub_array[] = $disable . ' <a href="view/viewsi_2.php?id=' . $row["ol_id"] . '">
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
