 <?php

    include('../php/config.php');


    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

        $id = $_GET['id'];
        $result = mysqli_query($db, "SELECT jo_tb.jo_id, jo_tb.jo_no, customers.customers_name, employee_tb.emp_name, jo_tb.jo_date 
                                 FROM jo_tb
                                 LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id 
                                 LEFT JOIN employee_tb ON employee_tb.emp_id = jo_tb.emp_id
                                 WHERE jo_id=" . $_GET['id']);

        $row = mysqli_fetch_array($result);

        if ($row) {

            $id = $row['jo_id'];
            $jo_no = $row['jo_no'];
            $customers_name = $row['customers_name'];
            $emp_name = $row['emp_name'];
            $dateString = $row['jo_date'];
            $dateTimeObj = date_create($dateString);
            $date = date_format($dateTimeObj, 'm/d/y');
        } else {
            echo "No results!";
        }
    }

    /* TEST CODE*/

    /* TEST CODE END */
    ?>


 <title><?php echo $jo_no ?></title>
 <style>
     /* table td,
    th {
        border: 1px solid black;


    } */


     body {
         font-family: 'Courier New', Courier, monospace;
     }


     img {
         width: 108mm;
         height: 165mm;
         position: relative;
     }

     .container {
         position: relative;
         text-align: center;
         color: black;
         border: 1px solid black;
         width: 22%;


     }

     .bottom-left {
         position: absolute;
         bottom: 8px;
         left: 16px;
     }

     .ep--customer {
         position: absolute;
         top: 8px;
         left: 0px;
     }

     .ep--customer--address {
         position: absolute;
         top: 8px;
         left: 0px;
     }

     .ep--no {
         position: absolute;
         top: 12px;
         left: 0px;

     }

     .ep--date {
         position: absolute;
         top: 15px;

     }

     .bottom-right {
         position: absolute;
         bottom: 8px;
         right: 16px;
     }

     .centered {
         position: absolute;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
     }

     p {
         font-size: 20px;
         line-height: 2em;
     }

     .ep--itemlist {
         position: absolute;
         top: 14px;
         left: 0px;
     }

     .ep_tb th,
     td {
         padding: 2px;
         /* border: 1px solid black; */
         /* font-size: 12px; */
     }

     .ep_tb {
         /* margin-left: 0px; */
         border-collapse: collapse;

     }



     @media print {
         body {
             font-family: 'Courier New', Courier, monospace;
         }

         .noprint {
             visibility: hidden;
         }
     }

     textarea {
         border: none;
         background-color: transparent;
         resize: none;
         outline: none;
         font-size: 12px;
     }


     input[type=button] {
         background-color: #4CAF50;
         border: none;
         color: white;
         padding: 8px 16px;
         text-decoration: none;
         margin: 4px 2px;
         cursor: pointer;
         font-weight: bolder;
     }
 </style>





 <html>

 <head>
     <script language="javascript">
         function printdiv(printpage) {
             var headstr = "<html><head><title></title></head><body>";
             var footstr = "</body>";
             var newstr = document.all.item(printpage).innerHTML;
             var oldstr = document.body.innerHTML;
             document.body.innerHTML = headstr + newstr + footstr;
             window.print();
             document.body.innerHTML = oldstr;
             return false;
         }
     </script>



 </head>

 <body>

     <div class="container" id="div_print">
         <img src="../img/jotemplate.jpg" class="noprint">

         <div class="ep--no"><br>
             <p style=" margin-right:140px;font-size: 16px;"><?php echo $customers_name ?></p>

         </div>

         <div class="ep--date">
             <p style=" margin-left:350px;font-size: 14px;"><?php echo $date; ?></p>
         </div>


         <div class="ep--itemlist"><br><br><br><br><br><br><br><br><br><br><br>
             <table class="ep_tb" width="100%">


                 <?php
                    include "../php/config.php";
                    $sql = "SELECT product.product_name,jo_product.jo_product_qty,unit_tb.unit_name, jo_product.jo_product_price, jo_product.jo_remarks
                    FROM jo_product 
                    LEFT JOIN product ON product.product_id = jo_product.product_id
                    LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id 
                    WHERE jo_product.jo_id='$id'
                    ";

                    $result = $db->query($sql);
                    $count = 0;
                    if ($result->num_rows >  0) {

                        while ($irow = $result->fetch_assoc()) {
                            $count = $count + 1;
                    ?>
                         <tr valign="top">
                             <td style="text-align: left;"><?php echo $irow['jo_product_qty'] ?><?php echo $irow['unit_name'] ?></td>
                             <td style="width:235px" valign="top"><?php echo $irow['product_name'] ?> <br> <textarea wrap="soft" rows="5" cols="30"> <?php echo $irow['jo_remarks'] ?></textarea>
                             </td>
                             <td style="width:100px">&#8369;&nbsp;<?php echo $irow['jo_product_price'] ?>/<?php echo $irow['unit_name'] ?></td>

                         </tr>
                 <?php }
                    } ?>

             </table>




         </div>


 </body>
 <input name="b_print" type="button" class="noprint" onClick="printdiv('div_print');" value=" Click Here to Print ! ">

 </html>