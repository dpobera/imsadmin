<?php

include('../php/config.php');

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

	$id = $_GET['id'];
	$srrNo = $_GET['srrNo'];
	$empName = $_GET['empName'];
}

/* TEST CODE*/

/* TEST CODE END */
?>
<html>
<title><?php echo $id; ?></title>

<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		body {
			font-family: sans-serif;
			padding: 20px;
		}

		.top {

			letter-spacing: 3px;
			line-height: 1%;
			padding-top: 10px;

		}

		.labels {
			margin-left: 40px;
			margin-right: 40px;
		}

		.container {
			border-radius: 10px;
			padding: 20px;

			background-color: white;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
			-moz-box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
			-webkit-box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
			-o-box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
			margin-bottom: 10px;
		}

		.itemtb td,
		th {
			text-align: center;
			border: 1px solid black;
			font-size: 12px;
			padding: 5px;
			text-align: left;

		}

		th {
			color: midnightblue;
			font-weight: bolder;
		}


		.itemtb {
			border-collapse: collapse;
		}

		.footer {
			margin-left: 40px;
			margin-right: 40px;
		}

		.butLink {
			background-color: midnightblue;
			color: white;
			padding: 7px 12px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			letter-spacing: 3px;
			cursor: pointer;
			font-size: 15px;
		}
	</style>

</head>


<body style="margin: auto;">
	<div class="top">
		<center>
			<h3 style="color: midnightblue;">PHILIPPINE ACRYLIC & CHEMICAL CORPORATION</h3>
			<h4 style="color: midnightblue;">Storeroom Reciepts Register</h4>
			<hr width="50%">

		</center>
	</div>

<button id="printpagebutton" onclick="printpage()" class="butLink">Print &nbsp;<i class="fa fa-print"></i></button>
	<h4 style="float:right">SRR No.: &nbsp;<?php echo $srrNo; ?></h4>

	<div class="content">
		<table width="100%" class="itemtb">
			<tr>
				<th width="10%">DATE</th>
				<th width="30%">SUPPLIER</th>
				<th width="10%">REF NO.</th>
				<th width="20%">DESCRIPTION</th>
				<th width="10%">QTY</th>
				<th width="10%">UNIT</th>
				<th width="10%">Remarks</th>
			</tr>
			<tr>
				<?php

				$id = $_GET['id'];

				$sql = "SELECT  srr_product.srr_date, sup_tb.sup_name, srr_product.srr_ref, product.product_name, srr_product.srr_qty, unit_tb.unit_name, product.pro_remarks
   				 FROM srr_product
   				 LEFT JOIN sup_tb ON srr_product.sup_id = sup_tb.sup_id
   				 LEFT JOIN product ON srr_product.product_id = product.product_id
   				 LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
   				 WHERE srr_product.srr_id= $id
					ORDER BY sup_tb.sup_name ASC";

				$result = $db->query($sql);
				$count = 0;

				if ($result->num_rows >  0) {

					while ($irow = $result->fetch_assoc()) {
						$count = $count + 1;
						$supName = $irow['sup_name'];
				?>
						<td><?php echo $irow['srr_date'] ?></td>
						<td><?php echo $irow['sup_name'] ?></td>
						<td><?php echo $irow['srr_ref'] ?></td>
						<td><?php echo $irow['product_name'] ?></td>
						<td><?php echo $irow['srr_qty'] ?></td>
						<td><?php echo $irow['unit_name'] ?></td>
						<td><?php echo $irow['pro_remarks'] ?></td>

			</tr>
	<?php }
				} ?>
		</table>
		<h5 style="float:right">Prepared By: &nbsp;<?php echo $empName ?></h5>
		<br>

		<button id="printpagebutton" onclick="printpage()" class="butLink">Print &nbsp;<i class="fa fa-print"></i></button>

	</div>
	<script>
		function printpage() {
			//Get the print button and put it into a variable
			var printButton = document.getElementById("printpagebutton");
			//Set the print button visibility to 'hidden' 
			printButton.style.visibility = 'hidden';
			//Print the page content
			window.print()
			printButton.style.visibility = 'visible';
		}
	</script>

</body>



</html>