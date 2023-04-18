<?php

// connect to the database
include "../php/config.php";
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


// Add item
if (isset($_GET['add'])) {
    // receive all input values from the form
    echo "connect";
    $product_name = mysqli_real_escape_string($db, $_GET['product_name']);
    $class_id = mysqli_real_escape_string($db, $_GET['class_id']);
    $qty = mysqli_real_escape_string($db, $_GET['qty']);
    $unit_id = mysqli_real_escape_string($db, $_GET['unit_id']);
    $pro_remarks = mysqli_real_escape_string($db, $_GET['pro_remarks']);
    $location = mysqli_real_escape_string($db, $_GET['loc_id']);
    $barcode = mysqli_real_escape_string($db, $_GET['barcode']);
    $price = mysqli_real_escape_string($db, $_GET['price']);
    $cost = mysqli_real_escape_string($db, $_GET['cost']);
    $dept_id = mysqli_real_escape_string($db, $_GET['dept_id']);
    $sup_id = mysqli_real_escape_string($db, $_GET['sup_id']);
    $product_type_id = mysqli_real_escape_string($db, $_GET['product_type_id']);




    $query = "INSERT INTO product (product_name,class_id,qty,unit_id,pro_remarks,loc_id,barcode,price,cost,dept_id,sup_id,product_type_id) 
  			  VALUES('$product_name','$class_id','$qty','$unit_id','$pro_remarks','$location','$barcode','$price','$cost','$dept_id','$sup_id','$product_type_id')";


    if (mysqli_query($db, $query)) {
        $last_id = mysqli_insert_id($db);

        // product_id	bal_qty	in_qty	out_qty	mov_type_id	move_ref	mov_date	

        mysqli_query($db, "INSERT INTO move_product (product_id, bal_qty, in_qty, out_qty, mov_type_id, move_ref, mov_date)
    VALUES('$last_id', '$qty', '$qty', '0', '5', 'Beginning','" . date('Y-m-d') . "')");

        echo date('Y-m-d');
    } else {
        echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }

    echo "<script>alert('New Record Added')</script>";
    echo "<script>window.close();</script>";
}
?>

<html>

<head>
    <title>Add New Item</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        body {
            font-family: sans-serif;
            background-color: #EAEAEA;
            padding: 100px;
            margin: 0;

        }

        .container {
            width: 100%;
            height: 500px;
            padding: 30px;
        }

        label {
            color: black
        }

        a {
            color: midnightblue;
            text-decoration: none;
        }

        .itemlist {
            border-collapse: collapse;
            padding-bottom: 10px;
        }

        .itemlist th {
            border: 2px solid lightgrey;
            text-align: left;
            padding: 10px;
            font-size: 18px;
            color: white;
            background-color: midnightblue;
        }

        .itemlist td {
            border: 1px solid lightgray;
            padding: 10px;
        }

        em {
            color: red;

        }

        .button {
            background-color: midnightblue;
            color: white;
            padding: 7px 12px;
            letter-spacing: 3px;
        }

        .button:hover {
            background-color: white;
            color: midnightblue;
            cursor: pointer;
        }

        .buttonClose {
            background-color: midnightblue;
            color: white;
            padding: 7px 12px;
            letter-spacing: 3px;


        }

        .buttonClose:hover {
            background-color: red;
            color: white;

            cursor: pointer;
        }

        .buttons {
            float: right;
        }
    </style>
</head>

<body>



    <h2>ITEMLIST : ENTERING RECORD</h2>
    <hr style=" border: 0;height: 1px;background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));">
    <form method="GET" autocomplete="off">

        <table width="100%">
            <tr>
                <th style="text-align: left;" width="30%">Item Description&nbsp;<i style="color: red;">*</i></th>
                <th style="text-align: left;" width="30%">Item Type</th>
                <th style="text-align: left;" width="40%"></th>

            </tr>
            <tr>
                <td> <input type="text" name="product_name" style=" width:460px;border: 1px solid gray; height: 36px; border-radius: 5px;" required></td>

                <td style="text-align: left;">
                    <select name="product_type_id" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;" required>
                        <option></option>
                        <?php
                        include "config.php";
                        $records = mysqli_query($db, "SELECT * FROM product_type ORDER BY product_type_id ASC");

                        while ($data = mysqli_fetch_array($records)) {
                            echo "<option value='" . $data['product_type_id'] . "'>" . $data['product_type_name'] . "</option>";
                        }
                        ?>
                    </select>

                </td>
                <td></td>
            </tr>
        </table>

        <br>
        <table width="100%">
            <tr>
                <th style="text-align: left;">Quantity &nbsp;<i style="color: red;">*</i></th>
                <th style="text-align: left;">Unit &nbsp;<i style="color: red;">*</i></th>
                <th style="text-align: left;">Barcode</th>

            </tr>
            <tr>
                <td><input required="number" type="number" name="qty" onchange="setDecimal" min="0" max="9999999999" step="0.0000001" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;" value="0"></td>
                <td><select name="unit_id" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;">
                        <option></option>
                        <?php

                        $records = mysqli_query($db, "SELECT * FROM unit_tb");

                        while ($data = mysqli_fetch_array($records)) {
                            echo "<option value='" . $data['unit_id'] . "'>" . $data['unit_name'] . "</option>";
                        }
                        ?>
                    </select></td>
                <td><input type="text" name="barcode" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;"></td>

            </tr>
        </table>
        <br>
        <tr>
            <table width="100%">
                <th style="text-align: left;">Class &nbsp; <i style="color: red;">*</i></i></th>
                <th style="text-align: left;">Department &nbsp;<i style="color: red;">*</i></i></th>
                <th style="text-align: left;">Location &nbsp;<i style="color: red;">*</i></i></th>
        </tr>
        <tr>
            <td><select name="class_id" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;">
                    <option></option>
                    <?php

                    $records = mysqli_query($db, "SELECT * FROM class_tb");

                    while ($data = mysqli_fetch_array($records)) {
                        echo "<option value='" . $data['class_id'] . "'>" . $data['class_name'] . "</option>";
                    }
                    ?>
                </select></td>
            <td><select name="dept_id" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;">
                    <option></option>
                    <?php

                    $records = mysqli_query($db, "SELECT * FROM dept_tb");

                    while ($data = mysqli_fetch_array($records)) {
                        echo "<option value='" . $data['dept_id'] . "'>" . $data['dept_name'] . "</option>";
                    }
                    ?>
                </select></td>
            <td><select name="loc_id" id="select-state" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;">
                    <option value=""></option>
                    <?php

                    $records = mysqli_query($db, "SELECT * FROM loc_tb");

                    while ($data = mysqli_fetch_array($records)) {
                        echo "<option value='" . $data['loc_id'] . "'>" . $data['loc_name'] . "</option>";
                    }
                    ?>
                </select>
                <script>
                    $(document).ready(function() {
                        $('select').selectize({
                            sortField: 'text'
                        });
                    });
                </script>
            </td>
        </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <th style="text-align: left;">Price</th>
                <th style="text-align: left;">Cost</th>
                <th style="text-align: left;">Remarks</th>
            </tr>
            <tr>
                <td><input type="number" name="price" onchange="setTwoNumberDecimal" min="0" max="9999999" step="any" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;" value="0"></td>
                <td><input type="number" name="cost" onchange="setTwoNumberDecimal" min="0" max="9999999" step="any" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;" value="0"></td>
                <td><input type="text" name="pro_remarks" style="width: 250px; height: 35px; border: 1px solid gray; border-radius: 5px;" value=""></td>
            </tr>
        </table>
        <br>
        <hr style=" border: 0;height: 1px;background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));">
        <p style="float: left;"><i>Fill out form with </i>&nbsp;<i style="color: red;">*</i></p><br>

        <div class="buttons">
            <button type="submit" class="button" name="add">Save</button>
        </div>
    </form>




</body>

</html>