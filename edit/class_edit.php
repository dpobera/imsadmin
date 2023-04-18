<!DOCTYPE html>
<html lang="en">
<?php

include('../php/config.php');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $class_name = $_POST['class_name'];
    $dept_id = $_POST['dept_id'];

    mysqli_query($db, "UPDATE class_tb SET class_name='$class_name', dept_id ='$dept_id' WHERE class_id='$id'");
    echo "<script type='text/javascript'>alert('Update Records Successfully!');
    location.href = '../utilities/addclass.php'</script>";



    // header("Location:../itemlist_main.php");
}



if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];

    $result = mysqli_query($db, "SELECT
    class_tb.class_id,class_tb.class_name,dept_tb.dept_name,dept_tb.dept_id
    FROM class_tb
    LEFT JOIN dept_tb ON dept_tb.dept_id = class_tb.dept_id
      WHERE class_tb.class_id=" . $_GET['id']);

    $row = mysqli_fetch_array($result);

    if ($row) {
        $class_id = $row['class_id'];
    } else {
        echo "No results!";
    }
}
?>
<?php include('../main_header_v2.php'); ?>
<div class="container-sm mt-2">
    <a class="back-button" href="../utilities/addclass.php">
        <p class="mt-3" style="float:right;padding:2%"><i class="bi bi-backspace"></i> Back to Classlist</p>
    </a>
    <div class="shadow-lg p-5 mb-5 bg-rounded" style="background-color: white;border: 5px solid #cce0ff">
        <h3 style="color: #0d6efd;"> Classification: Editing Records</h3>
        <hr>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="row">

                <div class="col-7">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="class_name" value="<?php echo $row['class_name']; ?>">
                        <label for="floatingInput">Class Name</label>
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-floating mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="dept_id">
                                <option class="select__option--class" value="<?php echo $row['dept_id']; ?>"><?php echo $row['dept_name']; ?></option>
                                <?php
                                include "config.php";
                                $records = mysqli_query($db, "SELECT * FROM dept_tb");

                                while ($data = mysqli_fetch_array($records)) {
                                    echo "<option value='" . $data['dept_id'] . "'>" . $data['dept_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="floatingSelect">Department</label>
                        </div>
                    </div>
                </div>

            </div>


            <button type="submit" class="btn btn-primary" name="submit"><i class="bi bi-check2-circle"></i> Update Records</button>
        </form>
    </div>
</div>
<form method="POST">

    <input type="hidden" name="id" value="<?php echo $id; ?>" />