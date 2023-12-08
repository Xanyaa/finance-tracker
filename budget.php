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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Finance Tracker</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="main-wrapper">
        <!-- -------------------------------------HEADER HEADER---------------------------------------  -->
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
                    <h3 class="text-primary">Components</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Budget</a></li>
                        <li class="breadcrumb-item active"><?php echo $_SESSION['Username']; ?></li>
                    </ol>
                </div>
            </div>
            <!-- --------------------------END BREAD CRUMB--------------------------------------- -->
            <div class="container-fluid">
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
                <?php
                // Fetch budget data for the logged-in user based on user's ID
                $budgetQuery = "
                    SELECT b.Id, b.Amount, b.Start_dt, b.End_dt, b.Updated_dt, b.Created_dt, b.User_id, b.Category_id, c.Name as CategoryName
                    FROM budget b
                    LEFT JOIN category c ON b.Category_id = c.Id
                    WHERE b.User_id = ?
                ";

                $budgetStmt = $conn->prepare($budgetQuery);

                if (!$budgetStmt) {
                    echo "Error in preparing budget query: " . $conn->error;
                    exit;
                }

                $budgetStmt->bind_param("i", $userId);
                $budgetStmt->execute();

                // Check for errors
                if ($budgetStmt->error) {
                    echo "Error in executing budget query: " . $budgetStmt->error;
                    exit;
                }

                $budgetResult = $budgetStmt->get_result();

                // Close the prepared statement
                $budgetStmt->close();
                ?>

                <!-- Display the budget table with dynamic data -->
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Budget Table</h2>
                        <h6 class="card-subtitle">Data table example</h6>
                        <div class="table-responsive m-t-40">
                            <table id="myBudgetTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Budget ID</th>
                                        <th>Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Category</th>
                                        <th>Updated Date</th>
                                        <th>Created Date</th>
                                        <th>Actions</th> <!-- New column for actions -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Loop through the fetched budget data and display it in the table
                                    while ($row = $budgetResult->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['Id'] . "</td>";
                                        echo "<td>" . $row['Amount'] . "</td>";
                                        echo "<td>" . $row['Start_dt'] . "</td>";
                                        echo "<td>" . $row['End_dt'] . "</td>";
                                        echo "<td>" . $row['CategoryName'] . "</td>";
                                        echo "<td>" . $row['Updated_dt'] . "</td>";
                                        echo "<td>" . $row['Created_dt'] . "</td>";

                                        // Add action buttons
                                        echo "<td class='dropdown'>";
                                        echo "<button class='btn btn-secondary dropdown-toggle' type='button' id='budgetDropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Actions</button>";
                                        echo "<div class='dropdown-menu' aria-labelledby='budgetDropdownMenuButton'>";
                                        echo "<a class='dropdown-item' href='#' onclick='deleteBudget(" . $row['Id'] . ")'>Delete</a>";
                                        echo "<a class='dropdown-item' href='#' onclick='updateBudget(" . $row['Id'] . ", " . $row['Amount'] . ", \"" . $row['End_dt'] . "\", " . $row['Category_id'] . ")' data-bs-toggle='modal' data-bs-target='#updateBudgetModal'>Edit</a>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Insert new Budget -->
                <div class="card mt-4" id="insertBudgetFormDiv">
                    <div class="card-body">
                        <h2 class="card-title">Insert New Budget</h2>
                        <form id="insertBudgetForm" action="insert_budget.php" method="post">
                            <div class="form-group">
                                <label for="budgetAmount">Amount:</label>
                                <input type="number" class="form-control" id="budgetAmount" name="budgetAmount" required>
                            </div>
                            <div class="form-group">
                                <label for="budgetStartDate">Start Date:</label>
                                <input type="date" class="form-control" id="budgetStartDate" name="budgetStartDate" required>
                            </div>
                            <div class="form-group">
                                <label for="budgetEndDate">End Date:</label>
                                <input type="date" class="form-control" id="budgetEndDate" name="budgetEndDate" required>
                            </div>
                            <div class="form-group">
                                <label for="budgetCategory">Category:</label>
                                <select class="form-control" id="budgetCategory" name="budgetCategory" required>
                                    
                                    <option value="0">--Please Select--</option>
                                        <?php
                                    // Fetch categories from the category table
                                    $categoryQuery = "SELECT Id, Name FROM category";
                                    $categoryResult = $conn->query($categoryQuery);

                                    while ($category = $categoryResult->fetch_assoc()) {
                                        echo "<option value='" . $category['Id'] . "'>" . $category['Name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <button type="button" class="btn btn-primary" onclick="insertBudget()">Insert Budget</button>
                            <!--<button type="submit" class="btn btn-primary">Insert Budget</button>-->
                        </form>
                    </div>
                </div>
                <!-- ----------------------------------MODAL FOR UPDATING BUDGET----------------------------- -->
                <div class="modal fade" id="updateBudgetModal" tabindex="-1" role="dialog" aria-labelledby="updateBudgetModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateBudgetModalLabel">Update Budget Entry</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="updateBudgetForm">
                                    <div class="form-group">
                                        <label for="updateAmount">Amount:</label>
                                        <input type="number" class="form-control" id="updateAmount" name="updateAmount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="updateStartDate">Start Date:</label>
                                        <input type="date" class="form-control" id="updateStartDate" name="updateStartDate" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="updateEndDate">End Date:</label>
                                        <input type="date" class="form-control" id="updateEndDate" name="updateEndDate" required>
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
                                    <input type="hidden" id="updateBudgetId" name="updateBudgetId">
                                    <button type="button" class="btn btn-primary" onclick="saveUpdatedBudget()">Save Changes</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- -----------------------------END CONTAINER FLUID------------------------------------- -->
        <!-- footer -->
        <footer class="footer"> © BSCS-5B All rights reserved. Template designed by <a href="about_us.php">usman-owais-sania</a></footer>
        <!-- End footer -->
        </div>
    <!-- -----------------------------END MAIN WRAPPER------------------------------------- -->

    

    <!-- ------------------------------- All Jquery --------------------------------------------- -->
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

    <!-- Datatables JavaScript -->
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            // DataTable initialization
            $('#myBudgetTable').DataTable();
            
            
            // Function to delete budget entry
            window.deleteBudget = function (budgetId) {
                if (confirm("Are you sure you want to delete this budget entry?")) {
                    // Call the deleteBudget.php script with the budget ID
                    $.post("delete_budget.php", { budgetId: budgetId }, function (data) {
                        if (data == "success") {
                            // Reload the page after successful deletion
                            location.reload();
                        } else {
                            alert("Error deleting budget entry. Please try again.");
                        }
                    });
                }
            };

            window.updateBudget = function (budgetId, amount,startDate, endDate, categoryId) {
                // Populate the modal with current data
                $("#updateBudgetId").val(budgetId);
                $("#updateAmount").val(amount);
                $("#updateStartDate").val(startDate);
                $("#updateEndDate").val(endDate);
                $("#updateCategory").val(categoryId);

                // Trigger the modal manually
                $("#updateBudgetModal").modal('show');
            };
            window.saveUpdatedBudget = function () {
                // Get data from the form
                var updateBudgetId = $("#updateBudgetId").val();
                var updateAmount = $("#updateAmount").val();
                var updateStartDate = $("#updateStartDate").val();
                var updateEndDate = $("#updateEndDate").val();
                var updateCategory = $("#updateCategory").val();

                // Call the update_budget.php script with the updated data
                $.post(
                    "update_budget.php",
                    {
                        budgetId: updateBudgetId,
                        amount: updateAmount,
                        startDate: updateStartDate,
                        endDate: updateEndDate,
                        categoryId: updateCategory
                    }
                    
                );
                $("#updateBudgetModal").modal('hide');
                window.location.reload();
            };
        });
            // Function to insert new budget entry
        function insertBudget() {
            var amount = $('#budgetAmount').val();
            var startDate = $('#budgetStartDate').val();
            var endDate = $('#budgetEndDate').val();
            var category = $('#budgetCategory').val();
            console.log("Amount:", amount);
            console.log("Start Date:", startDate);
            console.log("End Date:", endDate);
            console.log("Category:", category);
            // Perform validation here if needed (e.g., check if startDate < endDate)
            if(amount == ""){
                alert("Please select amount first");
            }
            else if(startDate == ""){
                alert("Please select start date to proceed");
            }
            
            else if(endDate == ""){
                alert("Please select end date to proceed");
            }
            else if(category == "0"){
                alert("Please select category");
            }
            else{
                $.ajax({
                type: 'POST',
                url: 'insert_budget.php',
                data: {
                    amount: amount,
                    start_date: startDate,
                    end_date: endDate,
                    category_id: category
                },
                success: function (response) {
                    // Reload the page after successful insertion
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                    alert('Error inserting budget. Please try again.');
                }
            });
            }
            
        }

        /*function closemodal(){
            $("#updateBudgetModal").hide();
        }*/

    </script>
</body>

</html>
