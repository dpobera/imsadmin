<?php include('config.php');

$output = array();
$sql = "SELECT product.product_id, product.product_name, class_tb.class_name, product.qty, unit_tb.unit_name, unit_tb.unit_id, product.pro_remarks, loc_tb.loc_name,loc_tb.loc_id, product.barcode, product.price, product.cost, dept_tb.dept_name, dept_tb.dept_id, class_tb.class_id, product_type.product_type_name, product_type.product_type_id
FROM product
LEFT JOIN class_tb ON product.class_id = class_tb.class_id
LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
LEFT JOIN loc_tb ON product.loc_id = loc_tb.loc_id
LEFT JOIN dept_tb ON product.dept_id = dept_tb.dept_id
LEFT JOIN product_type ON product.product_type_id = product_type.product_type_id
";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'product_id',
    1 => 'product_name',
    2 => 'class_name',
    3 => 'qty',
    4 => 'unit_name',
    5 => 'pro_remarks',
    6 => 'loc_name',
    7 => 'barcode',
    8 => 'dept_name',

);

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE product.product_name like '%" . $search_value . "%'";
    $sql .= " OR class_tb.class_name like '%" . $search_value . "%'
    ";
    $sql .= " OR product.product_id like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
    $sql .= " ORDER BY product_id asc ";
}

if ($_POST['length'] != -1) {
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT  " . $start . ", " . $length;
}

$query = mysqli_query($con, $sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while ($row = mysqli_fetch_assoc($query)) {
    $sub_array = array();
    $sub_array[] = '&nbsp;' . str_pad($row['product_id'], 8, 0, STR_PAD_LEFT);
    $sub_array[] = $row['product_name'];
    $sub_array[] = $row['class_name'];
    $sub_array[] = $row['qty'];
    $sub_array[] = $row['unit_name'];
    $sub_array[] = $row['pro_remarks'];
    $sub_array[] = $row['loc_name'];
    $sub_array[] = $row['barcode'];
    $sub_array[] = $row['dept_name'];

    $sub_array[] = '<a href="itemlist_edit.php?id=' . $row["product_id"] . "&class=" . $row["class_id"] . "&qty=" . $row["qty"] . "&className=" . $row["class_name"] . "&unitId=" . $row["unit_id"] . "&unit=" . $row["unit_name"] . "&dept=" . $row["dept_name"] . "&deptId=" . $row["dept_id"] . "&loc=" . $row["loc_name"] . "&locId=" . $row["loc_id"] . "&proRemarks=" . $row["pro_remarks"] . "&price=" . $row["price"] . "&cost=" . $row["cost"] . "&barcode=" . $row["barcode"] . "&typeId=" . $row["product_type_id"] . "&typeName=" . $row["product_type_name"] . '"  class="btn btn-secondary bg-gradient btn-sm editbtn"><i class="bi bi-pencil-fill"></i></a>  

    <a href="item_movement.php?id=' . $row["product_id"] . '" title="View History"  class="btn btn-secondary bg-gradient btn-sm deleteBtn" ><i class="bi bi-hourglass"></i></a>
    <a href="item-image.php?id=' . $row["product_id"] . '" title="Image Preview"  class="btn btn-secondary bg-gradient btn-sm deleteBtn" ><i class="bi bi-card-image"></i></a>';
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_rows,
    'recordsFiltered' =>   $total_all_rows,
    'data' => $data,
);
echo  json_encode($output);
