<?php include('config.php');

$output = array();
$sql = "SELECT po_tb.po_code, po_tb.po_title, po_tb.po_date, po_tb.po_remarks, sup_tb.sup_name, po_tb.po_id, po_tb.closed, sup_tb.sup_id,user.user_name, po_tb.po_terms, po_type.po_type_id, po_type.po_type_name,sup_tb.tax_type_id,po_tb.rec_date
FROM po_tb 
LEFT JOIN user ON user.user_id = po_tb.user_id
LEFT JOIN sup_tb ON sup_tb.sup_id=po_tb.sup_id
LEFT JOIN po_type ON po_type.po_type_id = po_tb.po_type_id  ";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'po_id',
    1 => 'po_code',
    // 2 => 'stout_code',
    // 3 => 'emp_name',

);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE po_tb.po_code like '%" . $search_value . "%'";
    $sql .= " OR sup_tb.sup_name like '%" . $search_value . "%'";
    // $sql .= " OR employee_tb.emp_name like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= " ORDER BY po_tb.po_id desc";
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
    // $closed = $row["closed"];
    $dateString = $row['po_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');

    $dateString2 = $row['rec_date'];
    $dateTimeObj2 = date_create($dateString2);
    $date2 = date_format($dateTimeObj2, 'm/d/y');


    $closed = $row["closed"];




    if ($closed == 0) {
        $str = '<center class="text-warning">  <div class="spinner-grow text-warning spinner-grow-sm" role="status">
        <span class="visually-hidden"></span>
      </div>
        <span class="visually-hidden"></span>
      </div>
      PENDING
   </center>';
        $disable = '              
                <a href="po_edit.php?editpo&id=' . $row["po_id"] . "&supId=" . $row["sup_id"] . "&supName=" . $row["sup_name"] . "&poTypeId=" . $row["po_type_id"] . "&poTypeName=" . $row["po_type_name"] . '"> <button  class="btn btn-secondary btn-sm bg-gradient" title="Edit"><i class="bi bi-pencil-fill"></i></button></a>
                <a href="commit/po_commit.php?id=' . $row["po_id"] . '">
                <button class="btn btn-secondary btn-sm bg-gradient" title="Receive Item"><i class="bi bi-inboxes-fill"></i></button></a>
               
    
      ';
        $stat = "<p class='text-warning'>----------</p>";
    } else {
        $str = '<center class="text-success"><i class="bi bi-check-circle-fill"></i> RECEIVED</center>';
        $disable = '
        <button style="cursor:not-allowed" class="btn btn-outline-secondary btn-sm" disabled>
		<i class="bi bi-pencil-fill"></i>
		</button>
        <button style="cursor:not-allowed" class="btn btn-outline-secondary btn-sm" disabled>
		<i class="bi bi-inboxes-fill"></i>
		</button>';
        $stat = $date2;
    }


    $sub_array = array();
    $sub_array[] = '&nbsp;' . str_pad($row["po_id"], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['po_code'];
    $sub_array[] = $date;
    $sub_array[] = $row["sup_name"];
    $sub_array[] = '<center>' . $disable . '
    <a href="view/viewpoV2.php?id=' . $row["po_id"] . '&tax=' . $row["tax_type_id"] . '">
    <button class="btn btn-secondary btn-sm bg-gradient" title="Print PO"><i class="bi bi-printer-fill"></i></button></a></center>
';
    $sub_array[] = '<center>' . $row["user_name"] . '</center>';
    $sub_array[] = $str;
    $sub_array[] = '<center>' . $stat . '</center>';
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_rows,
    'recordsFiltered' =>   $total_all_rows,
    'data' => $data,
);
echo  json_encode($output);
