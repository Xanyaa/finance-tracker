<?php
// Assuming you have the database connection
include 'dblocal.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $categoryId = $_POST['categoryId'];

    // Validate form data (add your validation logic here)

    // Delete data from the category table
    $deleteQuery = "DELETE FROM category WHERE Id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $categoryId);

    if ($deleteStmt->execute()) {
        // Successfully deleted data
        echo "Category deleted successfully!";
    } else {
        // Failed to delete data
        echo "Error deleting category: " . $deleteStmt->error;
    }

    $deleteStmt->close();
} else {
    echo "Invalid request method";
}
?>
