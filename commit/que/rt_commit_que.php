<?php

//Check closed value if 1 or 0
//- Select query for stin_tb

if (isset($_POST['submit'])) {

    include "../../php/config.php";

    $bal_qty = $_POST['bal_qty'];
    $in_qty = $_POST['in_qty'];
    $productId = $_POST['product_id'];
    $rt_id = $_POST['rt_id'];
    $mov_date = $_POST['mov_date'];

    $sql = "SELECT closed FROM rt_tb WHERE rt_id = " . $_POST['rt_id'];
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
        foreach ($_POST['rt_qtyTot'] as $rt_qtyTot) {
            $total[] = $rt_qtyTot;
        }

        foreach ($_POST['product_id'] as $product_id) {
            $pro_id[] = $product_id;
        }

        //update database by number of row in stin_commit or number of product ID

        $sql = "UPDATE rt_tb SET closed = 1 WHERE rt_id = " . $_POST['rt_id'];
        mysqli_query($db, $sql);

        $limit = 0;
        while ($limit != count($pro_id)) {


            $sql = "UPDATE product SET qty = " . $total[$limit] . " WHERE product_id=" . $pro_id[$limit];

            mysqli_query($db, $sql);


            $limit += 1;
        }

        $limit = 0;
        while (sizeof($productId) !== $limit) {

            $sql = "INSERT INTO move_product (product_id,bal_qty,in_qty,mov_type_id,move_ref,mov_date)
            VALUES (" . $productId[$limit] . "," . $bal_qty[$limit] . "," . $in_qty[$limit] . ", 9 " . "," . $rt_id . ",'" . $mov_date . "')";
            if (mysqli_query($db, $sql)) {
                header('http://192.168.1.50/main/stin_main.php');
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
            }

            $limit++;
        }
    } else {
        $status = "Transaction Closed, Viewing Purpose Only !";
        echo "<script> alert('" . $status . "')</script>";
    }
    // header("location: ../../rt-index.php");
}
