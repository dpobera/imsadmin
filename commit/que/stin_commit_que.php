<?php

//Check closed value if 1 or 0
//- Select query for stin_tb

if (isset($_GET['submit'])) {

	include "../../php/config.php";

	$bal_qty = $_GET['bal_qty'];
	$in_qty = $_GET['in_qty'];
	$productId = $_GET['product_id'];
	$stin_id = $_GET['stin_id'];
	$mov_date = $_GET['mov_date'];

	$sql = "SELECT closed FROM stin_tb WHERE stin_id = " . $_GET['stin_id'];
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
		foreach ($_GET['stin_temp_tot'] as $stin_temp_tot) {
			$total[] = $stin_temp_tot;
		}

		foreach ($_GET['product_id'] as $product_id) {
			$pro_id[] = $product_id;
		}

		//update database by number of row in stin_commit or number of product ID

		$sql = "UPDATE stin_tb SET closed = 1 WHERE stin_id = " . $_GET['stin_id'];
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
            VALUES (" . $productId[$limit] . "," . $bal_qty[$limit] . "," . $in_qty[$limit] . ", 1 " . "," . $stin_id . ",'" . $mov_date . "')";
			if (mysqli_query($db, $sql)) {
				$status2 = "Inventory Records UPDATED !";
				echo "<script> alert('" . $status2 . "')
	location.href = '../../stin-index.php'</script>";
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($db) . "<br>" . "<br>";
			}

			$limit++;
		}
	} else {
		$status = "Transaction Closed, Viewing Purpose Only !";
		echo "<script> alert('" . $status . "')
		location.href = '../../stin-index.php'</script>";
	}

	// header("location: ../../stin-index.php");
}
