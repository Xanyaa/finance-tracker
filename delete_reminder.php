<?php
include "dblocal.php";

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'reminderId' parameter is set in the POST data
    if (isset($_POST['reminderId'])) {
        // Sanitize and store the reminder ID
        $reminderId = filter_var($_POST['reminderId'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare a DELETE statement
        $deleteQuery = "DELETE FROM reminder WHERE Id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);

        if (!$deleteStmt) {
            echo "Error in preparing delete query: " . $conn->error;
            exit;
        }

        // Bind the parameter and execute the statement
        $deleteStmt->bind_param("i", $reminderId);
        $deleteStmt->execute();

        // Check for errors
        if ($deleteStmt->error) {
            echo "Error in executing delete query: " . $deleteStmt->error;
            exit;
        }

        // Close the statement
        $deleteStmt->close();

        // Respond with a success message
        echo "Reminder deleted successfully.";
    } else {
        // If 'reminderId' is not set, respond with an error message
        echo "Error: Reminder ID not provided.";
    }
} else {
    // If the request is not a POST request, respond with an error message
    echo "Error: Invalid request method.";
}
?>
