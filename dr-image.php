<?php
include "header.php";
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include "php/config.php";
if (isset($_GET['drNum']) && is_numeric($_GET['drNum']) && $_GET['drNum'] > 0) {

    $drNum = $_GET['drNum'];
    $custId = $_GET['custId'];

    $result = mysqli_query($db, "SELECT delivery_receipt.dr_id,delivery_receipt.dr_number,delivery_receipt.user_id,delivery_receipt.dr_date,user.user_name,jo_tb.jo_no,customers.customers_name
    FROM delivery_receipt
    LEFT JOIN dr_products ON dr_products.dr_number = delivery_receipt.dr_number
    LEFT JOIN jo_product ON dr_products.jo_product_id = jo_product.jo_product_id
    LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id
    LEFT JOIN customers ON jo_tb.customers_id = customers.customers_id
    LEFT JOIN user ON user.user_id = delivery_receipt.user_id 
    WHERE delivery_receipt.dr_number=" . $_GET['drNum']);

    $row = mysqli_fetch_array($result);

    if ($row) {

        $drId = $row['dr_id'];

        $custName = $row['customers_name'];
    } else {
        echo "No results!";
    }
}


?>
<style>
    thead {
        position: sticky;
        top: 0;
    }

    tbody:hover {
        color: red;
        cursor: pointer;
    }

    #display-image img {
        padding: 1%;
        margin: 5px;

        width: auto;
        height: 350px;

    }
</style>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
</svg>

<div class="container-fluid">
    <?php include "sidebar.php"; ?>
    <main class="col-md-9 ms-sm-auto col-md-10 px-md-4">
        <!-- Itemlist Records header-->
        <div class="d-flex justify-content-between flex-wrap align-items-center pt-3  mb-3 mt-2 p-3 border-bottom shadow-sm bg-light" style="background-color: #ededed;border:1px solid lightgrey">
            <h1 class="h2 text-secondary font-monospace"> CUSTOMER : <?php echo $custName; ?></h1>


            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="">
                    <!-- <button type="button" class="btn btn-sm btn-secondary">Print Image</button> -->
                    <div class="btn-group me-2">
                    </div>
                </div>
            </div>

        </div>

        <!-- Itemlist Records header END-->

        <div class="container-fluid shadow-sm mb-3 bg-light" style="background-color:#ededed;border:1px solid lightgrey;height:65vh;padding:3%">
            <div class="row">
                <div class="col-4">
                    <div class="card shadow">
                        <div class="card-header text-secondary font-monospace">
                            DR UPLOAD
                        </div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" value="<?php echo $drNum ?>" disabled>
                                <label for="floatingInput">DR NO.</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" value="<?php echo $row['jo_no'] ?>" disabled>
                                <label for="floatingInput">JO NO.</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" value="<?php
                                                                                                    $dateString = $row["dr_date"];
                                                                                                    $dateTimeObj = date_create($dateString);
                                                                                                    $date = date_format($dateTimeObj, 'M d, Y');

                                                                                                    echo $date ?>" disabled>
                                <label for="floatingInput">DR DATE</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" value="<?php echo $row['customers_name'] ?>" disabled>
                                <label for="floatingInput">Customer</label>
                            </div>
                            <?php
                            include "php/config.php";
                            $drNum = $_GET['drNum'];
                            $custId = $_GET['custId'];

                            if (isset($_POST['upload'])) {

                                // Get image name
                                $image = $_FILES['image']['name'];
                                // Get text


                                // image file directory
                                $target = "D:/images/PDR/" . basename($image);

                                $sql = "INSERT INTO dr_image (image,dr_text,dr_image_date,customers_id) VALUES ('$image','$drNum',NOW(),'$custId')";
                                // execute query
                                mysqli_query($db, $sql);

                                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                                    $msg = "Image uploaded ";
                                    echo
                                    '<script>
                                      alert("Upload successfully");
                                      location.href = "dr-image.php?drNum=' . $drNum . '&custId=' . $custId . '";
                                      </script>';
                                } else {
                                    $msg = "Failed to upload image";
                                }
                            }
                            ?>

                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="size" value="1000000">
                                <input type="hidden" name="drNum" value="<?php echo $drNum ?>">
                                <input type="hidden" name="custId" value="<?php echo $custId ?>">
                                <label class="text-secondary"></label>
                                <input class="form-control form-control" id="formFileSm" type="file" name="image" required>

                                <button class="btn btn-secondary bg-gradient btn mt-3 float-end" type="submit" name="upload">UPLOAD</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card shadow">
                        <div class="card-header text-secondary font-monospace">
                            DR IMAGE LIST
                        </div>
                        <div class="card-body responsive" id="display-image">
                            <div class="table-responsive" style="height:50vh;overflow-y:auto;overflow-x:auto;">
                                <?php

                                ?>
                                <?php
                                // Get images from the database
                                $query = $db->query("SELECT * FROM dr_image WHERE dr_text = $drNum ORDER BY id DESC");

                                if ($query->num_rows > 0) {
                                    while ($row = $query->fetch_assoc()) {

                                        $image = file_get_contents('D:/images/PDR/' . $row["image"]);
                                        $image_codes = base64_encode($image);



                                        $imageId = $row['id'];
                                        $dateString = $row["dr_image_date"];
                                        $dateTimeObj = date_create($dateString);
                                        $date = date_format($dateTimeObj, 'M d, Y');
                                ?>


                                        <div class="text-center" style=" line-height: 50%;">
                                            <img class="justify-content-center" src="data:image/jpg;charset=utf-8;base64,<?php echo $image_codes; ?>" alt=" No Image Shown ">
                                            <p class="text-center"><?php echo  $row["image"]; ?></p>
                                            <p class="text-center"> <strong class="text-secondary">Uploaded:</strong> <?php echo  $date; ?></p>
                                            <a href="view/view-dr-image.php?id=<?php echo $imageId ?>"><button class="btn btn-secondary bg-gradient btn-sm"> <i class="bi bi-printer-fill"></i> View / Print</button></a>
                                            <button class="btn btn-secondary bg-gradient btn-sm" name="deleteItem" onclick="alert('DI PA PWEDE INAAYOS PA!')">
                                                <i class="bi bi-trash3-fill"></i> Delete Picture</button>
                                            <hr>
                                        </div>

                                    <?php }
                                } else { ?>
                                    <div class="alert alert-dark d-flex align-items-center bg-gradient mt-5" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                            <use xlink:href="#exclamation-triangle-fill" />
                                        </svg>
                                        <div>
                                            No Image found ! Please upload.
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</main>




<?php include "footer.php" ?>