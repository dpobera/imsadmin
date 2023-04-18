<?php

include '../../php/config.php';
$query = "SELECT ol_id FROM ol_tb ORDER BY ol_id DESC LIMIT 1";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $newOrderId = $row['ol_id'] + 1;
        echo "<input style='border:none;background-color:transparent; font-weight:bolder; color:grey;' name='ol_id' value='" . str_pad($newOrderId, 8, 0, STR_PAD_LEFT) . "'>";
    }
} else {
    echo "No result.";
}
