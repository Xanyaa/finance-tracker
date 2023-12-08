<?php
include "dblocal.php";

// Check if required parameters are set in the POST request
if (isset($_POST['budgetId'], $_POST['amount'], $_POST['startDate'], $_POST['endDate'], $_POST['categoryId'])) {
    // Sanitize the inputs to prevent SQL injection
    $budgetId = mysqli_real_escape_string($conn, $_POST['budgetId']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
    $endDate = mysqli_real_escape_string($conn, $_POST['endDate']);
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    // Prepare the update statement with the NOW() function for Updated_dt
    $updateQuery = "UPDATE budget SET Amount = ?, Start_dt = ?, End_dt = ?, Category_id = ?, Updated_dt = NOW() WHERE Id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    // Bind the parameters and execute the statement
    $updateStmt->bind_param("dssii", $amount,$startDate, $endDate, $categoryId, $budgetId);
    $updateStmt->execute();
    
    if ($updateStmt->execute()) {
        // Successfully updated data
        echo "Budget updated successfully!";
    } else {
        // Failed to update data
        echo "Error updating budget: " . $updateStmt->error;
    }

    $updateStmt->close();
} else {
    echo "Invalid request method";
}
?>
