<?php
include "dblocal.php";

// Check if budgetId is set in the POST request
if (isset($_POST['budgetId'])) {
    // Sanitize the input to prevent SQL injection
    $budgetId = mysqli_real_escape_string($conn, $_POST['budgetId']);

    // Prepare the delete statement
    $deleteQuery = "DELETE FROM budget WHERE Id = ?";

    $deleteStmt = $conn->prepare($deleteQuery);

    if (!$deleteStmt) {
        echo "Error in preparing delete query: " . $conn->error;
        exit;
    }

    // Bind the parameter and execute the statement
    $deleteStmt->bind_param("i", $budgetId);
    $deleteStmt->execute();

    // Check for errors
    if ($deleteStmt->error) {
        echo "Error in executing delete query: " . $deleteStmt->error;
        exit;
    }

    // Close the prepared statement
    $deleteStmt->close();

    // Send a success response back to the client
    echo "success";
} else {
    // If budgetId is not set in the POST request, send an error response
    echo "Error: budgetId not provided";
}
?>
