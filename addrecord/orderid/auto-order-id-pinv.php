<?php

include 'php/config.php';
$query = "SELECT pinv_id FROM pinv_tb ORDER BY pinv_id DESC LIMIT 1";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $newPinvId = $row['pinv_id'] + 1;
        echo "<input style='border:none;background-color:transparent; font-weight:bolder; color:grey;' name='newPinvId' value='" . str_pad($newPinvId, 8, 0, STR_PAD_LEFT) . "' readonly>";
    }
} else {
    echo "No result.";
}
