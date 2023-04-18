<?php 
// Get the last ID + 1 
include 'config.php';
$query = "SELECT order_id FROM order_tb ORDER BY order_id DESC LIMIT 1" ;  
$result = mysqli_query($db, $query);  

//if there's a value
if(mysqli_num_rows($result) > 0)  
{  
    while($row = mysqli_fetch_assoc($result)){
        //pass the value 
        $output = $row;

        echo json_encode($output);
    }

}  else {
        echo "{\"" ."order_id" ."\":\"" ."0\"}";
}

?>