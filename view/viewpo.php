<?php

include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

  $id = $_GET['id'];

  $result = mysqli_query($db, "SELECT po_tb.po_code, po_tb.po_title, po_tb.po_date, po_tb.po_remarks, po_tb.po_terms, sup_tb.sup_id, po_tb.po_id, sup_tb.sup_name, sup_tb.sup_address,sup_tb.sup_tel, sup_tb.sup_tin FROM sup_tb INNER JOIN po_tb ON sup_tb.sup_id = po_tb.sup_id  WHERE po_id=" . $_GET['id']);


  $row = mysqli_fetch_array($result);

  if ($row) {
    $id = $row['po_id'];
    $po_code = $row['po_code'];
    $po_title = $row['po_title'];
    $po_remarks = $row['po_remarks'];
    $po_terms = $row['po_terms'];
    $sup_name = $row['sup_name'];
    $sup_address = $row['sup_address'];
    $sup_tel = $row['sup_tel'];
    $sup_tin = $row['sup_tin'];
    $dateString = $row['po_date'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');
  } else {
    echo "No results!";
  }
}
?>
<html>
<title><?php echo $po_code; ?></title>

<head>
  <link rel="stylesheet" href="../css/viewpo.css" type="text/css" media="print">
  <link rel="stylesheet" href="../css/viewpo.css" type="text/css">
</head>
<script>
  function printDiv() {
    var divContents = document.getElementById("print-area").innerHTML;
    var a = window.open('', '', 'height=1000, width=1300');
    a.document.write(divContents);
    a.document.close();
    a.print();
  }
</script>

<body>
  <div class="print-area">
    <page id="print" size="A4">
      <div class="top">
        <table width="100%">
          <tr>
            <td>
              <font color="midnightblue"><img src="../img/pacclogo.png" height="65px" width="65px" style="float:left">
            </td>
            <td style="text-align: center;">
              <font style="font-size: 25px; letter-spacing: 4px;">Philippine Acrylic & Chemical Corporation</font><br>
              <center>
                <font style="font-size: 20px; letter-spacing: 3px;"> 635 Mercedes Ave. San Miguel, Pasig City</font><br>
                <font style="font-size: 15px; letter-spacing: 3px;">Tel. Nos.<input type="text" style="border: none; width: 80px;" value="8330-8847">&nbsp;<input type="text" style="border: none; width: 80px;" value="7501-6844">&nbsp;<input type="text" style="border: none; width: 100px;" value="+63922838116"></font>
              </center>
            </td>
          </tr>
        </table>
        <hr>
        </center>
      </div>


      <div class="suptab">
        <!-- <table width="100%">
          <tr>
            <td>
              <h4 style="text-align: left; margin-right:20px;"><label></label> <?php echo $po_code; ?></h4>
            </td>
            <td>
              <h4 style="text-align: right; margin-right:20px;">Date: <?php echo $po_date; ?></h4>
            </td>
          </tr>
        </table> -->




        <fieldset>
          <!-- <legend style="letter-spacing: 3px; font-weight: bolder;">&nbsp;Supplier Information &nbsp;&nbsp;&nbsp;</legend> -->
          <table width="100%">
            <tr>
              <td style="font-size: 18px;letter-spacing:2px;"><label> Purchase Order :</label>
                <b><?php echo $po_code; ?></b>
              </td>

            </tr>
            <tr>
              <td style="font-size: 13px "><label> Supplier :</label>
                <?php echo $sup_name; ?>
              </td>
              <td style="font-size: 13px; letter-spacing:1px "><label> Date :</label>
                <?php echo $date; ?></td>
            </tr>
            <tr>
              <td style="font-size: 13px "><label> Addres :</label><?php echo $sup_address; ?></td>
              <td style="font-size: 13px "><label> Contact :</label> <?php echo $sup_tel; ?></td>
            </tr>
            <tr>
              <td style="font-size: 13px "><label>TIN :</label><?php echo $sup_tin; ?></td>
              <td style="font-size: 13px "><label>Terms :</label><?php echo $po_terms; ?></td>
            </tr>
          </table>
        </fieldset>
      </div>
      <div class="itemTB">
        <table class="ordertable">
          <tr>
            <th width="25%">Product Name</th>
            <th width="10%">Qty Order</th>
            <th width="5%">Unit</th>
            <th width="10%">Cost</th>
            <th width="10%">Total Cost</th>
            <th width="10%"> %Discount</th>
            <th width="15%">Disc. Amount</th>
            <th width="10%">Sub Total</th>
          </tr>
          <?php
          $sql = "SELECT product.product_name, po_product.item_qtyorder, unit_tb.unit_name, product.cost, po_product.item_disamount, po_product.item_cost, po_product.item_discpercent
                                  FROM product
                                  LEFT JOIN po_product
                                  ON product.product_id = po_product.product_id
                                  LEFT JOIN unit_tb
                                  ON product.unit_id = unit_tb.unit_id
                                  WHERE po_product.po_id = '$id' ";

          $result = $db->query($sql);
          $count = 0;
          if ($result->num_rows >  0) {
            while ($irow = $result->fetch_assoc()) {
              $count = $count + 1;

              $total[] = $irow["item_qtyorder"] * $irow["item_cost"];

              $totaldisamount[] =  $irow["item_disamount"];

          ?>
              <tr>
                <td><?php echo $irow['product_name'] ?></td>
                <td><?php echo $irow['item_qtyorder'] ?></td>
                <td><?php echo $irow['unit_name'] ?></td>
                <td><?php echo number_format($irow['item_cost'], 2)  ?></td>
                <td class="item_totcost"> <?php echo number_format($irow["item_qtyorder"] * $irow["item_cost"], 2); ?></td>
                <td><?php echo number_format($irow['item_discpercent'], 2)  ?></td>
                <td><?php echo number_format($irow['item_disamount'], 2)  ?></td>
                <td class="po_temp_tot"><?php echo number_format($irow["item_qtyorder"] * $irow["item_cost"] - $irow["item_disamount"], 2); ?></td>
              </tr>
              <input type="hidden" name="product_id[]" value="<?php echo $irow['product_id'] ?>">
          <?php }
          } ?>
        </table><br><br><br><br>
        <div class="subtot">
          <table>
            <?php

            $limit = 0;
            $subTot = 0;
            $disTot = 0;

            while ($limit != count($total)) {
              $subTot += $total[$limit];
              $disTot += $totaldisamount[$limit];
              $limit += 1;
            }

            $grandTot = $subTot - $disTot;

            ?>
            <tr>
              <td><label class="totDiv"> Sub Total:</label>&nbsp;&#8369;<?php echo number_format($subTot, 2); ?></td>
            </tr>

            <tr>
              <td><label class="totDiv"> Total Discount:</label>&nbsp;&#8369;<?php echo number_format($disTot, 2)  ?></td>
            </tr>
            <tr>
              <td><label class="totDivGrand"> Grand Total:&nbsp;<u> &#8369;<?php echo number_format($grandTot, 2)  ?></u></label></td>
            </tr>
          </table>
          <br><br>
        </div>
        <br><br>
      </div>

      <table class="emptab">
        <tr>
          <td>______________ <br>&nbsp;&nbsp;&nbsp;&nbsp;Prepared by</td>
          <td>______________<br>&nbsp;&nbsp;&nbsp;&nbsp;Approved by</td>
        </tr>
      </table>
    </page>
  </div>
</body>


</html>