<?php

$connect = mysqli_connect("localhost", "root", "", "inventorymanagement");
$query = "SELECT delivery_receipt.dr_id,delivery_receipt.dr_number,delivery_receipt.user_id,delivery_receipt.dr_date,user.user_name,jo_tb.jo_no,customers.customers_name
FROM delivery_receipt
LEFT JOIN dr_products ON dr_products.dr_number = delivery_receipt.dr_number
LEFT JOIN jo_product ON dr_products.jo_product_id = jo_product.jo_product_id
LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id
LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id
LEFT JOIN user ON user.user_id = delivery_receipt.user_id
GROUP BY delivery_receipt.dr_number

";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Reciepts</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

  <style>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,600,700");
    @import url("https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css");
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css");

    *,
    *:before,
    *:after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
    }

    body {
      font: 14px/1 'Open Sans', sans-serif;
      color: #555;
      background: aliceblue;
    }

    h1 {
      padding: 50px 0;
      font-weight: 400;
      text-align: center;
    }

    p {
      margin: 0 0 20px;
      line-height: 1.5;
    }

    main {
      min-width: 100%;
      max-width: 800px;
      padding: 50px;
      margin: 0 auto;
      background: white;
    }

    section {
      display: none;
      padding: 20px 0 0;
      border-top: 1px solid #ddd;
    }

    input {
      display: none;
    }

    label {
      display: inline-block;
      margin: 0 0 -1px;
      padding: 15px 25px;
      font-weight: 600;
      text-align: center;
      color: #bbb;
      border: 1px solid transparent;
    }

    label:before {
      font-family: fontawesome;
      font-weight: normal;
      margin-right: 10px;
    }

    img {
      height: 3vh;
    }

    label:hover {
      color: #888;
      cursor: pointer;
    }

    input:checked+label {
      color: #555;
      border: 1px solid #ddd;
      border-top: 3px solid #443DFE;
      border-bottom: 1px solid #fff;
      background-color: white;
    }


    #tab1:checked~#content1,
    #tab2:checked~#content2 {
      display: block;
    }

    @media screen and (max-width: 650px) {
      label {
        font-size: 0;
      }

      label:before {
        margin: 0;
        font-size: 18px;
      }
    }

    .shopee {
      padding-bottom: 7px;
      border-bottom: 1px solid #443DFE;
      line-height: 48px;
    }

    .lazada {
      padding-bottom: 7px;
      border-bottom: 1px solid #443DFE;
      line-height: 48px;
    }

    th {
      text-align: left;
    }

    #data td {
      padding: 8px;
      margin: auto;

    }

    .table-striped>tbody>tr:nth-child(odd)>td,
    .table-striped>tbody>tr:nth-child(odd)>th {
      background-color: #FDFCFC;
    }

    thead {
      background-color: #443DFE;

    }





    @media screen and (max-width: 400px) {
      label {
        padding: 15px;
      }
    }
  </style>
</head>

<body>
  <main style="background-color: aliceblue;">
    <!-- tabs -->
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1"><a href="pos-utilities.php">Delivery Reciepts</a></label>

    <input type="radio" name="tabs">
    <label for="tab2"><a href="pos-utilities_si.php">Sales Invoice</a></label>

    <input type="radio" name="tabs">
    <label for="tab3"><a href="pos-utilities-or.php">Official Reciept</a></label>

    <input type="radio" name="tabs">
    <label for="tab4"><a href="ep_utilities.php">Exit-Pass</a></label>

    <!-- tab content -->
    <section id="content1" style=" padding:2%;border: 1px solid #ddd;background-color:white;height:auto;box-shadow: 5px 5px 5px #aaaaaa;">

      <a href="itemlist_main.php" style="float: right;text-decoration:none;color:#443DFE;font-weight:bold"> <i class="bi bi-chevron-left"></i>&emsp;Back to Itemlist</a>

      <div class="row">
        <div class="col">
          <h3 style="color: #443DFE;"> <span class="shopee">Delivery Reciepts Records</span> </h3>
        </div>

      </div>


      <div class="table-responsive">

        <table id="data" class="table table-striped" data-order='[[ 0, "desc" ]]'>
          <thead>
            <tr style="color: white;">
              <th>DR ID</th>
              <th>JO No.</th>
              <th>Dr No.</th>
              <th>Customer Name</th>
              <th style="text-align: center;">Date</th>
              <th style="text-align: center;">Created By</th>
              <th style="text-align: center;">Action</th>

            </tr>
          </thead>
          <?php
          while ($row = mysqli_fetch_array($result)) {

            if ($row["jo_no"] == "" or $row["customers_name"] == "") {

              $disable = ' <a href="view/pos-utilities_print_dr.php?dr_number=' . $row["dr_number"] . '">
                  <button type="button" class="btn btn-outline-success btn-sm" disabled><i class="bi bi-printer"></i> Re-Print DR</button></a>        
                 ';
            } else {
              $disable = ' <a href="view/pos-utilities_print_dr.php?dr_number=' . $row["dr_number"] . '">
                  <button type="button" class="btn btn-outline-success btn-sm"><i class="bi bi-printer"></i> Re-Print DR</button></a>   ';
            }
            $dateString = $row['dr_date'];
            $dateTimeObj = date_create($dateString);
            $date = date_format($dateTimeObj, 'm/d/y');

            echo '  
                               <tr>  
                                    <td align="left">' . str_pad($row["dr_id"], 8, 0, STR_PAD_LEFT) . '</td>  
                                    <td align="left">' . $row["jo_no"] . '</td> 
                                    <td align="left">' . $row["dr_number"] . '</td>   
                                    <td align="left">' . $row["customers_name"] . '</td>  
                                    <td align="center">' . $date . '</td>  
                                    <td align="center">' . $row["user_name"] . '</td>                              
                                    <td align="center">' . $disable . '</td> 
                               </tr>  
                               ';
          }
          ?>

        </table>
      </div>
      <br>
      <a href="pos-utilities_old.php" style="float: left;text-decoration:none;color:#443DFE;font-weight:bold"> <i class="bi bi-chevron-left"></i>&emsp;Go to Old Record</a>
    </section>

  </main>



  <div class="container py-5" style="background-color: white;">

  </div>
</body>

</html>
<script>
  $(document).ready(function() {
    $('#data').DataTable();
  });
</script>