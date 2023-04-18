<?php

include('../php/config.php');

if (isset($_POST['srr_submit'])) {
    $id = $_POST['id'];
    $srr_no = mysqli_real_escape_string($db, $_POST['srr_no']);
    $emp_id = mysqli_real_escape_string($db, $_POST['emp_id']);
    $srrQty =  $_POST['qty'];
    $srrSup =  $_POST['sup'];
    $srrDate =  $_POST['date'];
    $srrItem = $_POST['item'];
    $srrRef =  $_POST['ref'];


    mysqli_query($db, "UPDATE srr_tb SET srr_no='$srr_no', emp_id='$emp_id'
                       WHERE srr_id='$id'");

    function addSrrProdRecord($srrItem, $id, $srrQty, $srrRef, $srrSup, $srrDate)
    {
        include('../php/config.php');
        mysqli_query($db, "INSERT INTO srr_product(product_id, srr_id, srr_qty, srr_ref, sup_id, srr_date)
        VALUES ('$srrItem', '$id', '$srrQty', '$srrRef', '$srrSup', '$srrDate')");
    }

    $counter = 0;
    while (count($srrItem) !== $counter) {
        $result =  mysqli_query($db, "SELECT * FROM srr_product  WHERE product_id = $srrItem[$counter] AND srr_id = $id");
        $row = mysqli_fetch_assoc($result);
        if (!$row && $srrItem) {
            addSrrProdRecord($srrItem[$counter], $id, $srrQty[$counter], $srrRef[$counter], $srrSup[$counter], $srrDate[$counter]);
        }
        $counter++;
    }

    header("Location:../srr_main.php");
}


if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];
    $result = mysqli_query($db, "SELECT   srr_tb.srr_id, srr_tb.srr_no, employee_tb.emp_name, srr_tb.emp_id
                                FROM srr_tb
                                LEFT JOIN employee_tb ON srr_tb.emp_id = employee_tb.emp_id
                                WHERE srr_tb.srr_id=" . $_GET['id']);

    $row = mysqli_fetch_array($result);

    if ($row) {

        $id = $row['srr_id'];
        $srr_no = $row['srr_no'];
        $emp_id = $row['emp_id'];
    } else {
        echo "No results!";
    }
}
?>


<head>
    <title>PACC IMS</title>
    <link rel="shortcut icon" href="../img/pacclogo.png" />
    <link rel="stylesheet" href="../css/srr_edit.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<body style="margin: 0px;" bgcolor="#B0C4DE">

    <div class="container">
        <a href="../srr_main.php" style="float: right;"><i class="fa fa-close" style="font-size:24px; color: red;"></i></a><br>
        <fieldset>
            <legend>&nbsp;&nbsp;&nbsp;Stock Reciept Register: Editing Record&nbsp;&nbsp;&nbsp;</legend>
            <button id="myBtn" title="Add Entry" style="font-size: 18px; padding: 8px; float:right;"><i class="fa fa-plus-circle"></i>&nbsp;Add Entry</button>
            <form autocomplete="off" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />

                <table class="table1" width="100%">
                    <tr>
                        <td style="width: 20%;"><b>
                                <font color='midnightblue'>Srr No:</font>
                            </b>
                            <input type="text" class="form-control" name="srr_no" value="<?php echo $_GET['srrNo'] ?>" style="height: 30px;">
                        </td>

                        <td style="width: 30%;"><b>
                                <font color='midnightblue'>Prepared By:</font>
                            </b>
                            <select name="emp_id" class="select--emp" style="height: 30px;">
                                <option value="<?php echo $_GET['empId'] ?>"><?php echo $_GET['empName']; ?></option>
                                <?php
                                $records = mysqli_query($db, "SELECT * FROM employee_tb ");

                                while ($data = mysqli_fetch_array($records)) {
                                    echo "<option value='" . $data['emp_id'] . "'>" . $data['emp_name'] . "</option>";
                                }
                                ?>

                            </select>
                        </td>
                        <td style="width: 30%;"></td>

                    </tr>

                </table>

                <br>
                <table width="100%" class="itemtb">
                    <tr>
                        <th width="10%">DATE</th>
                        <th width="30%">SUPPLIER</th>
                        <th width="10%">REF NO.</th>
                        <th width="20%">DESCRIPTION</th>
                        <th width="5%">QTY</th>
                        <th width="10%">UNIT</th>
                        <th width="10%">Remarks</th>
                        <th width="10%"></th>
                    </tr>
                    <tr>
                        <?php
                        $ids = $_GET['id'];
                        $sql = "SELECT  srr_product.sup_id, sup_tb.sup_name, srr_product.srr_date, sup_tb.sup_name, srr_product.srr_ref, product.product_name, srr_product.srr_qty, unit_tb.unit_name, product.pro_remarks, product.unit_id, product.product_id, srr_product.srr_id

   				 FROM srr_product
   				 LEFT JOIN sup_tb ON srr_product.sup_id = sup_tb.sup_id
   				 LEFT JOIN product ON srr_product.product_id = product.product_id
   				 LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
   				 WHERE srr_product.srr_id= $ids
                 ORDER BY sup_tb.sup_name ASC";


                        $result = $db->query($sql);
                        $count = 0;
                        if ($result->num_rows >  0) {

                            while ($irow = $result->fetch_assoc()) {
                                $count = $count + 1;
                        ?>
                                <td><?php echo $irow['srr_date']; ?> <input type="hidden" name="date[]" value="<?php echo $irow['srr_date']; ?>"></td>
                                <td><?php echo $irow['sup_name']; ?><input type="hidden" name="sup[]" value="<?php echo $irow['sup_id']; ?>"></td>
                                <td><?php echo $irow['srr_ref']; ?><input type="hidden" name="ref[]" value="<?php echo $irow['srr_ref']; ?>"></td>
                                <td><?php echo $irow['product_name']; ?><input type="hidden" name="item[]" value="<?php echo $irow['product_id']; ?>"></td>
                                <td><?php echo $irow['srr_qty']; ?><input type="hidden" name="qty[]" value="<?php echo $irow['srr_qty']; ?>"></td>
                                <td><?php echo $irow['unit_name']; ?><input type="hidden" name="unit[]" value="<?php echo $irow['unit_id']; ?>"></td>
                                <td><?php echo $irow['pro_remarks']; ?><input type="hidden" name="remarks[]" value="<?php echo $irow['pro_remarks']; ?>"></td>

                                <td>
                                    <center>
                                        <!-- &srrId=<?php echo $irow['srr_id']; ?> -->
                                        <a href="item_delete/srr_item_delete.php?id=<?php echo $irow['product_id']; ?>">
                                            <font color="red"><i class="fa fa-trash-o" style="font-size:24px" title="Remove Item"></i></font>
                                        </a>
                                    </center>
                                </td>


                    </tr>
            <?php }
                        } ?>
                </table>
                <br>
                <button class="butLink" name="srr_submit" onclick="alert('Edit Records Successfully !')">Update</button>
            </form>
            <br>
        </fieldset>
        <!-- EDIT PO END -->
    </div>



    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" title="close">&times;</span><br>
            </div>
            <div class="modal-body">
                <div class="addCont">
                    <label>Description:&nbsp;&nbsp;</label>
                    <div id="search">
                        <input autocomplete="off" type="text" name="item" id="item-name" style="height: 30px;" placeholder=" 🔍 Search item here ......." />
                        <div id="item-list">
                            <ul class='container--item__list'>
                            </ul>
                        </div><!-- Dont Remove this -->
                    </div>
                    <br>
                    <!-- input for item qty -->
                    <label>Quantity: &nbsp;&nbsp;&nbsp;&nbsp;</label><br>
                    <input name="srr_qty" class="item-qty" type="number" placeholder="Quantity" value="1" />

                    <!-- input for refno -->
                    <br><br>
                    <label>Reference No.&nbsp;&nbsp;&nbsp;&nbsp;</label><br>
                    <input autocomplete="off" name="srr_ref" class="item-ref" type="text" style="height: 30px;" />
                    <br /><br />
                    <!-- input for supplier -->
                    <label>Supplier: &nbsp;&nbsp;</label><br>
                    <select name="sup_id" class="item-sup" style="width:auto; height: 26px; height: 30px;">
                        <option></option>
                        <?php
                        include "../../php/config.php";
                        $records = mysqli_query($db, "SELECT * FROM sup_tb ORDER BY sup_name ASC");

                        while ($data = mysqli_fetch_array($records)) {
                            echo "<option value='" . $data['sup_id'] . "'>" . $data['sup_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <br><br>
                    <!-- input for date -->
                    <label>Date&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input name="srr_date" class="item-date" type="date" style="height: 30px;" /> <br><br>
                    <br>
                    <button class="add-button" title="Add Item"><i class="fa fa-plus"></i>&nbsp; Add</button>
                </div>
            </div>
        </div>

    </div>

    </div>




    <script>
        'use strict';

        const selectedItem = {};
        // Get the modal
        const modal = document.getElementById("myModal");

        // Get the button that opens the modal
        const btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        const span = document.getElementsByClassName("close")[0];

        const inputSearch = document.querySelector('#item-name');
        const inputItemQty = document.querySelector('.item-qty');
        const inputItemRef = document.querySelector('.item-ref');
        const inputItemSup = document.querySelector('.item-sup');
        const containerItemList = document.querySelector('#item-list');
        const buttonAddItem = document.querySelector('.add-button');
        const containerItemRow = document.querySelector('.itemtb');
        const inputItemDate = document.querySelector('.item-date');
        const itemList = document.querySelector('.container--item__list');

        const getData = function(data) {
            return;
        }



        const addItemRow = function(e) {
            console.log(e.target);
            containerItemRow.insertAdjacentHTML('beforeend', `<tr>
                                <td>${inputItemDate.value} <input type="hidden" name="date[]" value="${inputItemDate.value}" ></td>
                                <td>${inputItemSup.selectedOptions[0].outerText} <input type="hidden" name="sup[]" value="${inputItemSup.value}" ></td>
                                <td>${inputItemRef.value} <input type="hidden" name="ref[]" value="${inputItemRef.value}" ></td>
                                <td>${inputSearch.value}<input type="hidden" name="item[]" value="${selectedItem.id}" ></td>
                                <td>${inputItemQty.value}<input type="hidden" name="qty[]" value="${inputItemQty.value}" ></td>
                                <td>${selectedItem.unit}<input type="hidden" name="unit[]" value="${selectedItem.unitId}" ></td>
                                <td>${selectedItem.remarks}<input type="hidden" name="remarks[]" value="${selectedItem.remarks}" ></td>
                                <td><center><a href="item_delete/stin_item_delete.php?stinProdId=<?php echo $irow["stin_product_id"] ?>" title="Remove">
                        <font color=" red"><i class="fa fa-trash-o" style="font-size:24px"></i></font>
                      </a></center></td>
                                </tr>`);

            modal.style.display = 'none';

        };

        const selectItem = function(e) {
            const target = e.target.closest('li')
            selectedItem.id = target.dataset.product;
            selectedItem.unitId = target.dataset.unit_id;
            selectedItem.qty = target.dataset.qty;
            selectedItem.unit = target.dataset.unit;
            selectedItem.remarks = target.dataset.remarks;
            inputSearch.value = target.innerHTML;
        };

        const itemSearch = function() {
            const item = this.value;
            itemList.innerHTML = "";
            // Create an XMLHttpRequest object
            const search = new XMLHttpRequest();


            // Define a callback function
            search.addEventListener('load', function() {
                const data = JSON.parse(this.responseText);
                // showTableData(data, container);

                data.forEach(data => {
                    itemList.insertAdjacentHTML('beforeend', `<li 
                    data-product='${data.product_id}' 
                    data-qty='${data.qty}' 
                    data-unit='${data.unit_name}' 
                    data-unit_id='${data.unit_id}' 
                    data-remarks='${data.pro_remarks}'>${data.product_name}</li>`);
                });

            });

            // Send a request
            search.open("POST", "../php/searchitem.php" + `?q=${item}`);
            search.send();
        };


        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // // When the user clicks anywhere outside of the modal, close it
        // window.onclick = function(event) {
        //     if (event.target == modal) {
        //         modal.style.display = "none";
        //     }
        // }


        inputSearch.addEventListener('keyup', itemSearch.bind(inputSearch));

        inputSearch.addEventListener('focus', function() {
            containerItemList.classList.toggle('active');
        });

        inputSearch.addEventListener('blur', function() {
            setTimeout(function() {
                containerItemList.classList.toggle('active')
            }, 100);
        });

        containerItemList.children[0].addEventListener('click', selectItem);

        buttonAddItem.addEventListener('click', addItemRow);
    </script>



</body>