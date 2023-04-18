<?php include('config.php');

$output = array();
$sql = "SELECT delivery_receipt.dr_id,delivery_receipt.dr_number,delivery_receipt.user_id,delivery_receipt.dr_date,user.user_name,jo_tb.jo_no,customers.customers_name,customers.customers_id
FROM delivery_receipt
LEFT JOIN dr_products ON dr_products.dr_number = delivery_receipt.dr_number
LEFT JOIN jo_product ON dr_products.jo_product_id = jo_product.jo_product_id
LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id
LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id
LEFT JOIN user ON user.user_id = delivery_receipt.user_id


";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'dr_id',
    1 => 'jo_no',
    2 => 'dr_number',
    // 3 => 'emp_name',
    // 4 => 'dr_date',
    // 5 => 'user_name'
);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE delivery_receipt.dr_number like '%" . $search_value . "%'";
    $sql .= " OR jo_tb.jo_no like '%" . $search_value . "%'";
    $sql .= " OR customers.customers_name like '%" . $search_value . "%'";
    // $sql .= " OR employee_tb.emp_name like '%" . $search_value . "%'";
}



if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= "ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= "GROUP BY delivery_receipt.dr_number ORDER BY delivery_receipt.dr_id desc";
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

    $dateString = $row['dr_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');

    if ($row["jo_no"] == "" or $row["customers_name"] == "") {

        $disable = ' 
                
           ';
    } else {
        $disable = '
             
             <a href="view/pos-utilities_print_dr.php?dr_number=' . $row["dr_number"] . '">
            <button type="button" class="btn btn-secondary btn-sm bg-gradient"><i class="bi bi-printer"></i></button></a>  
            <a href="dr-image.php?drNum=' . $row["dr_number"] . '&custId=' . $row["customers_id"] . '" title="Image Preview"  class="btn btn-secondary bg-gradient btn-sm deleteBtn" ><i class="bi bi-card-image"></i></a> ';
    }






    $sub_array = array();
    $sub_array[] = '&nbsp;' . str_pad($row["dr_id"], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['jo_no'];
    $sub_array[] = $row['dr_number'];
    $sub_array[] = $row['customers_name'];
    $sub_array[] =   '<center>' . $date . '</center>';
    $sub_array[] = '<center>' . $row["user_name"] . '</center>';
    $sub_array[] =   '<center>' . $disable . '</center>';
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_rows,
    'recordsFiltered' =>   $total_all_rows,
    'data' => $data,
);
echo  json_encode($output);
