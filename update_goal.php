<?php
// Assuming you have the database connection
include 'dblocal.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $goalId = $_POST['goalId'];
    $goalName = $_POST['goalName'];
    $targetAmount = $_POST['targetAmount'];
    $targetDate = $_POST['targetDate'];
    $currentAmount = $_POST['currentAmount'];
    $status = $_POST['status'];

    // Validate form data (add your validation logic here)

    // Update data in the goal table
    $updateQuery = "UPDATE goals SET Name = ?, Target_amount = ?, Target_dt = ?, Current_amount = ?, Status = ?, Updated_dt = NOW() WHERE Id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sdsdsi", $goalName, $targetAmount, $targetDate, $currentAmount, $status, $goalId);

    if ($updateStmt->execute()) {
        // Successfully updated data
        echo "Goal updated successfully!";
    } else {
        // Failed to update data
        echo "Error updating goal: " . $updateStmt->error;
    }

    $updateStmt->close();
} else {
    echo "Invalid request method";
}
?>
