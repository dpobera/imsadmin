<?php

include '../../php/config.php';
$query = "SELECT stin_id FROM stin_tb ORDER BY stin_id DESC LIMIT 1";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $newOrderId = $row['stin_id'] + 1;
        echo "<input style='border:none;background-color:transparent; font-weight:bolder; color:grey;' name='stin_id' value='" . str_pad($newOrderId, 8, 0, STR_PAD_LEFT) . "' readonly>";
    }
} else {
    echo "No result.";
}
