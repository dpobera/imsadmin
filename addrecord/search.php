<?php


$connect = mysqli_connect("localhost", "root", "", "inventorymanagement");
if (isset($_GET["query"])) {
    $output = '';  //Output Initialization
    $query = "SELECT product.product_name, product.product_id, loc_tb.loc_name, product.barcode, product.qty, loc_tb.loc_name,product.pro_remarks,unit_tb.unit_name
                FROM product
                LEFT JOIN loc_tb ON loc_tb.loc_id = product.loc_id
                LEFT JOIN unit_tb ON unit_tb.unit_id = product.unit_id
                WHERE product_name LIKE '%" . $_GET["query"] . "%' LIMIT 300";  //Select Items

    $result = mysqli_query($connect, $query);
    $output = '<ul class="responsive-table">
 <li class="table-header">
                        <div class="col col-1">ID</div>
                        <div class="col col-2">Product</div>
                        <div class="col col-3">Location</div>
                        <div class="col col-4">Barcode</div>
                        <div class="col col-5">Remarks</div>
                        <div class="col col-6" style="text-align:right">QTY</div>
                        <div class="col col-7">Unit</div>
                    </li>';  //Add <ul> tag to output
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) //Keep adding List Items while there is a result
        {
            $output .= '
            <li class="table-row">
                <div class="col col-1">'
                . str_pad($row['product_id'], 8, 0, STR_PAD_LEFT)  .
                "</div>

                <div class='col col-2'>"
                . $row["product_name"] .
                "</div>
                
                <div class='col col-3'>"
                . $row['loc_name'] .
                "</div>

                <div class='col col-4'>"
                . $row['barcode'] .
                "</div>

                <div class='col col-5'>"
                . $row['pro_remarks'] .
                "</div>" . "
                <div class='col col-6' style='text-align:right'>"
                . number_format($row['qty'], 2)  .
                "</div>" .
                "
                <div class='col col-7'>"
                . $row['unit_name']  .
                "</div>" .

                '<p class="hidden">' . $row['product_id'] . '</p>' . '</li>';
        }
    } else {
        $output .= '<li><div class="alert alert-danger" role="alert" style="width:100%;text-align:center;">
       NO RECORD FOUND !
      </div></li>';
    }
    $output .= '</ul>';  //Closing tag for output
    echo $output;
}
