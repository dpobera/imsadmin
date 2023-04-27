<?php
include('../php/config.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

  $id = $_GET['id'];

  $result = mysqli_query($db, "SELECT stin_tb.stin_id,stin_tb.stin_code,stin_tb.stin_title,stin_tb.stin_date, employee_tb.emp_name
   FROM stin_tb
   LEFT JOIN employee_tb On employee_tb.emp_id = stin_tb.emp_id
    WHERE stin_id=" . $_GET['id']);


  $row = mysqli_fetch_array($result);

  if ($row) {
    $id = $row['stin_id'];
    $stin_code = $row['stin_code'];
    $stin_title = $row['stin_title'];
    $dateString = $row['stin_date'];
    $emp_name = $row['emp_name'];
    $dateTimeObj = date_create($dateString);
    $date = date_format($dateTimeObj, 'm/d/y');
  } else {
    echo "No results!";
  }
}
