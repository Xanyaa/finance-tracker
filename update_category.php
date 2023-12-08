<?php
include "dblocal.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you receive the categoryId and updatedName from the AJAX request
    $categoryId = $_POST['categoryId'];
    $updatedName = $_POST['updatedName'];

    // Get the current timestamp for Updated_dt
    $currentTimestamp = date('Y-m-d H:i:s');

    // Perform update query
    $updateQuery = "UPDATE category SET Name = ?, Updated_dt = ? WHERE Id = ?";
    $updateStmt = $conn->prepare($updateQuery);

    if (!$updateStmt) {
        echo "Error in preparing update query: " . $conn->error;
        exit;
    }

    $updateStmt->bind_param("ssi", $updatedName, $currentTimestamp, $categoryId);
    $updateStmt->execute();

    if ($updateStmt->error) {
        echo "Error in executing update query: " . $updateStmt->error;
        exit;
    }

    echo "Category updated successfully";
    $updateStmt->close();
} else {
    echo "Invalid request method";
}
?>
