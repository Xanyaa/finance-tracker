<?php
include "dblocal.php";

// Check if the incomeId is provided in the POST request
if (isset($_POST['incomeId'])) {
    // Sanitize the input to prevent SQL injection
    $incomeId = mysqli_real_escape_string($conn, $_POST['incomeId']);

    // Prepare and execute the delete query
    $deleteQuery = "DELETE FROM income WHERE Income_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);

    if (!$deleteStmt) {
        echo "Error in preparing delete query: " . $conn->error;
        exit;
    }

    $deleteStmt->bind_param("i", $incomeId);
    $deleteStmt->execute();

    // Check for errors
    if ($deleteStmt->error) {
        echo "Error in executing delete query: " . $deleteStmt->error;
        exit;
    }

    // Close the prepared statement
    $deleteStmt->close();

    // Return a success message or any relevant response
    echo "Income deleted successfully";
} else {
    // If incomeId is not provided, return an error message
    echo "Invalid request. IncomeId not provided.";
}
?>
