<?php
// Step 1: Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventorymanagement";

$conn = mysqli_connect($servername, $username, $password, $dbname);



// Step 3: Populate form with existing data
$id = $_GET['id'];
$sql = "SELECT * FROM stin_tb WHERE stin_id=$id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $closed = $row["closed"];


    echo "<script>document.getElementsByName('firstname')[0].value = '$closed';</script>";
}


// Step 2: Create a form with input fields
echo "<form method='post'>";

echo "<input type='hidden' name='closed'  value='" . $row['closed'] . "'><br>";
echo "<input type='submit' name='submit' value='CLOSE TRANSACTION'>";
echo "</form>";

// Step 5: Update database on form submission
if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $closed = $_POST['closed'];


    $sql = "UPDATE stin_tb SET closed='1' WHERE stin_id=$id";
    mysqli_query($conn, $sql);

    header('Location: ../../stin-index.php');
    exit;
}

// Step 6: Close database connection
mysqli_close($conn);
