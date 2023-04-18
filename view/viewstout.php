<?php

include('../php/config.php');

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

	$id = $_GET['id'];
	$result = mysqli_query($db, "SELECT  stout_tb.stout_id ,stout_tb.stout_code, stout_tb.stout_title, stout_tb.stout_remarks, stout_tb.itemdesc, stout_tb.stout_date, stout_tb.stout_remarks, employee_tb.emp_name, dept_tb.dept_name
														FROM stout_tb  
														LEFT JOIN employee_tb ON stout_tb.emp_id = employee_tb.emp_id
														LEFT JOIN dept_tb ON employee_tb.dept_id = dept_tb.dept_id
														WHERE stout_id=" . $_GET['id']);

	$row = mysqli_fetch_array($result);

	if ($row) {

		$id = $row['stout_id'];
		$stout_code = $row['stout_code'];
		$stout_title = $row['stout_title'];
		$stout_remarks = $row['stout_remarks'];
		$emp_name = $row['emp_name'];
		$dept_name = $row['dept_name'];
		$itemdesc = $row['itemdesc'];
		$dateString = $row['stout_date'];
		$dateTimeObj = date_create($dateString);
		$date = date_format($dateTimeObj, 'm/d/y');
	} else {
		echo "No results!";
	}
}

/* TEST CODE*/

/* TEST CODE END */
?>


<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Hugo 0.84.0">
	<title>PACC IMS v2.0</title>

	<!-- bs5 icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
	<script src="styles/sidebars.js"></script>
	<link rel="shortcut icon" href="../assets/brand/pacclogoWhite.ico" type="image/x-icon">

	<!-- Bootstrap core CSS -->
	<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../styles/dataTableStyle/css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../styles/dataTableStyle/css/datatables-1.10.25.min.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../styles/printing.css">
	<style>
		#printDiv {
			font-family: monospace;
		}

		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		}

		.pagination .page-item.active .page-link {
			background-color: gainsboro;
			color: black;
			border: 1px solid grey;
		}

		.pagination .page-link {
			color: black;
		}

		.pagination .page-link:hover {
			background-color: lightgray;
			color: black;

		}


		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}

		.h2 {
			letter-spacing: 2px;
		}

		th,
		label {
			text-transform: uppercase;
			font-weight: bold;
		}
	</style>
	<!-- Custom styles for this template -->
	<link href="../styles/sidebars.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/index-style.css">
</head>

<body style="background-color:whitesmoke;">

	<header class="navbar navbar-dark bg-dark sticky-top flex-md-nowrap p-0 shadow bg-gradient">
		<a class="navbar-brand bg-dark col-md-3 col-lg-2 me-0 px-3 bg-gradient" href="#"><img src="assets/brand/pacclogo.png" alt="" width="25" style="margin-bottom: 3px;"> PACC IMS v2.0</a>
		<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<!-- <input class="form-control form-control w-100" type="text" placeholder="Search" aria-label="Search"> -->
		<div class="navbar-nav">
			<div class="nav-item text-nowrap">
				<a class="nav-link px-3" href="php/logout-inc.php" title="Sign-Out">Sign out <i class="bi bi-box-arrow-left"></i></a>
			</div>
		</div>
	</header>
	<main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
		<div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom" style="background-color: transparent;">
			<h1 class="h2 text-secondary"></h1>
			<div class="btn-toolbar mb-2 mb-md-0">
				<div class="btn-group me-2">
					<div class="row">
						<div class="col">
							<button class="btn btn-secondary bg-gradient" id="doPrint">Print Record</button>
							<a href="../stout-index.php"><button class="btn btn-secondary bg-gradient"> Cancel</button></a>
						</div>
					</div>
					<div class="btnAdd">

					</div>
				</div>
			</div>
		</div>
	</main>


	<div class="container-sm">
		<div class="shadow-sm p-5 mt-5 bg-body rounded printPage" style="width:100%;" id="printDiv">
			<div class="top">
				<center>
					<h2>PHILIPPINE ACRYLIC & CHEMICAL CORPORATION</h2>
					<h3>REQUISITION SLIP</h3>
					<hr>
				</center>
			</div>
			<div class="row">
				<div class="col">
					<label for="">Job-Order No.:</label> <?php echo $stout_title; ?>
				</div>
				<div class="col" style="text-align: right;">
					<label for="">RS No.:</label> <?php echo $stout_code; ?>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<label for="">Item Description:</label> <?php echo $itemdesc; ?>
				</div>
				<div class="col" style="text-align: right;">
					<label for="">RS Date:</label> <?php echo $date; ?>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-9">
					<div class="table-responsive">
						<table class="table table-sm">
							<thead class="table-light">
								<tr style="text-align: left;">
									<th>QTY</th>
									<th>MATERIAL USE</th>
								</tr>
							</thead>
							<?php
							$sql = "SELECT product.product_name,stout_product.stout_temp_qty,unit_tb.unit_name, stout_product.stout_temp_remarks 
							FROM stout_product 
							LEFT JOIN product ON product.product_id = stout_product.product_id
							LEFT JOIN stout_tb ON stout_product.stout_id=stout_tb.stout_id
							LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id WHERE stout_product.stout_id='$id'";

							$result = $db->query($sql);
							$count = 0;
							if ($result->num_rows >  0) {

								while ($irow = $result->fetch_assoc()) {
									$count = $count + 1;
									$text = $irow['stout_temp_remarks'];
									$newtext = wordwrap($text, 50, "<br />", false);
							?>
									<td style=" padding-left: 10px; vertical-align:top"><?php echo $irow['stout_temp_qty'] ?><?php echo $irow['unit_name'] ?>
									</td>
									<td><?php echo $irow['product_name'] ?><br>
										<p style="font-size:smaller;line-height: 15px;">
											<?php
											$search = array(',');
											$replace = array('<br />', '');
											echo $irow['stout_temp_remarks'] = str_replace($search, $replace, $irow['stout_temp_remarks']);
											?>

										</p>
									</td>
									</tr>
							<?php }
							} ?>


						</table>
					</div>
				</div>
				<div class="col-3">
					<div class="table-responsive">
						<table class="table table-sm">
							<thead class="table-light">
								<tr style="text-align: left;">
									<th>REMARKS</th>
								</tr>
							</thead>
							<tr>


								<td><?php $search = array(',');
									$replace = array('<br /><br /><br />', '');
									echo $stout_remarks = str_replace($search, $replace, $stout_remarks); ?></td>
							</tr>

						</table>
					</div>
				</div>

			</div>

		</div>
		<br>

	</div>
	</table>


	<script>
		document.getElementById("doPrint").addEventListener("click", function() {
			var printContents = document.getElementById('printDiv').innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		});
	</script>

	<?php include '../footer.php' ?>