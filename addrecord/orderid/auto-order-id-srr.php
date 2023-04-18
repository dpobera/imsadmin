<?php 

include '../../../php/config.php';
$query = "SELECT srr_id FROM srr_tb ORDER BY srr_id DESC LIMIT 1" ;  
$result = mysqli_query($db, $query);   
if(mysqli_num_rows($result) > 0)  
{  
    while($row = mysqli_fetch_assoc($result)){
        $newOrderId = $row['srr_id'] + 1;
        echo "<input style='border:none; font-weight:bolder; color:grey;' name='srr_id' value='" .$newOrderId ."'>" ;
    }

}  else {
        echo "No result.";
}

?>