<?php
include('fetch/config.php');
$jo_no = $_POST['jo_no'];
$jo_id = $_POST['jo_id'];


$sql = "UPDATE `jo_tb` SET  `jo_no`='$jo_no'  WHERE jo_id='$jo_id' ";
$query = mysqli_query($con, $sql);
$lastId = mysqli_insert_id($con);
if ($query == true) {

    $data = array(
        'status' => 'true',

    );

    echo json_encode($data);
} else {
    $data = array(
        'status' => 'false',

    );

    echo json_encode($data);
}
