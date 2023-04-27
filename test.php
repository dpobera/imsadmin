<table>
    <thead>
        <tr>
            <th></th>
            <th>Column 1</th>
            <th>Column 2</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Connect to the database
        $conn = mysqli_connect('localhost', 'root', '', 'inventorymanagement');

        // Query the database to retrieve the rows
        $result = mysqli_query($conn, "SELECT * FROM stin_tb ORDER BY stin_id DESC LIMIT 10");


        // Get the row ID and checkbox value from the AJAX request
        $stin_id = $_POST['stin_id'];
        $checked = $_POST['checked'];

        // Connect to the database
        $conn = mysqli_connect('localhost', 'root', '', 'inventorymanagement');

        // Update the row in the database
        mysqli_query($conn, "UPDATE stin_tb SET stin_code='$stin_code', stin_title='$stin_title' WHERE stin_id='$stin_id'");

        // Close the database connection
        mysqli_close($conn);

        // Loop through the rows and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr id='" . $row['stin_id'] . "'>";
            echo "<td><input type='checkbox' class='row-checkbox' value='" . $row['stin_id'] . "'></td>";
            echo "<td>" . $row['stin_code'] . "</td>";
            echo "<td>" . $row['stin_title'] . "</td>";
            echo "</tr>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        // Listen for clicks on the row checkboxes
        $('.row-checkbox').click(function() {
            // Get the ID of the row
            var stin_id = $(this).val();

            // Get the value of the checkbox (checked or unchecked)
            var checked = $(this).is(':checked');

            // Make an AJAX request to update the row
            $.ajax({
                url: 'update_row.php',
                type: 'POST',
                data: {
                    stin_id: stin_id,
                    checked: checked
                },
                success: function(response) {
                    // Handle the response from the server
                },
                error: function() {
                    // Handle any errors that occur during the request
                }
            });
        });
    });
</script>