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
   // $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING);
    //$startDate = filter_input(INPUT_POST, 'startDate', FILTER_SANITIZE_STRING);
    //$endDate = filter_input(INPUT_POST, 'endDate', FILTER_SANITIZE_STRING);
    //$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);

    $amount = $_REQUEST['amount'];

    $startDate = $_REQUEST['start_date'];
    $endDate = $_REQUEST['end_date'];
    $category = $_REQUEST['category_id'];

    // Get current timestamp for created and updated dates
    $currentTimestamp = date('Y-m-d H:i:s');

    // Insert expense into the database

    
    $sql = "INSERT INTO budget (Id, Amount, Start_dt, End_dt, Updated_dt, Created_dt, User_id, Category_id)
    VALUES ('0', '$amount', '$startDate', '$endDate', '$currentTimestamp','$currentTimestamp', '$userId', '$category')";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("Location: http://localhost/ElaAdmin-master/budget.php");
    exit;
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    header("Location: http://localhost/ElaAdmin-master/budget.php");
    exit;
    }

    $conn->close();

/*
    $insertExpenseQuery = "INSERT INTO budget(Amount, Start_dt, End_dt, Updated_dt, Created_dt, User_id, Category_id) VALUES (?, ?, ?, ?, ?, ?)";
    echo $insertExpenseQuery;
    $insertExpenseStmt = $conn->prepare($insertExpenseQuery);
    $insertExpenseStmt->bind_param("dssssii", $amount, $startDate, $endDate, $currentTimestamp, $currentTimestamp,$userId, $category);

    if ($insertExpenseStmt->execute()) {
        // Expense inserted successfully
        header("Location: http://localhost/ElaAdmin-master/table-expense.php");
        exit;
    } else {
        // Error in inserting expense
        echo "Error: " . $conn->error;
    }

    $insertExpenseStmt->close();
    */
}
/*
// Check if the request is a POST request  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are set in the POST data
    if (isset($_POST['amount'], $_POST['start_date'], $_POST['end_date'], $_POST['category_id'])) {
        // Sanitize and store the budget details
        $amount = $_POST['amount'];
        $start_date = $_POST['start_date']; // Assuming the date is already in the correct format
        $end_date = $_POST['end_date']; // Assuming the date is already in the correct format
        $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
        
        // Assuming you have the user ID stored in a session variable
        session_start();
        $user_id = $_SESSION['Id'];

        // Set the default timezone to use when inserting timestamps
        date_default_timezone_set('UTC');

        // Get the current timestamp for both Created_dt and Updated_dt
        $currentTimestamp = date('Y-m-d H:i:s');
        // Prepare an INSERT statement
        $insertQuery = "
            INSERT INTO budget (Amount, Start_dt, End_dt, Created_dt, Updated_dt, User_id, Category_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)
            ";

        $insertStmt = $conn->prepare($insertQuery);

        if (!$insertStmt) {
            echo "Error in preparing insert query: " . $conn->error;
            exit;
        }

        // Bind the parameters and execute the statement
        $insertStmt->bind_param("dssssii", $amount, $start_date, $end_date, $currentTimestamp, $currentTimestamp, $user_id, $category_id);
        $insertStmt->execute();

        // Check for errors
        if ($insertStmt->error) {
            echo "Error in executing insert query: " . $insertStmt->error;
            exit;
        }

        // Close the statement
        $insertStmt->close();

        // Respond with a success message
        echo "Budget inserted successfully.";
    } else {
        // If the required parameters are not set, respond with an error message
        echo "Error: Required parameters not provided";
    }
} else {
    // If the request is not a POST request, respond with an error message
    echo "Error: Invalid request method.";
}
*/
?>
