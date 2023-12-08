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
// Use $userId and $username to fetch and display user-specific data
} else {
    // Handle case where user information is not available
    echo "Invalid user information";
    //exit;
    header("Location: http://localhost/ElaAdmin-master/index.php");
    exit;
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Finance Tracker</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
    <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <!-- <b><img src="images\logo.png" alt="homepage" class="dark-logo" /></b> -->
                        <!-- End Logo icon -->
                        <!-- Logo text -->
                        <span><img src="images/FT-logo-text.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse justify-content-end"> <!-- Use justify-content-end to move items to the right -->
                    <!-- User profile and search -->
                    <ul class="navbar-nav">
                        <!-- Move the user profile to the right end -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="images/users/17.png" alt="user" class="profile-pic" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="javascript:;" data-toggle="modal" data-target="#changePassModal"><i class="ti-user"></i> Change Password</a></li>
                                    <li><a href="chart_balance.php"><i class="ti-wallet"></i> Balance</a></li>
                                    <!-- <li><a href="#"><i class="ti-email"></i> Inbox</a></li> -->
                                    <!-- <li role="separator" class="divider"></li> -->
                                    <li><a href="app-profile.php"><i class="ti-settings"></i> Setting</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->

        <!-- --------------------------------------LEFT SIDEBAR----------------------------------- -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Menu</li>

                        <li> <a href="main.php" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Home</span></a>
                        </li>
                        <li> <a href="app-profile.php" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Profile</span></a>
                        </li>

                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Transactions</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="table-income.php">Income</a></li>
                                <li><a href="table-expense.php">Expense</a></li>
                                <li><a href="gen-report.php">Generate Reports</a></li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Charts</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="chart_balance.php">Balance</a></li>
                                <li><a href="chart_income.php">Income</a></li>
                                <li><a href="chart_expense.php">Expense</a></li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Components <span class="label label-rouded label-danger pull-right">4</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="budget.php">Budget</a></li>
                                <li><a href="reminder.php">Reminder</a></li>
                                <li><a href="categories.php">Categories</a></li>
                                <li><a href="goals.php">Goals</a></li>
                            </ul>
                        </li>

                        <li> <a href="about_us.php" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">About Us</span></a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- -----------------------------END LEFT SIDEBAR---------------------------------------  -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- -------------------------START BREAD CRUMB-------------------------------------- -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Transactions</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Expense</a></li>
                        <li class="breadcrumb-item active"><?php echo $_SESSION['Username']; ?></li>
                    </ol>
                </div>
            </div>
            <!-- --------------------------END BREAD CRUMB--------------------------------------- -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <style>
    /* Customize the dropdown buttons */
    .income-action-btn {
        background-color: #3498db; /* Blue color for buttons */
        color: #fff; /* White text color */
        border: 1px solid #3498db; /* Blue border */
        margin-right: 5px; /* Add some margin between buttons */
    }

    .income-action-btn:hover {
        background-color: #3498db; /* Darker blue color on hover */
        border: 1px solid #2980b9; /* Darker blue border on hover */
    }

    /* Customize the dropdown menu */
    .dropdown-menu {
        background-color: #f8f9fa; /* Light gray background color */
        border: 1px solid #ced4da; /* Light gray border */
    }

    .dropdown-menu a {
        color: #3498db; /* Dark gray text color */
    }

    .dropdown-menu a:hover {
        background-color: #3498db; /* Lighter gray background on hover */
        color: #fff;
    }
</style>
            <!-- ..........................PHP-CODE.................................-->
            <?php
            // Assuming you have the user ID stored in a session variable
            $userId = $_SESSION['Id'];

            // Fetch income data for the logged-in user based on user's ID
            $expenseQuery = "
                SELECT e.Id, e.Amount, e.Description, e.Updated_dt, e.Created_dt, e.Received_dt, c.Name as CategoryName
                FROM expense e
                LEFT JOIN category c ON e.Category_Id = c.Id
                WHERE e.User_id = ?
            ";
            $expenseStmt = $conn->prepare($expenseQuery);

            if (!$expenseStmt) {
                echo "Error in preparing income query: " . $conn->error;
                exit;
            }

            $expenseStmt->bind_param("i", $userId);
            $expenseStmt->execute();

            // Check for errors
            if ($expenseStmt->error) {
                echo "Error in executing income query: " . $expenseStmt->error;
                exit;
            }

            $expenseResult = $expenseStmt->get_result();

            // Close the prepared statement
            $expenseStmt->close();
            ?>
            <!-- ..........................PHP-CODE.................................-->
            <!-- Display the expense table with dynamic data -->
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Expense Table</h2>
                    <h6 class="card-subtitle">Data table example</h6>
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Updated Date</th>
                                    <th>Created Date</th>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Actions</th> <!-- New column for actions -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop through the fetched expense data and display it in the table
                                while ($row = $expenseResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['Id'] . "</td>";
                                    echo "<td>" . $row['Amount'] . "</td>";
                                    echo "<td>" . $row['Description'] . "</td>";
                                    echo "<td>" . $row['Updated_dt'] . "</td>";
                                    echo "<td>" . $row['Created_dt'] . "</td>";
                                    echo "<td>" . $row['Received_dt'] . "</td>";
                                    echo "<td>" . $row['CategoryName'] . "</td>"; // New column for category name

                                    // Add action buttons
                                    echo "<td class='dropdown'>";
                                    echo "<button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Actions</button>";
                                    echo "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
                                    echo "<a class='dropdown-item' href='#' onclick='deleteExpense(" . $row['Id'] . ")'>Delete</a>";
                                    echo "<a class='dropdown-item' href='#' onclick='updateExpense(" . $row['Id'] . ")'>Edit</a>";
                                    echo "</div>";
                                    echo "</td>";

                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- insert expense -->
<div class="card mt-4" id="insertExpenseForm">
    <div class="card-body">
        <h2 class="card-title">Insert New Expense</h2>
        <form method="post" action="insert_expense.php">
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="received_date">Date:</label>
                <input type="date" class="form-control" id="received_date" name="received_date" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <!-- Fetch categories from the database and populate the dropdown -->
                <select class="form-control" id="category" name="category" required>
                    <?php
                    include "dblocal.php";
                    $categoryQuery = "SELECT * FROM category";
                    $categoryResult = $conn->query($categoryQuery);
                    while ($category = $categoryResult->fetch_assoc()) {
                        echo "<option value='" . $category['Id'] . "'>" . $category['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Insert Expense</button>
        </form>
    </div>
</div>

            <!-- ----------------------------------MODAL FOR UPDATING EXPENSE------------------------------- -->
            <div class="modal fade" id="updateExpenseModal" tabindex="-1" role="dialog" aria-labelledby="updateExpenseModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateExpenseModalLabel">Update Expense</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="updateExpenseForm">
                                <div class="form-group">
                                    <label for="updateAmount">Amount:</label>
                                    <input type="number" class="form-control" id="updateAmount" name="updateAmount" required>
                                </div>
                                <div class="form-group">
                                    <label for="updateDescription">Description:</label>
                                    <textarea class="form-control" id="updateDescription" name="updateDescription" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="updateReceivedDate">Date:</label>
                                    <input type="date" class="form-control" id="updateReceivedDate" name="updateReceivedDate" required>
                                </div>
                                <div class="form-group">
                                    <label for="updateCategory">Category:</label>
                                    <select class="form-control" id="updateCategory" name="updateCategory" required>
                                        <?php
                                        // Fetch categories from the category table
                                        $categoryResult = $conn->query($categoryQuery);

                                        while ($category = $categoryResult->fetch_assoc()) {
                                            echo "<option value='" . $category['Id'] . "'>" . $category['Name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" id="updateExpenseId" name="updateExpenseId">
                                <button type="button" class="btn btn-primary" onclick="updateExpenseSubmit()">Save Changes</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
        <!-- footer -->
        <footer class="footer"> © BSCS-5B All rights reserved. Template designed by <a href="about_us.php">usman-owais-sania</a></footer>
        <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
    <script>
        function deleteExpense(expenseId) {
            if (confirm('Are you sure you want to delete this expense?')) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_expense.php',
                    data: {
                        expenseId: expenseId
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                        alert('Error deleting expense. Please try again.');
                    }
                });
            }
        }
        function updateExpense(expenseId, amount, description, receivedDate, category) {
            $('#updateExpenseId').val(expenseId);
            $('#updateAmount').val(amount);
            $('#updateDescription').val(description);
            $('#updateReceivedDate').val(receivedDate);
            $('#updateCategory').val(category);

            // Trigger the modal manually
            $('#updateExpenseModal').modal('show');
        }
        function updateExpenseSubmit() {
            var expenseId = $('#updateExpenseId').val();
            var amount = $('#updateAmount').val();
            var description = $('#updateDescription').val();
            var receivedDate = $('#updateReceivedDate').val();
            var category = $('#updateCategory').val();
            console.log("Expense ID:", expenseId);
            console.log("Amount:", amount);
            console.log("Description:", description);
            console.log("Received Date:", receivedDate);
            console.log("Category:", category);
            // Perform validation if needed

            $.ajax({
                type: 'POST',
                url: 'update_expense.php',
                data: {
                    expenseId: expenseId,
                    amount: amount,
                    description: description,
                    receivedDate: receivedDate,
                    category: category
                },
                success: function (response) {
                    console.log(response); // Log the response for debugging
                    // Reload the page after successful update
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                    alert('Error updating expense. Please try again.');
                }
            });
        }
        function insertExpense() {
            // Implement code to trigger the insert form modal
            // For simplicity, you can redirect to an insert page
            window.location.href = 'insert_expense.php';
        }
    </script>
</body>
</html>