<?php
// Include your database connection script
include "dblocal.php";
session_start();
// Set up error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $newCategoryName = $_POST['newCategoryName'];

    // Set the default timezone to use when inserting timestamps
    date_default_timezone_set('UTC');

    // Get the current timestamp for both Created_dt and Updated_dt
    $currentTimestamp = date('Y-m-d H:i:s');

    // Assuming you have the user ID stored in a session variable
    $userId = $_SESSION['Id'];
    $insertQuery = "
    INSERT INTO category (Name, Created_dt, Updated_dt, User_id)
    VALUES (?, ?, ?, ?)
";

$insertStmt = $conn->prepare($insertQuery);

if (!$insertStmt) {
    echo "Error in preparing insert query: " . $conn->error;
    exit;
}

// Bind parameters and execute the insert query
$insertStmt->bind_param("sssi", $newCategoryName, $currentTimestamp, $currentTimestamp, $userId);
$insertStmt->execute();

// Check for errors
if ($insertStmt->error) {
    echo "Error in executing insert query: " . $insertStmt->error;
    exit;
}

// Close the prepared statement
$insertStmt->close();

// Send a success message back to the client
echo "Category inserted successfully";
} else {
    // If the request is not a POST request, handle accordingly (optional)
    echo "Invalid request method";
}
?>
