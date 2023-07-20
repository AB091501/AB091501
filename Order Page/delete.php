<?php
include "connection.php";
// Check if the orderId parameter is present in the POST request
if (isset($_POST['orderId'])) {
    // Retrieve the customId value from the POST request
    $orderId = $_POST['orderId'];

    // Perform the necessary operations to delete the row with the given orderId from the database
    // Replace this with your actual database code

    // Assuming you are using MySQLi
    $query = "DELETE FROM customer_order WHERE orderId = '$orderId'";
    $result = mysqli_query($con, $query);

    // Check if the deletion was successful
    if ($result) {
        // Return a success message as the response
        echo "success";
    } else {
        // Return an error message as the response
        echo "failed";
    }
} else {
    // Return an error message if the customId parameter is not present
    echo "missing parameter";
}
?>