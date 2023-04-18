<?php include 'header.php';
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include 'php/config.php';

$query = $db->query("SELECT po_code FROM po_tb ORDER BY po_id DESC LIMIT 1");

if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $code2 = $row["po_code"] + 1;
    }
}

?>
<link rel="stylesheet" href="css/jo_add-style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
    //Jquery codes
    $(document).ready(function() {
        const orders = []; // array for all the product id in the table

        //function that check the product id to be added
        //return true if has duplicate and false if no duplicate
        const checkDuplicate = (productId) => {
            //Check the value of product id
            if ($("#product" + productId).length == 0) {
                console.log("No duplicate");
                return 0;
            } else {
                alert("Item already exist");
                return 1;
            }
        };

        const addOrder = (productId) => {
            console.log(`Product ID: ${productId}`);
            //Check orders if empty
            if (orders.length == 0) {
                orders.push(productId);
                return true;
            } else if (checkDuplicate(productId)) {
                //Clear Item on click
                $("#item-name").click(function() {
                    $(this).val("");
                });
            } else {
                orders.push(productId);
                return true;
            }
        };

        //Delete button for table rows
        $("#crud_table").on("click", ".delete", function() {
            $(this).closest("tr").remove();
        });

        // //Auto incrementing Order-ID
        $(".newpoId").load("addrecord/orderid/auto-order-id-po.php");

        // //Auto incrementing Order-ID
        $(".newOrderIdPo").load("addrecord/orderid/auto-order-id-po_add.php");

        //Get latest order ID
        $.get("polatest-id.php", function(data) {
            $('.newpoId').html(data);
        });

        //Search Items on Database
        $("#item-name").keyup(function() {
            var query = $(this).val();
            if (query != "") {
                $.ajax({
                    url: "addrecord/search.php",
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $("#item-list").fadeIn();
                        $("#item-list").html(data);
                    },
                });
            } else {
                $("#item-list").fadeOut();
            }
        });

        //Choose data on mouse click
        $(document).on("click", "li", function() {
            $(this).addClass("selected"); //add selected class on clicked list
            $("li").each(function(i) {
                var elementText = $(".selected")
                    .clone()
                    .children()
                    .remove()
                    .end()
                    .text();
                $("#item-name").val(elementText); //retain value to input box
            }); //function for getting only the parent text

            $("#item-list").fadeOut(); // close the item list suggestion
        });

        //Adds table row based on INPUT VALUE//
        $(".add-button").click(function() {
            var id = $("li.selected p").text(); //gets the value id
            var qty = $(".item-qty").val();
            var cost = $(".item-cost").val();
            var discount = $(".item-discount").val();
            if (addOrder(id)) {
                $.get(
                    "addrecord/addrow/add-item-row-po.php", {
                        id: id,
                        qty: qty,
                        cost: cost,
                        discount: discount,
                    },
                    function(data, status) {
                        var noResult = "0 results";

                        if (data == noResult) {
                            alert("No ID matches.");

                            //Clear Item on click
                            $("#item-name").click(function() {
                                $(this).val("");
                            });
                        } else {
                            //add table row with data
                            $(".postb").append(data);

                            //clear form
                            $("#item-name").val("");
                            $(".item-qty").val(1);
                            $(".item-cost").val(0);
                            $(".item-discount").val(0);
                            $("li.selected").removeClass("selected");
                        }
                    }
                );
                console.log(orders);
            }
        });
    });
</script>


<!-- content -->
<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
                <h1 class="h2 text-secondary font-monospace">PURCHASE ORDER / Add New Record</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
                        <div class="btnAdd">

                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 shadow-sm bg-light" style="background-color:#ededed;border:1px solid lightgrey;height:75vh">
                <form autocomplete="off" method="POST" action="addrecord/itemInsert/poInsert.php">
                    <div class="row mt-2 mb-2">
                        <div class=" col-5">

                            <div class="row mt-3 mb-2">
                                <div class="col text-secondary">&nbsp;Purchase-Order ID : <span class="newpoId"></span></div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="po_code" value="<?php echo $code2 ?>" readonly>
                                        <label for="floatingInput">Purchase-Order Code</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="po_title" required>
                                        <label for="floatingInput">Purchase-Order Title</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="ref_num" required>
                                        <label for="floatingInput">Reference No.</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="floatingInput" name="po_date" required>
                                        <label for="floatingInput">Purchase-Order Date</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="floatingTextarea" name="po_remarks"></textarea>
                                        <label for="floatingTextarea">Purchase-Order Remarks</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="sup_id" required>
                                            <option></option>
                                            <?php
                                            include "../../php/config.php";
                                            $records = mysqli_query($db, "SELECT sup_id,sup_name From sup_tb ORDER BY sup_name ASC");

                                            while ($data = mysqli_fetch_array($records)) {
                                                echo "<option value='" . $data['sup_id'] . "'>" . $data['sup_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Supplier</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-7" style="margin-top: 2vh;">
                            <div class="row mt-2">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="floatingInput" name="po_terms">
                                        <label for="floatingInput">Terms</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select shadow-sm" id="floatingSelect" aria-label="Floating label select example" name="po_type_id" required>
                                            <option></option>
                                            <?php
                                            include "../../php/config.php";
                                            $records = mysqli_query($db, "SELECT * FROM po_type ORDER BY po_type_id ASC");

                                            while ($data = mysqli_fetch_array($records)) {
                                                echo "<option value='" . $data['po_type_id'] . "'>" . $data['po_type_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Purchase-Order Type</label>
                                    </div>
                                </div>
                            </div>
                            <div id="search" class="bg-light bg-gradient p-2 shadow-sm" style="border:1px solid lightgrey;">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control mt-2" id="item-name" name="item">
                                    <label for="floatingInput">Search Item <i class="bi bi-search"></i></label>
                                    <div id="item-list"></div><!-- Dont Remove this -->
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control item-qty" id="floatingInput" value="1">
                                            <label for="floatingInput">Quantity</label>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control item-cost" id="floatingInput" value="0">
                                            <label for="floatingInput">Cost</label>
                                        </div>
                                    </div>
                                    <label style="display: none;">Discount: &nbsp;&nbsp;</label>
                                    <input style="display: none;" class=" item-discount" type="number" placeholder="Discount" value="0" />
                                    <div class="col-2">
                                        <button type="button" class="btn btn-secondary add-button bg-gradient mt-1" style="width: 100%;height:50px"><i class="bi bi-building-fill-down"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="item_table">
                        <div class="table-responsive shadow-sm" style="height:33vh;background-color:white;border:1px solid lightgrey">
                            <table id="crud_table" class="postb table table-sm table-hover ">
                                <thead class="bg-light">
                                    <tr class='item_table--thead'>
                                        <th width="50%">
                                            &emsp;Item Description
                                        </th>
                                        <th width="10%">
                                            Qty-Order
                                        </th>
                                        <th width="10%">Cost</th>
                                        <th width="10%">
                                            Dis Amount
                                        </th>
                                        <th width="10%">
                                            Total Amount
                                        </th>
                                        <th width="5%">
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="container--edit__button" style="margin-top: 2vh;margin-bottom: 2vh;z-index:50">
                        <button class="btn btn-secondary bg-gradient" name="btnsave">Save Records</button>
                        <a href="po-index.php"> <button type="button" class="btn btn-secondary bg-gradient">Cancel</button></a>
                    </div>
                </form>
            </div>

        </main>

        <!-- end of content -->

        </body>
        <?php include "footer.php"; ?>

        </html>