<?php

//Check closed value if 1 or 0
//- Select query for ep_tb

if (isset($_POST['submit'])) {

    include "../../php/config.php";

    $bal_qty = $_POST['bal_qty'];
    $out_qty = $_POST['out_qty'];
    $productId = $_POST['product_id'];
    $ep_id = $_POST['ep_id'];
    $mov_date = $_POST['mov_date'];


    $sql = "SELECT closed FROM ep_tb WHERE ep_id = " . $_POST['ep_id'];
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $closed = $row['closed'];
        }
    } else {
        echo "0 results";
    }


    if ($closed == 0) {
        foreach ($_POST['ep_qty_tot'] as $ep_qty_tot) {
            $total[] = $ep_qty_tot;
        }

        foreach ($_POST['product_id'] as $product_id) {
            $pro_id[] = $product_id;
        }

        //update database by number of row in stout_commit or number of product ID

        $sql = "UPDATE ep_tb SET closed = 1 WHERE ep_id = " . $_POST['ep_id'];
        mysqli_query($db, $sql);

        $limit = 0;
        while ($limit != count($pro_id)) {


            $sql = "UPDATE product SET qty = " . $total[$limit] . " WHERE product_id=" . $pro_id[$limit];

            mysqli_query($db, $sql);

            $limit += 1;
        }

        $limit = 0;
        while (sizeof($productId) !== $limit) {

            $sql = "INSERT INTO move_product (product_id,bal_qty,out_qty,mov_type_id,move_ref,mov_date)
            VALUES (" . $productId[$limit] . "," . $bal_qty[$limit] . "," . $out_qty[$limit] . ", 6 " . "," . $ep_id . ",'" . $mov_date . "')";
            if (mysqli_query($db, $sql)) {
                echo "New record created successfully " . "<br>" . "<br>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
            }

            $limit++;
        }
    } else {
        $status = "Transaction Closed, Viewing Purpose Only !";
        echo "<script> alert('" . $status . "')</script>";
    }
    header("location: ../../ep-index.php");
}
