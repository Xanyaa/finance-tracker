<?php
include "dblocal.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] != 1) {
    header("Location: http://localhost/ElaAdmin-master/index.php");
    exit;
}

// Retrieve user information from the session
if (isset($_SESSION['Id'], $_SESSION['Username'])) {
    $userId = $_SESSION['Id'];
    $username = $_SESSION['Username'];
} else {
    echo "Invalid user information";
    header("Location: http://localhost/ElaAdmin-master/index.php");
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $receivedDate = filter_input(INPUT_POST, 'received_date', FILTER_SANITIZE_STRING);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);

    // Get current timestamp for created and updated dates
    $currentTimestamp = date('Y-m-d H:i:s');

    // Insert income into the database
    $insertIncomeQuery = "INSERT INTO income (Amount, Description, Received_dt, Category_Id, User_Id, Created_dt, Updated_dt) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insertIncomeStmt = $conn->prepare($insertIncomeQuery);
    $insertIncomeStmt->bind_param("dssisss", $amount, $description, $receivedDate, $category, $userId, $currentTimestamp, $currentTimestamp);

    if ($insertIncomeStmt->execute()) {
        // Income inserted successfully
        header("Location: http://localhost/ElaAdmin-master/table-income.php");
        exit;
    } else {
        // Error in inserting income
        echo "Error: " . $conn->error;
    }

    $insertIncomeStmt->close();
}

$conn->close();
?>
