<?php include('config.php');

$output = array();
$sql = "SELECT invoice.invoice_id,invoice.invoice_number,dr_inv.dr_number,customers.customers_name,invoice.invoice_date,user.user_name 
FROM invoice 
LEFT JOIN user ON user.user_id = invoice.user_id 
LEFT JOIN dr_inv ON dr_inv.inv_number = invoice.invoice_number 
LEFT JOIN dr_products ON dr_products.dr_number = dr_inv.dr_number 
LEFT JOIN jo_product ON dr_products.jo_product_id = jo_product.jo_product_id 
LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id 
LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id 



";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'invoice_id',
    1 => 'invoice_number',
    2 => 'dr_number',
    // 3 => 'emp_name',
    // 4 => 'dr_date',
    // 5 => 'user_name'
);


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE invoice.invoice_id like '%" . $search_value . "%'";
    $sql .= " OR invoice.invoice_number like '%" . $search_value . "%'";
    $sql .= " OR dr_inv.dr_number like '%" . $search_value . "%'";
    $sql .= " OR customers.customers_name like '%" . $search_value . "%'";
    // $sql .= " OR employee_tb.emp_name like '%" . $search_value . "%'";
}



if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= "ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= "GROUP BY dr_inv.dr_number ORDER BY invoice.invoice_id desc";
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

    $dateString = $row['invoice_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');

    if ($row["invoice_number"] == 0 or $row["dr_number"] == "") {

        $disable = ' 
                
           ';
    } else {
        $disable = '<a href="view/pos-utilities_print_si.php?inv_number=' . $row["invoice_number"] . '">
            <button type="button" class="btn btn-secondary btn-sm bg-gradient"><i class="bi bi-eye"></i> View SI</button></a>
             
             <a href="view/pos-utilities_print_si.php?inv_number=' . $row["invoice_number"] . '">
            <button type="button" class="btn btn-secondary btn-sm bg-gradient"><i class="bi bi-printer"></i> Re-Print</button></a>   ';
    }



    $sub_array = array();
    $sub_array[] = '<input type="checkbox" name="id[]" value=' . $row['invoice_id'] . '>';
    $sub_array[] = $row['invoice_number'];
    $sub_array[] = $row['dr_number'];
    $sub_array[] = $row['customers_name'];
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_rows,
    'recordsFiltered' =>   $total_all_rows,
    'data' => $data,
);
echo  json_encode($output);
