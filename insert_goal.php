<?php
include "dblocal.php";

// Assuming the form data is sent using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the POST request
    $goalName = $_POST["goalName"];
    $targetAmount = $_POST["targetAmount"];
    $targetDate = $_POST["targetDate"];
    $status = $_POST["status"];
    $currentAmount = $_POST["currentAmount"];

    // Additional validation if needed

    // Retrieve User_id from the session
    session_start();
    $userId = $_SESSION['Id'];

    // Insert the new goal into the database
    $insertQuery = "INSERT INTO goals (User_id, Name, Target_amount, Target_dt, Status, Current_amount, Created_dt, Updated_dt) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
    $insertStmt = $conn->prepare($insertQuery);

    $insertStmt->bind_param("isissi", $userId, $goalName, $targetAmount, $targetDate, $status, $currentAmount);
    $insertStmt->execute();

    // Check for errors
    if ($insertStmt->error) {
        echo "Error inserting goal: " . $insertStmt->error;
    } else {
        // Successfully inserted, you might want to redirect or return a success message
        echo "Goal inserted successfully!";
    }

    // Close the prepared statement
    $insertStmt->close();
} else {
    // If the request method is not POST, handle accordingly (optional)
    echo "Invalid request method";
}
?>
