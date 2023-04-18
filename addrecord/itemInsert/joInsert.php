
<?php
session_start();
include_once "../../php/config.php";

//function for removing comma
function removeComma($str)
{
    $comma = "/,/i";
    if (preg_match($comma, $str)) {
        return str_replace(',', '', $str);
    } else {
        return $str;
    }
}
$joId = $_GET['jo_id'];
$productId = $_GET['product-id'];
$qty = $_GET['qty_order'];
$price = $_GET['price'];
$total = $_GET['total'];
$joNo = $_GET['jo_no'];
// $joRemarks = $_GET['remarks'];
$customersId = $_GET['customers_id'];
$joDate = $_GET['jo_date'];
$emp_id = $_GET['emp_id'];
$jo_type_id = $_GET['jo_type_id'];
$remarks = $_GET['jo_remarks'];


if (isset($_GET['btnsave']) && $productId[0] != "") { //Will not proceed if Products are Empty

    echo "<br>";

    foreach ($productId as $x) {
        echo "product id :" . $x . "<br>";
    }

    echo "jo id:" . $joId . "<br>" . "<br>";

    // Check product id from stout_product
    $checkResult = mysqli_query($db, "SELECT jo_no FROM jo_tb WHERE jo_no ='" . $joNo . "'");

    if (mysqli_num_rows($checkResult) > 0) {
        // If product id already exist on stout_product, UPDATE   
        echo "<script>alert('Duplicate JO No.')</script>";
        echo "<script>location.href='../../addjo.php'</script>";
    } else {
        $sql = "INSERT INTO jo_tb (jo_id, jo_no, customers_id ,emp_id ,jo_date, jo_type_id, user_id,jo_remarks)
            VALUES ('$joId','$joNo','$customersId','$emp_id','$joDate','$jo_type_id','" . $_SESSION['id'] . "','$remarks')";
        mysqli_query($db, $sql);
        $lastJoId = mysqli_insert_id($db);
        echo $lastJoId;

        $limit = 0;
        while (sizeof($productId) !== $limit) {

            $sql = "INSERT INTO jo_product (product_id,jo_id, jo_product_qty,jo_product_price)
                VALUES (" . $productId[$limit] . "," . $joId . "," . $qty[$limit] . "," . removeComma($price[$limit]) . ")";

            if (mysqli_query($db, $sql)) {
                echo "New record created successfully " . "<br>" . "<br>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
            }

            $limit++;
        }

        // get the total amount of JO
        $joTotalQry = "SELECT jo_product.jo_product_price * jo_product.jo_product_qty AS jo_product_total FROM jo_product WHERE jo_product.jo_id = '$lastJoId'";
        $joTotalResult = mysqli_query($db, $joTotalQry);
        $joTotalAmount = 0;

        if (mysqli_num_rows($joTotalResult) > 0) {

            while ($joTotalRow = mysqli_fetch_assoc($joTotalResult)) {
                // Add every item total
                $joTotalAmount += $joTotalRow['jo_product_total'];
            }
        }


        // Insert order payment using lastid of order_tb
        $order_payment_sql = "INSERT INTO order_payment (jo_id,order_payment_credit,order_payment_balance,payment_status_id)
        VALUES ('$lastJoId','$joTotalAmount','$joTotalAmount','1')";
        mysqli_query($db, $order_payment_sql);


        $limiter = 0;
        while (sizeof($productId) !== $limiter) {
            $sql = "UPDATE jo_product 
                        SET jo_remarks ='" . $joRemarks[$limiter]
                . "' WHERE product_id = " . $productId[$limiter] . " AND jo_id =" . $joId;


            if (mysqli_query($db, $sql)) {
                echo "New record created successfully " . "<br>" . "<br>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
            }

            $limiter++;
        }
    }
    if (mysqli_query($db, $sql)) {
        echo "<script>
        alert('New Record Added')
        location.href = '../../index.php'
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>";
    }
} else {

    $url = "pos-main.html?";

    foreach ($productId as $urlId) {
        $url .= "product_id[]=" . $urlId . "&";
    }
    echo $url;
    // header("location: " .$url); //Go back to main page
}
