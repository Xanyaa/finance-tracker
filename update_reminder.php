<?php
include "dblocal.php";

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are set in the POST data
    if (isset($_POST['reminderId'], $_POST['description'], $_POST['date'])) {
        // Sanitize and store the reminder details
        $reminderId = filter_var($_POST['reminderId'], FILTER_SANITIZE_NUMBER_INT);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $date = $_POST['date']; // Assuming the date is already in the correct format

        // Prepare an UPDATE statement
        $updateQuery = "UPDATE reminder SET Description = ?, Date = ?, Updated_dt = NOW() WHERE Id = ?";
        $updateStmt = $conn->prepare($updateQuery);

        if (!$updateStmt) {
            echo "Error in preparing update query: " . $conn->error;
            exit;
        }

        // Bind the parameters and execute the statement
        $updateStmt->bind_param("ssi", $description, $date, $reminderId);
        $updateStmt->execute();

        // Check for errors
        if ($updateStmt->error) {
            echo "Error in executing update query: " . $updateStmt->error;
            exit;
        }

        // Close the statement
        $updateStmt->close();

        // Respond with a success message
        echo "Reminder updated successfully.";
    } else {
        // If the required parameters are not set, respond with an error message
        echo "Error: Required parameters not provided.";
    }
} else {
    // If the request is not a POST request, respond with an error message
    echo "Error: Invalid request method.";
}
?>
