<?php
// Assuming you have a database connection established in $conn

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $amount = $_POST["amount"];
    $description = $_POST["description"];
    $receivedDate = $_POST["received_date"];
    $categoryId = $_POST["category_id"];
    $userId = $_SESSION["Id"]; // Assuming you have the user ID stored in a session variable

    // Insert data into the income table
    $insertQuery = "INSERT INTO income (Amount, Description, Received_dt, category_id, User_id) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);

    if (!$insertStmt) {
        die("Error in preparing insert query: " . $conn->error);
    }

    $insertStmt->bind_param("dssii", $amount, $description, $receivedDate, $categoryId, $userId);
    $insertStmt->execute();

    // Check for errors
    if ($insertStmt->error) {
        die("Error in executing insert query: " . $insertStmt->error);
    }

    // Close the prepared statement
    $insertStmt->close();

    // Redirect back to the page containing the income table
    header("Location: income_page.php"); // Change "income_page.php" to the actual filename
    exit;
}
?>
