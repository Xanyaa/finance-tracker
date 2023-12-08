<?php
include "dblocal.php";

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are set in the POST data
    if (isset($_POST['description'], $_POST['date'])) {
        // Sanitize and store the reminder details
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $date = $_POST['date']; // Assuming the date is already in the correct format

        // Assuming you have the user ID stored in a session variable
        session_start();
        $userId = $_SESSION['Id'];

        // Set the default timezone to use when inserting timestamps
        date_default_timezone_set('UTC');

        // Get the current timestamp for both Created_dt and Updated_dt
        $currentTimestamp = date('Y-m-d H:i:s');

        // Prepare an INSERT statement
        $insertQuery = "INSERT INTO reminder (Description, Date, Created_dt, Updated_dt, User_id) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);

        if (!$insertStmt) {
            echo "Error in preparing insert query: " . $conn->error;
            exit;
        }

        // Bind the parameters and execute the statement
        $insertStmt->bind_param("ssssi", $description, $date, $currentTimestamp, $currentTimestamp, $userId);
        $insertStmt->execute();

        // Check for errors
        if ($insertStmt->error) {
            echo "Error in executing insert query: " . $insertStmt->error;
            exit;
        }

        // Close the statement
        $insertStmt->close();

        // Respond with a success message
        echo "Reminder inserted successfully.";
    } else {
        // If the required parameters are not set, respond with an error message
        echo "Error: Required parameters not provided.";
    }
} else {
    // If the request is not a POST request, respond with an error message
    echo "Error: Invalid request method.";
}
?>
