<?php

include '../../php/config.php';
$query = "SELECT po_code FROM po_tb ORDER BY po_code DESC LIMIT 1";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $newOrderIdPo = $row['po_code'] + 1;
        echo "<input style='border:none;background-color:transparent; font-weight:bolder; color:grey;' name='po_code' value='" . str_pad($newOrderIdPo, 8, 0, STR_PAD_LEFT) . "' readonly>";
    }
} else {
    echo "No result.";
}
