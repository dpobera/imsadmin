<?php

include('../php/config.php');


$id = $_GET['id'];
$pay = $_GET['cashPay'];
echo
'<script>
   
    location.href = "ac_reciept.php?id=' . $id . ' ?>";
</script>';
