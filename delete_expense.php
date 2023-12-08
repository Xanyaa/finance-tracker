<?php
include "dblocal.php";

// Check if the expenseId is provided in the POST request
if (isset($_POST['expenseId'])) {
    // Sanitize the input to prevent SQL injection
    $expenseId = mysqli_real_escape_string($conn, $_POST['expenseId']);

    // Prepare and execute the delete query
    $deleteQuery = "DELETE FROM expense WHERE Id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);

    if (!$deleteStmt) {
        echo "Error in preparing delete query: " . $conn->error;
        exit;
    }

    $deleteStmt->bind_param("i", $expenseId);
    $deleteStmt->execute();

    // Check for errors
    if ($deleteStmt->error) {
        echo "Error in executing delete query: " . $deleteStmt->error;
        exit;
    }

    // Close the prepared statement
    $deleteStmt->close();

    // Return a success message or any relevant response
    echo "Expense deleted successfully";
} else {
    // If expenseId is not provided, return an error message
    echo "Invalid request. ExpenseId not provided.";
}
?>
