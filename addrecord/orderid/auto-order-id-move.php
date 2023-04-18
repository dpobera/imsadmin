<?php

include 'php/config.php';
$query = "SELECT move_id FROM move_product ORDER BY move_id DESC LIMIT 1";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $newOrderId2 = $row['move_id'] + 1;
        echo "<input type='hidden' style='border:none;background-color:transparent; font-weight:bolder; color:grey;' name='move_id' value='" . str_pad($newOrderId2, 8, 0, STR_PAD_LEFT) . "' readonly>";
    }
} else {
    echo "No result.";
}
