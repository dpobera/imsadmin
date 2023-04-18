<?php
include "header.php";
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
include "php/config.php";
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];
    $result = mysqli_query($db, "SELECT * FROM product WHERE product_id=" . $_GET['id']);

    $row = mysqli_fetch_array($result);

    if ($row) {

        $id = $row['product_id'];
        $product_name = $row['product_name'];
        $class = $row['class_id'];
        $unit = $row['unit_id'];
        $pro_remarks = $row['pro_remarks'];
        $loc_id = $row['loc_id'];
        $barcode = $row['barcode'];
        $price = $row['price'];
        $cost = $row['cost'];
        $dept = $row['dept_id'];
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
            <h1 class="h2 text-secondary font-monospace"><?php echo $row['product_name']; ?></h1>
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
                            IMAGE UPLOAD
                        </div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" value="<?php echo str_pad($id, 8, 0, STR_PAD_LEFT) ?>" disabled>
                                <label for="floatingInput">PRODUCT ID#</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" value="<?php echo $product_name ?>" disabled>
                                <label for="floatingInput">PRODUCT NAME</label>
                            </div>
                            <?php
                            include "php/config.php";
                            $id = $_GET['id'];
                            if (isset($_POST['upload'])) {
                                // Get image name
                                $image = $_FILES['image']['name'];
                                // Get text
                                // $image_text = mysqli_real_escape_string($db, $_POST['image_text']);

                                // image file directory
                                $target = "D:/images/ITEMS/" . basename($image);

                                $sql = "INSERT INTO images (image, image_text,product_id,image_date) VALUES ('$image', ' ', '$id',NOW())";
                                // execute query
                                mysqli_query($db, $sql);

                                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                                    $msg = "Image uploaded ";
                                    echo
                                    '<script>
                                      alert("Upload successfully");
                                      location.href = "item-image.php?id=' . $_GET['id'] . '";
                                      </script>';
                                } else {
                                    $msg = "Failed to upload image";
                                }
                            }
                            ?>

                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="size" value="1000000">
                                <input type="hidden" name="id" value="<?php echo $id ?>">

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
                            IMAGE LIST
                        </div>
                        <div class="card-body responsive" id="display-image">
                            <div class="table-responsive" style="height:50vh;overflow-y:auto;overflow-x:auto;">
                                <?php

                                ?>
                                <?php
                                // Get images from the database
                                $query = $db->query("SELECT * FROM images WHERE product_id= $id ORDER BY id DESC");

                                if ($query->num_rows > 0) {
                                    while ($row = $query->fetch_assoc()) {

                                        $image = file_get_contents('D:/images/ITEMS/' . $row["image"]);
                                        $image_codes = base64_encode($image);

                                        $imageId = $row['id'];
                                        $dateString = $row["image_date"];
                                        $dateTimeObj = date_create($dateString);
                                        $date = date_format($dateTimeObj, 'M d, Y');
                                ?>

                                        <form action="item-image_delete.php" method="GET">
                                            <input type="hidden" name="imageId" value="<?php echo $imageId ?>">
                                            <input type="hidden" name="prodId" value="<?php echo $id ?>">
                                            <div class="text-center" style=" line-height: 50%;">

                                                <img class="justify-content-center" src="data:image/jpg;charset=utf-8;base64,<?php echo $image_codes; ?>" alt=" No Image Shown ">
                                                <p class="text-center"><?php echo  $row["image"]; ?></p>
                                                <p class="text-center"> <strong class="text-secondary">Uploaded:</strong> <?php echo  $date; ?></p>
                                                <a href="view/view-image.php?id=<?php echo $imageId ?>"><button class="btn btn-secondary bg-gradient btn-sm" type="button"> <i class="bi bi-printer-fill"></i> Print Picture</button></a>
                                                <button class="btn btn-danger bg-gradient btn-sm" name="delete" type="submit">
                                                    <i class="bi bi-trash3-fill"></i> Delete Picture</button>
                                                <hr>
                                            </div>
                                        </form>

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




<?php include "footer.php" ?>                            