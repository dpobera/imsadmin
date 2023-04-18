<?php 
// If po_edit-page.php delete button is set

  $poId = $_POST['poId'];
  $productId = $_POST['productId'];

  require 'php/config.php';

  mysqli_query($db, "DELETE FROM po_product WHERE po_id = '$poId' AND product_id = '$productId'");

  echo "poId" . $poId . "productId" . $productId;


if (isset($_GET['updated'])) {
  echo
  '<script>
alert("Successfully updated!");
location.href = "po_edit.php?editpo&id=' . $_GET['id'] . '";
</script>';
}
