<?php
include 'config.php';


$q = $_GET['q'];

$query = "SELECT * FROM customers WHERE customers_name LIKE '%$q%' ORDER BY customers_id LIMIT 20";

$output = [];

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output[] = $row;
    }
} else {
    echo "No result";
}

echo json_encode($output);
