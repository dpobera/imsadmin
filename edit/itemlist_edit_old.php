<?php

include('../php/config.php');

if (isset($_POST['submit']))
{
$id=$_POST['id'];
$product_name=mysqli_real_escape_string($db, $_POST['product_name']);
$class=mysqli_real_escape_string($db, $_POST['class_id']);
$unit=mysqli_real_escape_string($db, $_POST['unit_id']);
$pro_remarks=mysqli_real_escape_string($db, $_POST['pro_remarks']);
$loc_id=mysqli_real_escape_string($db, $_POST['loc_id']);
$barcode=mysqli_real_escape_string($db, $_POST['barcode']);
$price=mysqli_real_escape_string($db, $_POST['price']);
$cost=mysqli_real_escape_string($db, $_POST['cost']);
$dept=mysqli_real_escape_string($db, $_POST['dept_id']);

mysqli_query($db,"UPDATE product SET product_name='$product_name', class_id='$class',unit_id='$unit' ,pro_remarks='$pro_remarks',loc_id='$loc_id' ,barcode='$barcode' ,price='$price',cost='$cost' ,dept_id='$dept' WHERE product_id='$id'");



header("Location:../main/itemlist_main.php");
}


if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{

$id = $_GET['id'];

$result = mysqli_query($db,"SELECT product.product_id, product.product_name, class_tb.class_name, product.qty, unit_tb.unit_name, product.pro_remarks, loc_tb.loc_name, product.barcode, product.price, product.cost, dept_tb.dept_name
FROM product
LEFT JOIN class_tb ON product.class_id = class_tb.class_id
LEFT JOIN unit_tb ON product.unit_id = unit_tb.unit_id
LEFT JOIN loc_tb ON product.loc_id = loc_tb.loc_id
LEFT JOIN dept_tb ON product.dept_id = dept_tb.dept_id WHERE product_id=".$_GET['id']);

$row = mysqli_fetch_array($result);

if($row)
{

$id = $row['product_id'];
$product_name = $row['product_name'];
$class = $row['class_name'];
$unit = $row['unit_name'];
$pro_remarks = $row['pro_remarks'];
$loc_id = $row['loc_name'];
$barcode = $row['barcode'];
$price = $row['price'];
$cost = $row['cost'];
$dept = $row['dept_name'];


}
else
{
echo "No results!";
}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<title>EDIT | <?php echo $product_name;?></title>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/editform.css">
<style>
 button {
  background-color: midnightblue;
  color: white;
  padding: 7px 12px;
  letter-spacing: 3px;
  cursor: pointer;
 }
</style>
</head>
<body>

   <div class="container">
     <a href="../main/itemlist_main.php"><i class="fa fa-close" style="font-size:24px; float:right"></i></a>
        <h1>EDITING RECORDS&nbsp;<i class="fa fa-pencil" style="font-size:36px"></i> </h1>
        <hr style=" border: 0;height: 1px;background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));">
<br><br>
 <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <table class="items1" style=" width: 100%; border-collapse: collapse;">
                <tr>
                    <th width="50%">Item Name</th>
                    <th width="25%">Class</th>
                    <th width="25%">Unit</th>
                </tr>

                <tr>
                    <td><input type="text" name="product_name" value="<?php echo $product_name; ?>" /></td>
                    <td>
                        <select name="class_id">
                            <option><?php echo $_GET['className'];?></option>
                                <?php
                                    include "config.php";  
                                    $records = mysqli_query($db, "SELECT * FROM class_tb");  
                                    while($data = mysqli_fetch_array($records))
                                    {
                                        echo "<option value='". $data['class_id'] ."'>" .$data['class_name'] ."</option>";  
                                    } 
                                ?> 
                            
                            </select>
                    </td>
                    <td>
                        <select name="unit_id">
                            <option><?php echo $_GET['unit'];?></option>
                                <?php
                                    include "config.php";  
                                    $records = mysqli_query($db, "SELECT * FROM unit_tb");  

                                    while($data = mysqli_fetch_array($records))
                                    {
                                        echo "<option value='". $data['unit_id'] ."'>" .$data['unit_name'] ."</option>";  
                                    } 
                                ?> 
                            </select>
                    </td>
                </tr>
            </table><br>

            <table class="items1" style=" width: 100%; border-collapse: collapse;">
                <tr>
                    <th width="50%">Remarks</th>
                    <th width="25%">Location</th>
                    <th width="25%">Barcode</th>
                </tr>
                <tr>
                    <td><input type="text" name="pro_remarks" value="<?php echo $pro_remarks; ?>" /></td>
                    <td>
                        <select name="loc_id">
                            <option><?php echo $_GET['loc'];?></option>
                                <?php
                                    include "config.php";  
                                    $records = mysqli_query($db, "SELECT * FROM loc_tb");  

                                    while($data = mysqli_fetch_array($records))
                                    {
                                        echo "<option value='". $data['loc_id'] ."'>" .$data['loc_name'] ."</option>";  
                                    } 
                                ?>  
                            </select>
                    </td>
                    <td><input type="text" class="form-control" name="barcode" value="<?php echo $barcode; ?>" /></td>
                </tr>
            </table><br>

            <table class="items1" style=" width: 100%; border-collapse: collapse;">
                <tr>
                    <th width="50%">Price</th>
                    <th width="25%">Cost</th>
                    <th width="25%">Department</th>
                </tr>
                <tr>
                    <td><input type="number" name="price" value="<?php echo $price; ?>" /></td>
                    <td><input type="number" name="cost" value="<?php echo $cost; ?>" /></td>
                    <td>
                        <select name="dept_id">
                            <option><?php echo $_GET['dept'];?></option>
                                <?php
                                    include "config.php";  
                                    $records = mysqli_query($db, "SELECT * FROM dept_tb ORDER BY dept_id DESC LIMIT  0,6");  

                                    while($data = mysqli_fetch_array($records))
                                    {
                                        echo "<option value='". $data['dept_id'] ."'>" .$data['dept_name'] ."</option>";  
                                    } 
                                ?> 
                                
                            </select>
                    </td>
                </tr>
            </table>
        <br> <br>
        <button name="submit">Update</button>
    </form><br><br><br><br>




        <hr style=" border: 0;height: 1px;background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));">
   </div>
</body>



</html>
