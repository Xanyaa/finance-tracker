<?php
include "dblocal.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are set in the POST data
    if (isset($_POST['incomeId'], $_POST['amount'], $_POST['description'], $_POST['receivedDate'], $_POST['category'])) {
        // Sanitize and store the income details
        $incomeId = filter_var($_POST['incomeId'], FILTER_SANITIZE_NUMBER_INT);
        $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $description = $_POST['description'];
        $receivedDate = $_POST['receivedDate'];
        $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

        // Assuming you have the user ID stored in a session variable
        session_start();
        $user_id = $_SESSION['Id'];

        // Prepare an UPDATE statement
        $updateQuery = "
            UPDATE income 
            SET Amount = ?, Description = ?, Received_dt = ?, Updated_dt = NOW(), Category_id = ?
            WHERE Income_id = ? AND User_id = ?
        ";
        $updateStmt = $conn->prepare($updateQuery);

        if (!$updateStmt) {
            echo "Error in preparing update query: " . $conn->error;
            exit;
        }

        // Bind the parameters and execute the statement
        $updateStmt->bind_param("dssiis", $amount, $description, $receivedDate, $category, $incomeId, $user_id);
        $updateStmt->execute();

        // Check for errors
        if ($updateStmt->error) {
            echo "Error in executing update query: " . $updateStmt->error;
            exit;
        }

        // Close the statement
        $updateStmt->close();

        // Respond with a success message
        echo "Income updated successfully.";
    } else {
        // If the required parameters are not set, respond with an error message
        echo "Error: Required parameters not provided.";
    }
} else {
    // If the request is not a POST request, respond with an error message
    echo "Error: Invalid request method.";
}
?>
