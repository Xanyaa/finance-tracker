<?php
// Assuming you have the database connection
include 'dblocal.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $goalId = $_POST['goalId'];

    // Validate form data (add your validation logic here)

    // Delete data from the goal table
    $deleteQuery = "DELETE FROM goals WHERE Id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $goalId);

    if ($deleteStmt->execute()) {
        // Successfully deleted data
        echo "Goal deleted successfully!";
    } else {
        // Failed to delete data
        echo "Error deleting goal: " . $deleteStmt->error;
    }

    $deleteStmt->close();
} else {
    echo "Invalid request method";
}
?>
