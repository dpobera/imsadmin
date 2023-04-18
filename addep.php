<?php include 'header.php';
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include 'php/config.php';

$query = $db->query("SELECT ep_no FROM ep_tb ORDER BY ep_id DESC LIMIT 1");

if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $code = $row["ep_no"];
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
        $(".newEpId").load("addrecord/orderid/auto-order-id-ep.php");

        //Get latest order ID
        $.get("stoutlatest-id.php", function(data) {
            $('.newEpId').html(data);
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
            var price = $(".item-price").val();
            var remarks = $(".item-remarks").val();
            if (addOrder(id)) {
                $.get(
                    "addrecord/addrow/add-item-row-ep.php", {
                        id: id,
                        qty: qty,
                        price: price,
                        remarks: remarks,
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
                            $(".item-price").val(0);
                            $(".item-remarks").val("");
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
                <h1 class="h2 text-secondary font-monospace">EXITPASS / Add New Record</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
                        <div class="btnAdd">

                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 shadow-sm bg-light" style="background-color:#ededed;border:1px solid lightgrey;height:75vh">
                <form autocomplete="off" method="POST" action="addrecord/itemInsert/epInsert.php">
                    <div class="row mt-3 mb-2">
                        <div class="col-5">
                            <div class="row">
                                <div class="col">&nbsp;EP ID : <span class="newEpId"></span></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="col">
                                        <p class="text-secondary"> LAST EP No.: <strong><i><?php echo $code ?></i></strong> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="floatingInput" type="text" name="ep_no" required>
                                        <label for="floatingInput">Exitpass No.</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="floatingInput" type="text" name="ep_title">
                                        <label for="floatingInput">Job-Order No.</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="floatingInput" type="date" name="ep_date" required>
                                        <label for="floatingInput">Exitpass Date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="ep_remarks" id="floatingTextarea"></textarea>
                                        <label for="floatingTextarea">Exitpass Remarks</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="customers_id">
                                            <option></option>
                                            <?php
                                            include "../../php/config.php";
                                            $records = mysqli_query($db, "SELECT * FROM customers ORDER BY customers_name ASC");

                                            while ($data = mysqli_fetch_array($records)) {
                                                echo "<option value='" . $data['customers_id'] . "'>" . $data['customers_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Customer Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mt-3">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="emp_id">
                                            <option></option>
                                            <?php
                                            include "../../php/config.php";
                                            $records = mysqli_query($db, "SELECT * FROM employee_tb ORDER BY emp_name ASC");

                                            while ($data = mysqli_fetch_array($records)) {
                                                echo "<option value='" . $data['emp_id'] . "'>" . $data['emp_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Prepared By</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-7" style="margin-top: 9vh;">
                            <div id="search">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control mt-2" id="item-name" name="item">
                                    <label for="floatingInput">Search Item <i class="bi bi-search"></i></label>
                                    <div id="item-list"></div><!-- Dont Remove this -->
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control item-qty" id="floatingInput" value="1">
                                            <label for="floatingInput">Quantity</label>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control item-price" id="floatingInput" value="0">
                                            <label for="floatingInput">Price</label>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <button type="button" class="btn btn-secondary add-button mt-1 bg-gradient" style="width: 100%;height:50px"><i class="bi bi-building-fill-down"></i></button>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    <br>
                    <div class="item_table">
                        <div class="table-responsive" style="height:33vh;background-color:white;border:1px solid lightgrey">
                            <table id="crud_table" class="postb table table-sm table-hover">
                                <thead class="bg-light">
                                    <tr class='item_table--thead'>
                                        <th width="50%">
                                            &emsp; Item Description
                                        </th>
                                        <th width="10%">
                                            Quantity
                                        </th>
                                        <th width="10%">Price</th>

                                        <th width="10%">
                                            Total Amount
                                        </th>

                                        <th width="10%">
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="container--edit__button" style="margin-top: 2vh;margin-bottom: 2vh;z-index:50">
                        <button class="btn btn-secondary bg-gradient" name="btnsave">Save Records</button>
                        <a href="ep-index.php"> <button type="button" class="btn btn-secondary  bg-gradient">Cancel</button></a>
                    </div>
                </form>
            </div>

        </main>

        <!-- end of content -->

        </body>
        <?php include "footer.php"; ?>

        </html>